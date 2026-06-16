@foreach ($packages as $package)
<div class="flex flex-col relative">
    <input class="peer sr-only" id="package_{{ $package->id }}" name="package_id"
        value="{{ $package->id }}" type="radio" />
    <div
        class="flex flex-col w-full h-full p-4 cursor-pointer rounded-xl border-2 border-gray-300 bg-gray-50 transition-transform duration-150 hover:border-blue-400 active:scale-95 peer-checked:border-blue-500 peer-checked:shadow-md peer-checked:shadow-blue-400">
        <label class="cursor-pointer peer-checked:text-blue-500" for="package_{{ $package->id }}">
            <h2 class="text-xl font-medium">{{ $package->name }}</h2>
            <h2 class="text-orange-500 font-bold py-3 text-4xl">IDR
                {{ number_format($package->price, 0, ',', '.') }}
            </h2>
            <h2 class="leading-5 mb-4 text-left">{{ $package->detail_package }}</h2>
            <div class="mb-20">
                @foreach ($benefits as $benefit)
                @if ($benefit->packages_id == $package->id)
                <div class="flex flex-row">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="currentColor" class="size-6 mr-2">
                        <path fill-rule="evenodd"
                            d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                            clip-rule="evenodd" />
                    </svg>
                    <h2>{{ $benefit->benefit }}</h2>
                </div>
                @endif
                @endforeach
            </div>
            <div class="text-right absolute right-0 bottom-0 m-6">
                <p class="text-gray-600 -mb-1">
                    Working Time
                </p>
                <h2 class="text-gray-700 text-xl font-bold">
                    {{ $package->working_time }} {{ $package->unit }}
                </h2>
            </div>
        </label>
    </div>
</div>
@endforeach
