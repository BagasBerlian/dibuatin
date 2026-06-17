# Dibuatin - Technical Architecture & Overview

🌍 **Live Deployment:** [https://dibuatin-three.vercel.app](https://dibuatin-three.vercel.app)

Dibuatin adalah platform web untuk pemesanan layanan digital yang dibangun dengan **Laravel 11** dan **Filament PHP**. Dokumen ini berfokus pada detail teknis, arsitektur sistem, dan alur kerja fungsionalitas utama (terutama berfokus pada integrasi pihak ketiga dan struktur *serverless*).

## 1. Arsitektur Sistem

Karena aplikasi ini dikembangkan untuk berjalan di lingkungan *serverless* (Vercel), seluruh state aplikasi, penyimpanan *file*, dan *database* harus didesain sepenuhnya *stateless* (tidak bergantung pada penyimpanan lokal).

- **Framework Core:** Laravel 11.x berjalan pada PHP 8.3+ menggunakan `vercel-php`.
- **Database Layer:** PostgreSQL yang di-*host* di [Neon DB](https://neon.tech/), terhubung secara aman dengan parameter koneksi *SSL-required* dan *Connection Pooling*.
- **Object Storage:** Terintegrasi menggunakan Driver S3 (*League Flysystem*) menuju **Supabase Storage**.
- **Admin Panel & UI:** Menggunakan [Filament PHP](https://filamentphp.com/) (mengandalkan Livewire dan Alpine.js) dengan penerapan *Multiple Panels* untuk RBAC.
- **Payment Gateway:** Terhubung dengan API **Midtrans** (menggunakan *Snap* dan HTTP *Webhook Callback*).

## 2. Struktur Database & Entitas Inti

Relasi antar model diatur secara ketat untuk mendukung alur pemesanan yang otomatis:

- **User:** Diatur berdasarkan peran atau `role` (`admin`, `worker`, `user`).
- **Package & BenefitPackage:** Master data untuk produk/layanan yang ditawarkan.
- **Order & Transaction:** Menangani *lifecycle* pembelian klien. `Order` mencatat data pesanan mentah, sedangkan `Transaction` mengelola *state* pembayaran (misal: *pending*, *settlement*, *expire*).
- **Project:** Secara otomatis/manual di-generate dari `Order` yang pembayarannya telah lunas. Proyek ini akan di-*assign* ke `worker` spesifik.
- **File:** Merepresentasikan *deliverable* pekerjaan. Terhubung (`BelongsTo`) ke entitas `Project` dan `User` (Worker).

## 3. Role-Based Access Control (Filament Panels)

Sistem menggunakan penerapan *Multi-panel* Filament untuk mengamankan akses data:
1. **Admin Panel** (`/admin`): Memiliki wewenang CRUD penuh atas pengguna, transaksi, pembuatan paket, serta pendelegasian proyek ke *worker*.
2. **Worker Panel** (`/worker`): Dasbor dengan lingkup terbatas (`UploadFileResource`). Hanya bisa melihat proyek yang ditugaskan kepada mereka dan dapat mengunggah file hasil kerja ke proyek tersebut. Akses direstriksi melalui manipulasi *Eloquent Builder* di tingkat *Resource*.

## 4. Mekanisme File Upload & Integrasi Supabase S3

Lingkungan *serverless* Vercel bersifat *ephemeral* (direktori sementara `/tmp` hilang setelah *request* selesai). Hal ini menuntut perancangan *file handling* yang khusus:

- **Livewire Temporary Uploads:** Direktori sementara Livewire telah diarahkan agar bisa kompatibel dengan sistem perutean S3/lokal, guna menghindari kegagalan penyimpanan file karena hilangnya *local tmp*.
- **Hook pada Eloquent Model (`App\Models\File`):**
  - **Event `creating`:** Mengintersepsi file yang diunggah untuk menamai ulang (*rename*) secara terstruktur. Format otomatis yang digunakan: `slug(nama_paket - nama_klien)-timestamp.ekstensi`. Ini memastikan URL file rapi dan seragam.
  - **Event `created`:** Memindahkan file dari lokasi `temp` Livewire ke direktori S3 tujuan (`folder_paket/nama_file`). 
  - **Fallback Stream Copy:** Terdapat modifikasi teknis untuk melewati fungsi bawaan `move()` milik S3 Flysystem dengan cara *stream copy* manual (`readStream` -> `writeStream`). Ini dirancang khusus karena *gateway* Supabase S3 sering kali menolak *request* `CopyObject` API standar dari AWS SDK.

## 5. Integrasi Payment Gateway (Midtrans)

- **Snap Token Generation:** Saat Pengguna melakukan validasi pesanan, *backend* akan mengirimkan detail *payload* pesanan ke API Midtrans untuk mendapatkan *Snap Token*.
- **Callback / Webhook Notification:** *Endpoint* khusus dibuat dan dikecualikan dari *CSRF verification* untuk menerima notifikasi asinkron dari Midtrans. Apabila notifikasi menyatakan `settlement` atau `capture`, *backend* secara otomatis mengubah *status* transaksi dan merilis alur kerja selanjutnya (misalnya: pembuatan entitas `Project`).

## 6. Vercel Serverless Routing (`vercel.json`)

Agar *routing* Laravel berfungsi optimal dan *assets* terbaca di Vercel:
- *Request* menuju `public/build`, `public/css`, `public/images` dicegat (*intercept*) oleh *static routing* Vercel untuk dikirim via CDN.
- Sisa *request* selain aset statis diarahkan secara *catch-all* menuju `/api/index.php` yang menampung kernel *bootstraping* Laravel. Variabel environment kritis juga diatur atau dirujuk melalui file konfigurasi ini.
