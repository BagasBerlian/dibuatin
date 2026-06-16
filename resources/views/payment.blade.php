<x-app-layout>
    <span
        class="bg-[#E67E22] w-[55rem] h-[55rem] rounded-full inline-block blur-3xl opacity-20 absolute -mt-[30rem] -ml-[30rem] -z-10"></span>
    <span
        class="bg-[#3498DB] w-[15rem] h-[25rem] rounded-l-full inline-block blur-[150px] opacity-50 absolute -mt-[15rem] end-0 -z-10"></span>
    <span
        class="bg-[#8E44AD] w-[25rem] h-[25rem] rounded-l-full inline-block blur-[170px] opacity-30 absolute translate-y-[70%] end-0 bottom-0 -z-10"></span>
    <span
        class="bg-[#3498DB] w-[15rem] h-[15rem] rounded-full inline-block blur-[170px] opacity-30 absolute translate-y-[90%] translate-x-[-10%] bottom-0 -z-10"></span>

    <div class="container w-1/2 mt-24 mx-auto text-center">
        <div class="relative flex flex-row items-center justify-between">
            <!-- Langkah 1 -->
            <div class="relative flex flex-col items-center bg-white-100 z-10">
                <div class="relative w-20 h-20">
                    <div
                        class="bg-orange-500 text-white rounded-full w-16 h-16 flex items-center justify-center text-xl font-bold shadow-md absolute top-2 left-2 z-10">
                        1
                    </div>
                </div>
                <h4 class="text-gray-900 font-semibold">
                    Detail Project</h4>
            </div>
            <hr class="w-1/4 border-2 mb-6">
            <!-- Langkah 2 -->
            <div class="relative flex flex-col items-center bg-white-100 z-10">
                <div class="relative w-20 h-20">
                    <div
                        class="bg-orange-500 text-white rounded-full w-16 h-16 flex items-center justify-center text-xl font-bold shadow-md absolute top-2 left-2 z-10">
                        2
                    </div>
                </div>
                <h4 class="text-gray-900 font-semibold">Payment</h4>
            </div>
            <hr class="w-1/4 border-2 mb-6">
            <!-- Langkah 3 -->
            <div class="relative flex flex-col items-center bg-white-100 z-10">
                <div class="relative w-20 h-20">
                    <div
                        class="bg-gray-400 text-white rounded-full w-16 h-16 flex items-center justify-center text-xl font-bold shadow-md absolute top-2 left-2 z-10">
                        3
                    </div>
                </div>
                <h4 class="text-gray-900 font-semibold">
                    Transaction History</h4>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mx-24 my-16">
        <!-- Left Side: Order Details -->
        <div class="flex flex-col gap-6">
            <div class="bg-white w-full h-fit p-8 rounded-xl shadow-lg">
                <div class="flex flex-row justify-between items-center border-b pb-4 mb-4">
                    <h2 class="font-bold text-lg text-gray-700">Order ID</h2>
                    <h2 class="text-lg font-mono text-orange-500">
                        {{ session('order_id') }}
                    </h2>
                </div>
                
                <h2 class="font-bold text-xl mb-4 text-gray-800">Customer Identity</h2>
                <div class="flex flex-col gap-3">
                    <div class="flex justify-between border-b border-gray-100 pb-2">
                        <span class="text-gray-600">Name</span>
                        <span class="font-medium text-gray-900">{{ $order->user->name }}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-100 pb-2">
                        <span class="text-gray-600">Email</span>
                        <span class="font-medium text-gray-900">{{ $order->user->email }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">No Telephone</span>
                        <span class="font-medium text-gray-900">{{ $order->user->phone }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white w-full h-fit p-8 rounded-xl shadow-lg">
                <h2 class="font-bold text-xl mb-4 text-gray-800">Detail Project</h2>
                <div class="flex flex-col gap-3">
                    <div class="flex justify-between border-b border-gray-100 pb-2">
                        <span class="text-gray-600">Package</span>
                        <span class="font-medium text-gray-900">{{ $order->package->name }}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-100 pb-2">
                        <span class="text-gray-600">Orientation</span>
                        <span class="font-medium text-gray-900 capitalize">{{ $order->orientation }}</span>
                    </div>
                    <div class="flex flex-col mt-2">
                        <span class="text-gray-600 mb-1">Request:</span>
                        <p class="font-medium text-gray-900 bg-gray-50 p-3 rounded-lg border border-gray-100">{{ $order->request }}</p>
                    </div>
                </div>
            </div>

            <!-- Sandbox Simulator Notice -->
            <div class="bg-white w-full h-fit p-6 rounded-xl shadow-lg border-2 border-orange-100 flex flex-col gap-3">
                <h2 class="font-bold text-lg text-gray-800">Payment Simulator</h2>
                <p class="text-gray-600 text-sm">
                    This order is in sandbox mode. You can simulate a successful payment using the Midtrans Simulator.
                </p>
                <a href="https://simulator.sandbox.midtrans.com/" target="_blank" rel="noopener noreferrer" 
                    class="mt-2 text-center bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    Open Simulator
                </a>
            </div>
        </div>

        <!-- Right Side: Midtrans Snap Payment UI -->
        <div class="flex items-start justify-center lg:justify-end">
            <!-- Container for Snap embed. Giving it a fixed width is recommended by Midtrans for embed mode -->
            <div id="snap-container" class="w-full max-w-[600px] h-fit bg-white rounded-xl shadow-xl overflow-hidden border border-gray-200 min-h-[600px]">
                <!-- Snap interface loads here -->
            </div>
        </div>
    </div>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script type="text/javascript">
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            let bgColor = 'bg-green-500';
            if (type === 'error') bgColor = 'bg-red-500';
            if (type === 'warning') bgColor = 'bg-orange-500';
            
            toast.className = `fixed top-10 right-10 z-50 px-6 py-3 rounded-lg shadow-xl font-semibold text-white transition-opacity duration-300 ${bgColor} flex items-center gap-2`;
            
            // Add icon
            if (type === 'success') {
                toast.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg> <span>${message}</span>`;
            } else {
                toast.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg> <span>${message}</span>`;
            }

            document.body.appendChild(toast);
            
            // Fade out and remove
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        window.onload = function initMidtrans() {
            window.snap.embed('{{ $snapToken }}', {
                embedId: 'snap-container',
                onSuccess: function(result) {
                    storeData(result.order_id, result.payment_type, result.transaction_id, result.transaction_status);
                },
                onPending: function(result) {
                    console.log(result);
                    showToast("Waiting for your payment to complete...", "warning");
                },
                onError: function(result) {
                    console.log(result);
                    showToast("Payment failed!", "error");
                }
            });
        }

        function storeData(a, b, c, d) {
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Prepare data
            const order_id = a;
            const payment_method = b;
            const transaction_id = c;
            let transaction_status = (d == 'capture' || d == 'settlement') ? 'paid' : 'unpaid';

            // Send data to the backend
            fetch('{{ route('payment.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        order_id: order_id,
                        payment_method: payment_method,
                        transaction_id: transaction_id,
                        transaction_status: transaction_status
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Success:', data);
                    showToast('Payment successful! Redirecting to history...', 'success');
                    setTimeout(() => {
                        window.location.href = "{{ route('history.show') }}";
                    }, 2000);
                })
                .catch((error) => {
                    console.error('Error:', error);
                    showToast("Error saving transaction data", "error");
                });
        }
    </script>
</x-app-layout>
