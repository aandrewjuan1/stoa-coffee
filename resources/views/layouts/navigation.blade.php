<nav class="mx-20 border-b border-gray-300 ">
    @livewireScripts()
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}"
                    class="text-gray-200 hover:text-gray-700hover:text-gray-300 transition duration-150 ease-in-out"">
                    {{ __('STOA COFFEE') }}
                </a>
            </div>

            <div class="flex items-center gap-1">

                <div class="hidden md:flex">
                    <x-nav-link :href="route('menu.index')" :active="request()->routeIs('menu.index')"
                        class="text-gray-200 hover:text-gray-700 dark:hover:text-gray-300 transition duration-150 ease-in-out">
                        {{ __('Menu') }}
                    </x-nav-link>
                </div>
                <div class="hidden md:flex">
                    <x-nav-link :href="route('about-us')" :active="request()->routeIs('about-us')"
                        class="text-gray-200 hover:text-gray-700 dark:hover:text-gray-300 transition duration-150 ease-in-out">
                        {{ __('About Us') }}
                    </x-nav-link>
                </div>
                <div class="hidden md:flex">
                    <x-nav-link :href="route('contact')" :active="request()->routeIs('contact')"
                        class="text-gray-200 hover:text-gray-700 dark:hover:text-gray-300 transition duration-150 ease-in-out">
                        {{ __('Contact') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Authentication Links -->
            @guest
                <div class="flex items-center gap-2 text-gray-300">

                    <a href="{{ route('login') }}" class="hover:text-white">
                        {{ __('Log in') }}
                    </a>

                    <a href="{{ route('register') }}" class="hover:text-white">
                        {{ __('Register') }}
                    </a>

                </div>
            @endguest

            {{-- Right side nav --}}
            @auth
                <div class="hidden md:flex md:items-center md:ml-6">
                    @can('buyer')
                        <a href="{{ route('cart.index') }}"
                            class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition duration-150 ease-in-out me-4">
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                    @endcan
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="flex items-center text-sm font-medium text-gray-900 dark:text-gray-200 hover:text-gray-700 dark:hover:text-gray-300 transition duration-150 ease-in-out focus:outline-none">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')" class="text-gray-900 dark:text-gray-200">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            @can('admin')
                                <x-dropdown-link :href="route('inventory.index')" class="text-gray-900 dark:text-gray-200">
                                    {{ __('Inventory') }}
                                </x-dropdown-link>
                            @endcan
                            @can('baristaOrAdmin')
                                <x-dropdown-link :href="route('orders.index')" class="text-gray-900 dark:text-gray-200">
                                    {{ __('Orders') }}
                                </x-dropdown-link>
                            @endcan
                            <!-- Logout -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="text-gray-900 dark:text-gray-200">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            @endauth


            <!-- Hamburger Menu -->
            <div class="-mr-2 flex items-center md:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden md:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('menu.index')" :active="request()->routeIs('menu.index')" class="text-gray-900 dark:text-gray-200">
                {{ __('Menu') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('about-us')" :active="request()->routeIs('about-us')" class="text-gray-900 dark:text-gray-200">
                {{ __('About Us') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('contact')" :active="request()->routeIs('contact')" class="text-gray-900 dark:text-gray-200">
                {{ __('Contact') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Authentication Links -->
        @guest
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                <div class="flex items-center px-4">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ __('Guest') }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('login')" class="text-gray-900 dark:text-gray-200">
                        {{ __('Log in') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')" class="text-gray-900 dark:text-gray-200">
                        {{ __('Register') }}
                    </x-responsive-nav-link>
                </div>
            </div>
        @endguest

        <!-- Responsive User Dropdown -->
        @auth
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')" class="text-gray-900 dark:text-gray-200">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('cart.index')" class="text-gray-900 dark:text-gray-200">
                        {{ __('Cart') }}
                    </x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="text-gray-900 dark:text-gray-200">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>
