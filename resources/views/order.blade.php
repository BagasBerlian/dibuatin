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
                        class="bg-gray-400 text-white rounded-full w-16 h-16 flex items-center justify-center text-xl font-bold shadow-md absolute top-2 left-2 z-10">
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

    <form method="GET" action="{{ route('order.show') }}">
        @csrf
        <div class="flex mx-24 border-1 border-gray-200 bg-gray-200 rounded-xl mt-16 mb-4 select-none">
            @foreach ($products as $product)
            <label class="radio flex flex-grow items-center justify-center rounded-lg p-1 cursor-pointer">
                <input type="radio" name="product_type" value="{{ $product->id }}" class="peer hidden product-type-radio"
                    {{ request('product_type', 1) == $product->id ? 'checked' : '' }} />
                <span
                    class="w-full py-2 text-center text-xl peer-checked:bg-orange-500 peer-checked:font-semibold peer-checked:text-white p-2 rounded-lg transition duration-150 ease-in-out">
                    {{ $product->name }}
                </span>
            </label>
            @endforeach
        </div>
    </form>
    <form action="{{ route('order.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-2 gap-4 mx-24">
            <div class="col-span-2">
                <label for="request" class="block text-gray-700 text-lg font-bold mb-2">
                    Request
                </label>
                <textarea rows="7" placeholder="Enter the type of request for your Ads" id="content" name="requestInput"
                    class="shadow appearance-none border-2 border-gray-100 rounded-xl w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    required></textarea>
            </div>
            <div class="col-span-2">
                <label for="orientation" class="block text-gray-700 text-lg font-bold mb-2">
                    Orientation
                </label>
                <select
                    class="shadow appearance-none border-2 border-gray-100 rounded-lg w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    name="orientation" required>
                    <option value="" disabled selected>Choose Orientation</option>
                    <option value="portrait">Portrait</option>
                    <option value="landscape">Landscape</option>
                </select>
            </div>
        </div>

        <div class="mx-24 mt-8 text-center">
            <h2 class="text-gray-700 text-2xl font-bold">
                Package
            </h2>
            <p class="text-gray-600 mb-4">
                Pick your ideal package and let us bring your vision to life
            </p>

            <div class="grid grid-cols-4 md:grid-cols-3 gap-8 p-2 mx-24" id="packages-container">
                @include('partials.packages')
            </div>


            <div class="w-full flex justify-end space-x-3 mt-8 mb-40">
                <button
                    class="bg-transparent w-60 py-[0.45rem] rounded-lg text-orange-500 border-2 border-orange-500 hover:bg-orange-700 focus:bg-orange-900 hover:border-orange-700 focus:border-orange-900 hover:text-white focus:text-white"
                    onclick="window.location.href='/services'">Cancel</button>
                <button class="bg-orange-500 w-60 py-2 rounded-lg text-white hover:bg-orange-700 focus:bg-orange-900"
                    type="submit" id="pay-button">Next</button>
            </div>
        </div>
    </form>

    <script>
        document.querySelectorAll('.product-type-radio').forEach(radio => {
            radio.addEventListener('change', function() {
                const packagesContainer = document.getElementById('packages-container');
                packagesContainer.style.opacity = '0.5';

                const url = new URL(window.location.href);
                url.searchParams.set('product_type', this.value);

                fetch(url.toString(), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    packagesContainer.innerHTML = html;
                    packagesContainer.style.opacity = '1';
                    window.history.pushState({}, '', url);
                })
                .catch(error => {
                    console.error('Error fetching packages:', error);
                    packagesContainer.style.opacity = '1';
                });
            });
        });
    </script>
</x-app-layout>