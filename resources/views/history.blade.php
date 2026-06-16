<x-app-layout>
    <span
        class="bg-[#E67E22] w-[55rem] h-[55rem] rounded-full inline-block blur-3xl opacity-20 absolute -mt-[30rem] -ml-[30rem] -z-10"></span>
    <span
        class="bg-[#3498DB] w-[15rem] h-[25rem] rounded-l-full inline-block blur-[150px] opacity-50 absolute -mt-[15rem] end-0 -z-10"></span>
    <span
        class="bg-[#8E44AD] w-[25rem] h-[25rem] rounded-l-full inline-block blur-[170px] opacity-30 absolute translate-y-[70%] end-0 bottom-0 -z-10"></span>
    <span
        class="bg-[#3498DB] w-[15rem] h-[15rem] rounded-full inline-block blur-[170px] opacity-30 absolute translate-y-[90%] translate-x-[-10%] bottom-0 -z-10"></span>

    <h1 class="mx-24 mt-28 mb-6 text-3xl font-semibold text-gray-800">Transaction History</h1>

    <div class="mx-24 mb-16">
        @php
            $groupedOrders = $orders->groupBy(function($order) {
                return $order->created_at->format('F Y');
            });
        @endphp

        @forelse ($groupedOrders as $month => $monthOrders)
            <div class="mb-10">
                <h2 class="text-xl font-bold text-orange-500 mb-4 border-b-2 border-orange-200 pb-2">{{ $month }}</h2>
                <div class="space-y-6">
                    @foreach ($monthOrders as $order)
                        <div class="bg-white bg-opacity-80 backdrop-blur-md rounded-2xl p-6 border border-gray-100 shadow-lg hover:shadow-xl transition-shadow duration-300">
                            <!-- Card Header -->
                            <div class="flex justify-between items-center mb-4">
                                <div class="flex items-center space-x-4">
                                    <div class="p-3 bg-orange-100 rounded-lg text-orange-500">
                                        <!-- Icon SVG -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-800">{{ $order->package->product->name ?? 'Product' }}</h3>
                                        <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex flex-col items-end space-y-2">
                                    @if ($order->status == 'completed')
                                        <span class="px-4 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full border border-green-200">{{ ucwords($order->status) }}</span>
                                    @elseif ($order->status == 'in progress')
                                        <span class="px-4 py-1 text-xs font-semibold bg-yellow-100 text-yellow-700 rounded-full border border-yellow-200">{{ ucwords($order->status) }}</span>
                                    @else
                                        <span class="px-4 py-1 text-xs font-semibold bg-blue-100 text-blue-700 rounded-full border border-blue-200">{{ ucwords($order->status) }}</span>
                                    @endif

                                    @if($order->transaction)
                                        <span class="text-xs font-medium text-gray-500">
                                            Payment: 
                                            <span class="{{ in_array($order->transaction->payment_status, ['settlement', 'capture', 'success']) ? 'text-green-600' : 'text-orange-500' }}">
                                                {{ ucwords($order->transaction->payment_status) }}
                                            </span>
                                        </span>
                                    @else
                                        <span class="text-xs font-medium text-gray-500">Payment: <span class="text-red-500">Unpaid</span></span>
                                    @endif
                                </div>
                            </div>
                            
                            <hr class="border-gray-200 mb-4">
                            
                            <!-- Card Body -->
                            <div class="flex justify-between items-end">
                                <div class="space-y-1">
                                    <p class="text-gray-700"><span class="font-semibold text-gray-900">Package:</span> {{ $order->package->name ?? '-' }}</p>
                                    <p class="text-gray-700"><span class="font-semibold text-gray-900">Orientation:</span> {{ ucfirst($order->orientation) }}</p>
                                    <p class="text-gray-700"><span class="font-semibold text-gray-900">Request:</span> {{ Str::limit($order->request, 60) }}</p>
                                </div>
                                <div class="flex flex-col items-end space-y-3">
                                    <div class="text-right">
                                        <p class="text-sm text-gray-500 mb-1">Total Amount</p>
                                        <p class="text-2xl font-bold text-orange-500">IDR {{ number_format($order->price, 0, ',', '.') }}</p>
                                    </div>

                                    @php
                                        $isPaid = $order->transaction && in_array($order->transaction->payment_status, ['settlement', 'capture', 'success', 'paid']);
                                        $isInProgress = $order->status === 'in progress';
                                        $isPending = $order->status === 'pending';
                                        $hasProject = $order->project !== null;
                                        $worker = $order->project?->user;
                                    @endphp

                                    {{-- Paid + In Progress + Worker Assigned --}}
                                    @if ($isPaid && $isInProgress && $hasProject && $worker)
                                        @php
                                            $phone = preg_replace('/\D/', '', $worker->phone ?? '');
                                            if (str_starts_with($phone, '0')) {
                                                $phone = '62' . substr($phone, 1);
                                            }
                                            $waMessage = rawurlencode(
                                                "Halo {$worker->name}, saya ingin menanyakan status progress dari pesanan saya.\n\n" .
                                                "*Detail Order:*\n" .
                                                "- Produk: " . ($order->package->product->name ?? '-') . "\n" .
                                                "- Paket: " . ($order->package->name ?? '-') . "\n" .
                                                "- Orientasi: " . ucfirst($order->orientation) . "\n" .
                                                "- Request: " . $order->request . "\n\n" .
                                                "Terima kasih atas kerjasamanya."
                                            );
                                        @endphp
                                        <a href="https://wa.me/{{ $phone }}?text={{ $waMessage }}"
                                           target="_blank"
                                           class="flex items-center space-x-2 bg-green-500 hover:bg-green-600 text-white text-sm font-semibold px-4 py-2 rounded-xl transition-all duration-200 shadow-md hover:shadow-green-300"
                                           title="Chat worker di WhatsApp">
                                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                                                <path d="M11.998 0C5.372 0 0 5.372 0 12c0 2.117.555 4.1 1.523 5.82L0 24l6.335-1.652C8.01 23.35 9.965 24 11.998 24 18.626 24 24 18.626 24 12c0-6.627-5.374-12-12.002-12zm0 21.818c-1.848 0-3.592-.5-5.101-1.369l-.364-.217-3.785.986.998-3.674-.237-.378A9.772 9.772 0 0 1 2.18 12c0-5.417 4.403-9.818 9.818-9.818 5.416 0 9.819 4.401 9.819 9.818 0 5.416-4.403 9.818-9.819 9.818z"/>
                                            </svg>
                                            <span>Hubungi Worker</span>
                                        </a>

                                    {{-- Paid + In Progress + No Project/Worker yet --}}
                                    @elseif ($isPaid && $isInProgress && !$hasProject)
                                        <div class="relative group flex items-center">
                                            <button disabled
                                                class="flex items-center space-x-2 bg-gray-200 text-gray-400 text-sm font-semibold px-4 py-2 rounded-xl cursor-not-allowed"
                                                title="Menunggu worker">
                                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                                                    <path d="M11.998 0C5.372 0 0 5.372 0 12c0 2.117.555 4.1 1.523 5.82L0 24l6.335-1.652C8.01 23.35 9.965 24 11.998 24 18.626 24 24 18.626 24 12c0-6.627-5.374-12-12.002-12zm0 21.818c-1.848 0-3.592-.5-5.101-1.369l-.364-.217-3.785.986.998-3.674-.237-.378A9.772 9.772 0 0 1 2.18 12c0-5.417 4.403-9.818 9.818-9.818 5.416 0 9.819 4.401 9.819 9.818 0 5.416-4.403 9.818-9.818 9.818z"/>
                                                </svg>
                                                <span>Hubungi Worker</span>
                                            </button>
                                            {{-- Tooltip --}}
                                            <div class="absolute bottom-full right-0 mb-2 hidden group-hover:flex items-center z-50">
                                                <div class="bg-gray-800 text-white text-xs rounded-lg px-3 py-2 whitespace-nowrap shadow-lg">
                                                    Sedang menunggu worker menerima project Anda
                                                    <div class="absolute top-full right-4 border-4 border-transparent border-t-gray-800"></div>
                                                </div>
                                            </div>
                                        </div>

                                    {{-- Unpaid + Pending: show resume payment button --}}
                                    @elseif ($isPending && !$isPaid)
                                        <a href="{{ route('payment.resume', $order->id) }}"
                                           class="flex items-center space-x-2 bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold px-4 py-2 rounded-xl transition-all duration-200 shadow-md hover:shadow-orange-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                            </svg>
                                            <span>Lanjutkan Pembayaran</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="text-center py-16 bg-white bg-opacity-80 backdrop-blur-md rounded-2xl border-2 border-dashed border-gray-300">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                <h3 class="mt-2 text-sm font-semibold text-gray-900">No transactions</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating a new order.</p>
                <div class="mt-6">
                    <a href="{{ route('services') }}" class="inline-flex items-center rounded-md bg-orange-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-orange-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-orange-600">
                        <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                        </svg>
                        New Order
                    </a>
                </div>
            </div>
        @endforelse

        <!-- Pagination Links -->
        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    </div>
</x-app-layout>
