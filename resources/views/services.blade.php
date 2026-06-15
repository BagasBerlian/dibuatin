<x-app-layout>
    <span
        class="bg-[#E67E22] w-[55rem] h-[55rem] rounded-full inline-block blur-3xl opacity-20 absolute -mt-[30rem] -ml-[30rem] -z-10"></span>
    <span
        class="bg-[#3498DB] w-[15rem] h-[25rem] rounded-l-full inline-block blur-[150px] opacity-50 absolute -mt-[15rem] end-0 -z-10"></span>
    <span
        class="bg-[#8E44AD] w-[25rem] h-[25rem] rounded-l-full inline-block blur-[170px] opacity-30 absolute translate-y-[70%] end-0 bottom-0 -z-10"></span>
    <span
        class="bg-[#3498DB] w-[15rem] h-[15rem] rounded-full inline-block blur-[170px] opacity-50 absolute translate-y-[90%] translate-x-[-10%] bottom-0 -z-50"></span>

    <div class="flex flex-col gap-2 py-28 mt-24 px-14">
        <h2 class="text-[5rem] mb-3 leading-[1.15]">
            Our Expert Services That <br> Drive Results
        </h2>
        <p class="text-sm text-gray-600 mb-5">
            Partner with us to access
            expert-driven solutions designed to
            elevate your brand, achieve your
            goals,
            and make a meaningful impact.
        </p>
        <hr class="border-2 border-orange-200 w-40">
    </div>

    <div class="py-8 px-14">
        <!-- Professional Design Services -->
        <x-expert-service imagePosition="right" title="Professional Design Services"
            desc="Elevate your brand with our comprehensive design services. From professional logos and business cards to engaging brochures and lanyards, our creative solutions are crafted to meet your unique needs. Let us help you create a lasting impression and drive measurable results for your business."
            icon1="Creative Excellence" icon2="Customizable Design" icon3="High Quality" icon4="Fast Turnaround"
            image="/images/product_service.webp">
        </x-expert-service>
    </div>
</x-app-layout>
