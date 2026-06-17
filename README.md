# Dibuatin

Dibuatin adalah platform web mutakhir yang dibangun menggunakan **Laravel** dan **Filament PHP**. Proyek ini ditujukan untuk mempermudah alur kerja pemesanan paket, manajemen proyek, pelacakan transaksi pembayaran, serta kolaborasi file antara Admin, Worker, dan Pengguna (Klien).

## 🚀 Fitur Utama

- **Role-Based Access Control (RBAC):** Pemisahan hak akses dan dasbor khusus untuk `Admin`, `Worker`, dan Pengguna biasa menggunakan Filament.
- **Manajemen Pesanan & Proyek:** Lacak status pesanan (*order*), paket (*package*), dan proyek yang sedang berjalan.
- **Penyimpanan Berbasis Cloud:** Terintegrasi penuh dengan **Supabase S3** untuk penyimpanan *file upload* yang aman dan terpusat.
- **Payment Gateway:** Terintegrasi dengan **Midtrans** untuk memproses pembayaran secara real-time dan aman.
- **Siap Deployment Vercel:** Proyek ini sudah dikonfigurasi untuk *serverless deployment* di Vercel.

## 🛠️ Tech Stack

- **Framework:** Laravel 11.x, PHP 8.3+
- **Database:** PostgreSQL (didukung oleh [Neon DB](https://neon.tech/))
- **Admin Panel:** [Filament PHP](https://filamentphp.com/) (Livewire & Alpine.js)
- **File Storage:** [Supabase Storage](https://supabase.com/storage) (S3-Compatible)
- **Payment Gateway:** [Midtrans](https://midtrans.com/)
- **Deployment:** Vercel (menggunakan `vercel-php`)

## ⚙️ Persyaratan Sistem

- PHP >= 8.3
- Composer
- Node.js & NPM (untuk *asset build*)
- PostgreSQL

## 💻 Instalasi Lokal

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di mesin lokal Anda (misalnya menggunakan Laravel Herd atau XAMPP):

1. **Kloning Repositori**
   ```bash
   git clone https://github.com/username-anda/dibuatin.git
   cd dibuatin
   ```

2. **Instalasi Dependensi PHP & Node**
   ```bash
   composer install
   npm install && npm run build
   ```

3. **Pengaturan Environment**
   Salin file `.env.example` menjadi `.env` lalu buat *Application Key*:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi Variabel `.env`**
   Buka file `.env` dan isi kredensial berikut:
   - **Database (Neon DB):**
     ```env
     DB_CONNECTION=pgsql
     DB_HOST=ep-...aws.neon.tech
     DB_PORT=5432
     DB_DATABASE=dibuatin
     DB_USERNAME=neondb_owner
     DB_PASSWORD=secret
     DB_SSLMODE=require
     ```
   - **S3 / Supabase Storage:**
     ```env
     FILESYSTEM_DISK=s3
     LIVEWIRE_TMP_DISK=public
     AWS_ACCESS_KEY_ID=kunci_access_anda
     AWS_SECRET_ACCESS_KEY=kunci_secret_anda
     AWS_DEFAULT_REGION=ap-southeast-1
     AWS_BUCKET=dibuatin
     AWS_ENDPOINT=https://[project-id].storage.supabase.co/storage/v1/s3
     AWS_USE_PATH_STYLE_ENDPOINT=true
     ```
   - **Midtrans:**
     ```env
     MIDTRANS_MERCHANT_ID=...
     MIDTRANS_CLIENT_KEY=...
     MIDTRANS_SERVER_KEY=...
     MIDTRANS_PRODUCTION=false
     ```

5. **Migrasi Database & Seeder**
   ```bash
   php artisan migrate --seed
   ```

6. **Jalankan Server Lokal**
   ```bash
   php artisan serve
   ```
   Akses aplikasi pada `http://localhost:8000` dan dasbor admin di `http://localhost:8000/admin`.

## 🌐 Panduan Deployment (Vercel)

Aplikasi ini menggunakan file `vercel.json` di *root* direktori untuk pengaturan *environment* saat tahap produksi.

Untuk *deploy* ke Vercel:
1. Pastikan Anda sudah menginstal Vercel CLI (`npm i -g vercel`).
2. Jalankan perintah `vercel --prod` di terminal.
3. Kredensial penting (Database, S3, Midtrans) dapat diatur langsung di dalam dashboard Vercel pada bagian **Environment Variables** (Sangat disarankan demi keamanan) atau bisa dimuat sementara di dalam konfigurasi `vercel.json`.

---
*Dibuatin - Bringing your digital projects to life.*
