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
    <form action="{{ route('payment.store') }}" method="post" id="payment">
        <div class="grid grid-cols-2 gap-8 mx-24 my-16">
            <div class="bg-white w-full h-fit p-8 rounded-md shadow-lg">
                <div class="flex flex-row mb-4">
                    <h2 class="font-bold text-lg w-1/4">Order ID</h2>
                    <h2 class="w-full text-lg inline-block align-middle text-right">
                        {{ session('order_id') }}
                    </h2>
                </div>
                <input type="text" value="{{ session('order_id') }}" name="order_id" hidden>
                <h2 class="font-bold w-full text-2xl mb-8">Identity</h2>
                <div class="flex flex-row py-1">
                    <h2 class="text-gray-800">Name:</h2>
                    <h2 class="w-full text-2xl text-right font-medium">{{ $order->user->name }}</h2>
                </div>
                <div class="flex flex-row py-1">
                    <h2 class="w-full text-gray-800">Email:</h2>
                    <h2 class="text-right text-2xl font-medium">{{ $order->user->email }}</h2>
                </div>
                <div class="flex flex-row py-1">
                    <h2 class="w-full text-gray-800">No Telephone:</h2>
                    <h2 class="text-2xl font-medium">{{ $order->user->phone }}</h2>
                </div>
            </div>
            <div class="row-span-4 flex w-full pr-[30%] mb-[50%] rounded-xl translate-x-1/4" id="snap-container">
            </div>
            <div class="bg-white w-full h-fit p-8 rounded-md shadow-lg">
                <h2 class="font-bold w-full text-2xl mb-8 align-middle">Detail Project</h2>
                <div class="flex flex-row py-1">
                    <h2 class="text-gray-800 flex items-center">Request:</h2>
                    <h2 class="w-full ms-20 text-right text-lg font-medium">{{ $order->request }}</h2>
                </div>
                <div class="flex flex-row py-1">
                    <h2 class="w-full text-gray-800">Orientation:</h2>
                    <h2 class="text-right text-2xl font-medium">{{ $order->orientation }}</h2>
                </div>
                <div class="flex flex-row py-1">
                    <h2 class="w-1/2 text-gray-800">Package:</h2>
                    <h2 class="w-full text-right text-2xl font-medium">{{ $order->package->name }}</h2>
                </div>
            </div>
        </div>
    </form>
    <script type="text/javascript" src="https://app.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script type="text/javascript">
        window.onload = function initMidtrans() {
            window.snap.embed('{{ $snapToken }}', {
                embedId: 'snap-container',
                onSuccess: function(result) {
                    storeData(result.order_id, result.payment_type, result.transaction_id, result
                        .transaction_status);
                    let dashboardUrl = "{{ route('history.show') }}";
                    window.location.href = dashboardUrl;
                },
                onPending: function(result) {
                    /* You may add your own implementation here */
                    console.log(result);
                    alert("wating your payment!");
                },
                onError: function(result) {
                    /* You may add your own implementation here */
                    alert("payment failed!");
                    console.log(result);
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
                    // alert('Data stored successfully');
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        }
    </script>
</x-app-layout>
