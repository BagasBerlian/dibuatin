<nav x-data="{ open: false }"
    class="bg-transparent backdrop-blur-[0.5rem] shadow-md mb-8 fixed top-0 left-0 right-0 z-50">
    <!-- Primary Navigation Menu -->
    <div
        class="max-w-9xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Navigation Links -->
                <div
                    class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @if(Auth::check())
                    <x-nav-link
                        :href="route('dashboard')"
                        :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    @else
                    <x-nav-link
                        :href="route('home')"
                        :active="request()->routeIs('home')">
                        {{ __('Home') }}
                    </x-nav-link>
                    @endif
                    <x-nav-link
                        :href="route('services')"
                        :active="request()->routeIs('services')">
                        {{ __('Services') }}
                    </x-nav-link>
                    <x-nav-link
                        :href="route('gallery')"
                        :active="request()->routeIs('gallery')">
                        {{ __('Gallery') }}
                    </x-nav-link>
                </div>

                <!-- Logo -->
                <div
                    class="absolute left-1/2 transform -translate-x-1/2 flex items-center h-full">
                    <a
                        href="{{ route('dashboard') }}">
                        <x-application-logo
                            class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div
                class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                <!-- Dropdown for authenticated users -->
                <x-dropdown align="right"
                    width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-black bg-transparent hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>
                                {{ Auth::user()->name }}
                            </div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link
                            :href="route('history.show')">
                            {{ __('Transaction History') }}
                        </x-dropdown-link>

                        <x-dropdown-link
                            :href="route('profile.edit')">
                            {{ __('Edit Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST"
                            action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link
                                :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @endauth

                @guest
                <!-- If user is a guest (not logged in) show login and register links -->
                <div
                    class="flex items-center space-x-4">
                    <a href="{{ route('login') }}"
                        class="text-sm text-black hover:text-gray-700 font-medium">
                        {{ __('Log In') }}
                    </a>
                    <a href="{{ route('register') }}"
                        class="text-sm text-black  border-[0.1rem] border-black bg-transparent hover:bg-black hover:text-white font-medium px-4 py-2 rounded-full">
                        {{ __('Register') }}
                    </a>
                </div>
                @endguest
            </div>

            <!-- Hamburger -->
            <div
                class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6"
                        stroke="currentColor"
                        fill="none"
                        viewBox="0 0 24 24">
                        <path
                            :class="{'hidden': open, 'inline-flex': ! open }"
                            class="inline-flex"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path
                            :class="{'hidden': ! open, 'inline-flex': open }"
                            class="hidden"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}"
        class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link
                :href="route('dashboard')"
                :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div
            class="pt-4 pb-1 border-t border-gray-200">
            @auth
            <div class="px-4">
                <div
                    class="font-medium text-base text-gray-800">
                    {{ Auth::user()->name }}
                </div>
                <div
                    class="font-medium text-sm text-gray-500">
                    {{ Auth::user()->email }}
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link
                    :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST"
                    action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link
                        :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </div>
            @endauth

            @guest
            <div class="space-y-1">
                <x-responsive-nav-link
                    :href="route('login')"
                    :active="request()->routeIs('login')">
                    {{ __('Log In') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link
                    :href="route('register')"
                    :active="request()->routeIs('register')">
                    {{ __('Sign Up') }}
                </x-responsive-nav-link>
            </div>
            @endguest
        </div>
    </div>
</nav>