<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 sticky-top z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 ">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex  items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9  w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                   
                   
                </div>

            </div>
            <div class=" flex gap-2 justify-content-end text-end items-center w-75">
                @guest
                <div class="d-flex gap-2">
                    <a class="btn btn-sm btn-outline-danger" href="{{ route('register') }}">Register</a>
                    
                    <a class="btn btn-sm btn-danger" href="{{ route('login') }}">Login</a>
              </div>
                    @endguest
                @auth
                    <a style="background-color: red" class="btn btn-sm text-white px-4  archivo" href="{{ route('placeAdView') }}">Ad <i class="bi bi-cloud-upload-fill"></i></a>
                    @endauth

            </div>


            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @if(Auth::check())
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name}}</div>

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
                            <x-dropdown-link :href="route('profile.index')">
                                {{ __('Profile') }}
                                @if(Auth::user()->image != 'public/images/avatar.png')
                            <img src="{{ Storage::url(Auth::user()->image)}}"
                                style="width:25px; height:25px; object-fit:cover;" class="rounded-circle d-inline-flex ms-3" loading="lazy">
                        @else
                            <img src="/images/avatar.jpg" style="width:25px; height:25px; object-fit:cover;"
                                class=" d-inline-flex ms-3 rounded-circle me-2" loading="lazy">
                        @endif

                            </x-dropdown-link>
                                 <a class="d-block w-100 px-4 py-2 text-start text-sm " href="{{route('likedAds')}} ">
                                               
               <span><i class="bi bi-bookmark-heart-fill"></i></span> {{ __('Liked ads') }}
                </a>
                 @if(Auth::user()?->admin)
            <x-responsive-nav-link :href="route('admin.dashboard', Auth::id())"
                 >   
                      <span><i class="bi bi-diagram-3-fill"></i></span>  {{ __('Admin dashboard') }}                       
                    </x-responsive-nav-link>
                    @endif

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                   <i class="bi bi-box-arrow-left"></i> {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                       
                        </x-slot>
                    </x-dropdown>
                    
                @endif
            </div>

            <!-- Hamburger -->
            <div class="ms-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <i class="bi bi-house-door-fill"></i> {{ __('Home') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('placeAdView')" :active="request()->routeIs('placeAdView')">
                <i class="bi bi-cloud-arrow-up-fill"></i> {{ __('place AD') }}
            </x-responsive-nav-link>
            @auth
                <x-responsive-nav-link :href="route('likedAds')"
                        :active="request()->routeIs('likedAds')">   
                       <span><i class="bi bi-bookmark-heart-fill"></i></span> {{ __('liked ads') }}                       
                    </x-responsive-nav-link>
            @endauth
            @guest
                <x-responsive-nav-link :href="route('login')">
                    <i class="bi bi-box-arrow-in-right"></i> {{ __('login') }}
                </x-responsive-nav-link>
            @endguest
            @if(Auth::user()?->admin)
            <x-responsive-nav-link :href="route('admin.dashboard', Auth::id())"
                 >   
                      <span><i class="bi bi-diagram-3-fill"></i></span>  {{ __('Admin dashboard') }}                       
                    </x-responsive-nav-link>
                    @endif

        </div>

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{Auth::user()->name}}</div>

                </div>

                <div class=" mt-3 space-y-1">
                    <div class="d-flex align-items-center px-2 ">
                    <x-responsive-nav-link :href="route('profile.index')"
                        :active="request()->routeIs('profile.index')">   
                        {{ __('Profile') }}                       
                    </x-responsive-nav-link>
                    
                             @if(Auth::user()->image != 'public/images/avatar.png')
                            <img src="{{ Storage::url(Auth::user()->image)}}"
                                style="width:40px; height:40px; object-fit:cover;" class="rounded-circle d-inline-flex" loading="lazy">
                        @else
                            <img src="/images/avatar.jpg" style="width:35px; height:30px; object-fit:cover;"
                                class="rounded-circle me-2 d-inline-flex " loading="lazy">
                        @endif
                         
                    </div>
                    

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            <i class="bi bi-box-arrow-left"></i> {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>