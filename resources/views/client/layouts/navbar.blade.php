<!-- Nav Bar -->
<nav class="max-w-[1400px] sm:px-6 md:px-8 mx-auto relative">
    <div
        class="max-w-[80px] border border-t-transparent border-l-transparent border-r-transparent border-opacity-70 border-blue-dark sm:max-w-[150px] logo-sm sm:p-4 p-1 bg-white absolute lg:top-[-20px] md: rounded-full">
        @if (file_exists(public_path('uploads/settings/' . $anyBringrSettings->logo)))
            <a href="{{ route('index') }}"><img class="w-full rounded-full drop-shadow-2xl"
                    src="{{ asset('uploads/settings/' . $anyBringrSettings->logo) }}" alt="" srcset="" /></a>
        @else
            <a href="{{ route('index') }}">
                <img class="w-full rounded-full drop-shadow-2xl" src="{{ asset('client/images/Krisna-Chura-Logo.png') }}"
                    alt="" srcset="" />
            </a>
        @endif
    </div>
    <div class="flex items-center h-14 sm:h-20 px-3 md:px-0 sm:px-0">
        <button class="lghidden border border-blue-dark px-2 rounded-full">
            <span class="text-white text-xl top-5 left-4 cursor-pointer" onclick="openSidebar()">
                <i class="fa-regular fa-chart-bar text-blue-dark"></i>
            </span>
        </button>
        <div class="flex mx-auto items-center justify-between w-full">
            <div>
            </div>
            <div>
            </div>

            <div id="" class="mobileandPcSearch absolute  md:left-[25%] top-[60px] lg:static">
                <form id="pSearchFrom"
                    class="bg-white flex justify-between search w-[450px] border-[1px] rounded-full h-10 relative border-blue-dark border-opacity-70">
                    <input
                        class="border-none rounded-full bg-transparent pl-4 align-middle text-[17px] w-[400px] outline-none "
                        type="text" id="productSearch" />
                    <div class="typing-container bg-white" id="typing-container" onclick="HideShowDiv()">
                    </div>
                    <div id="requestItem"
                        class="hidden flex-col gap-1 w-full absolute top10 left-2 right-2 bg-white z-10 rounded-md border shadow-md py-2 px-3">
                        <div class="flex gap-2 items-center">
                            <i class="fa-regular fa-handshake p-2 rounded-full border border-gray-300"></i>
                            <div>
                                <span class="text-[13px] font-medium">Do you want to request for an item?</span>
                                <p class="text-sm" id="smVerySm">Paste any product link from usa-uk based shop</span>
                            </div>
                        </div>

                    </div>
                    <button id="SearchButton"
                        class="bg-blue-dark rounded-full text-center w-[34px] h-[34px] m-[2px] drop-shadow-2xl">
                        <i class="fa-solid fa-magnifying-glass text-white text-[16px] block"></i>
                    </button>
                </form>
            </div>


            <div class="icons flex gap-2">
                <a href="{{ route('requestProduct') }}" class="px-2 py-1 bg-blue-dark rounded text-white hidden md:block mr-2"><i class="fa-solid fa-bag-shopping"></i> Request</a>
                @auth

                    <div class="px-[5px] py-[4px] mr-1 mt-[1px] hidden md:block relative bg-white">
                        <a onclick="userNotifys()" href="javascript:void(0)" title="Notifications">
                            <i class="fa-solid fa-bell text-[17px]"></i>
                        </a>
                        <div
                            class="absolute flex-center bg-red-600 -top-1 -right-2 w-[15px] h-[15px] rounded-full text-center">
                            <span class="text-white font-bold text-[9px]">{{ $notificesOfme->count() }}</span>
                        </div>
                        <div id="userNotifys" class="absolute px-3 py-2 bg-white border border-gray-300 z-10 hidden"
                            style="width: 220px; margin-top: 5px; left: -85px">
                            <div class="flex flex-col gap-2">
                                <h2 class="text-[14px]">My Notifications</h2>
                                <hr>

                                @if ($notificesOfme->isNotEmpty())
                                    @foreach ($notificesOfme as $notify)
                                        @php
                                            $url = $notify->route_name ? $notify->route_name : '';
                                            $params = $notify->route_params ? $notify->route_params : '';
                                        @endphp
                                        <div
                                            class=" text-[12px] flex flex-col gap-[2px] overflow-hidden hover:bg-text-800 font-medium">
                                            <a class="font-medium"
                                                    href="{{ $url ? route($url, $params) : '' }}">{{ Str::length($notify->message) > 80 ? Str::substr($notify->message, 0, 80) . '...' : $notify->message }}
                                            </a>

                                            <div class="w-full flex justify-between">
                                                <p>{{ $notify->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <span class="hover:text-gray-700 flex items-center text-[14px]">No new notifications
                                        available</span>
                                @endif

                                <hr>
                                <a href="{{ route('account.notifications') }}"
                                    class="hover:text-gray-700 flex items-center text-[14px] hover:underline">
                                    <span>All notifications</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="px-[8px] py-[4px] hidden md:block bg-white">
                        <a href="{{ route('pages', 'help-questions') }}" title="Get help">
                            <i class="fa-solid fa-question text-[17px]"></i>
                        </a>
                    </div>
                @endauth

                <div class="px-[8px] py-[4px] hidden md:block bg-white relative">
                    
                    @auth
                        <a onclick="showMenus()" href="{{ !Auth::check() ? route('login') : 'javascript:void(0)' }}"
                            class="" title="Account">
                            <i class="fa-regular fa-user text-[16px]"></i>
                        </a>
                        <div id="userMenu" class="absolute px-3 py-2 bg-white border border-gray-300 z-10 hidden"
                            style="width: 210px; margin-top: 5px; left: -85px">
                            <div class="flex flex-col gap-2">
                                <a href="{{ route('account.wishlists') }}"
                                    class="hover:text-gray-700 text-[14px] flex items-center">
                                    <i class="fa-regular fa-heart text-[15px] text-slate-800"
                                        style="margin-right: 6px; margin-top: 1px"></i>
                                    <span>My wishlist</span>
                                </a>

                                <a href="{{ route('account.requests') }}"
                                    class="hover:text-gray-700 text-[14px] flex items-center">
                                    <i class="fa-brands fa-product-hunt text-[15px] text-slate-800"
                                        style="margin-right: 6px; margin-top: 1px"></i>
                                    <span>My request</span>
                                </a>
                                <a href="{{ route('account.notifications') }}"
                                    class="hover:text-gray-700 text-[14px] flex items-center">
                                    <i class="fa-solid fa-bell text-[15px] text-slate-800"
                                        style="margin-right: 6px; margin-top: 1px"></i>
                                    <span>My notifications</span>
                                </a>
                                <a href="{{ route('account.transactions') }}"
                                    class="hover:text-gray-700 text-[14px] flex items-center">
                                    <i class="fa-solid fa-arrow-right-arrow-left text-[15px] text-slate-800"
                                        style="margin-right: 6px; margin-top: 1px"></i>
                                    <span>My transaction</span>
                                </a>

                                <a href="{{ route('account.index') }}" class="hover:text-gray-700 text-[14px] flex items-center">
                                    <i class="fa-solid fa-wallet text-[15px] text-slate-800"
                                        style="margin-right: 6px; margin-top: 1px"></i>
                                    <span>My wallet</span>
                                </a>

                                <a href="{{ route('account.orders') }}"
                                    class="hover:text-gray-700 text-[14px] flex items-center">
                                    <i class="fa-solid fa-list text-[15px] text-slate-800"
                                        style="margin-right: 6px; margin-top: 1px"></i>
                                    <span>My orders</span>
                                </a>

                                <a href="{{ route('account.index') }}"
                                    class="hover:text-gray-700 text-[14px] flex items-center">
                                    <i class="fa-regular fa-circle-user text-[15px] text-slate-800"
                                        style="margin-right: 6px; margin-top: 1px"></i>
                                    <span>Account</span>
                                </a>
                                @if (Auth::user()->user_access == 'traveler')
                                    <a href="{{ route('traveler.dashboard') }}"
                                        class="hover:text-gray-700 text-[14px] flex items-center">
                                        <i class="fa-solid fa-table-columns text-[15px] text-slate-800"
                                            style="margin-right: 6px; margin-top: 1px"></i>
                                        Dashboard</a>
                                @endif

                                <hr>
                                <a href="{{ route('account.logout') }}"
                                    class="hover:text-gray-700 flex items-center text-[14px] ">
                                    <i class="fa-solid fa-power-off text-[15px]"
                                        style="margin-right: 6px; margin-top: 2px"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="" title="Login">
                            <i class="fa-regular fa-user text-[16px]"></i>
                        </a>
                    @endauth

                </div>
                <div class="px-[5px] py-[4px] hidden mr-[2px] md:block relative bg-white">
                    <a href="{{ route('cart') }}">
                        <i class="fa-solid fa-cart-shopping text-[16px]"></i>
                    </a>
                    <div
                        class="absolute flex-center bg-red-600 -top-1 -right-2 w-[15px] h-[15px] rounded-full text-center">
                        <span class="text-white font-bold text-[9px]" id="cartCounts">0</span>
                    </div>
                </div>


                <div class="ml-2 ld:mr-0 w-[100px] sm:w-auto bg-white">
                    <a href="{{ Auth::check() ? (Auth::user()->user_access == 'traveler' ? route('traveler.products') : route('traveler.index')) : route('traveler.index') }}"
                        class="border flex-center rounded-full px-2.5 py-1 hover:border-blue-dark transition ease-in">
                        <button
                            class="text-[11px]  sm:text-[12px]">{{ Auth::check() ? (Auth::user()->user_access == 'traveler' ? 'Traveler' : 'Become A Traveler') : 'Become A Traveler' }}</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="z-50 sidebar hidden fixed top-0 bottom-0 md:left-0 p-2 w-[300px] overflow-y-auto text-center bg-gray-900">
    <div class="text-gray-100 text-xl">
        <div class="p-2 mt-1 flex items-center">
            <h1 class="font-bold text-gray-200 text-[14px] ml-3">Menu</h1>
            <i class="fa-solid fa-xmark cursor-pointer md:hidden" style="margin-left: 185px"
                onclick="openSidebar()"></i>
        </div>
        <div class="my-2 bg-gray-600 h-[1px]">
        </div>
    </div>

    <div class="p-2 mt-1 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white"
        onclick="dropdown()">
        <i class="fa-solid fa-list"></i>
        <div class="flex justify-between w-full items-center">
            <span class="text-[14px] ml-4 text-gray-200 font-medium">Categories</span>
            <span class="text-sm rotate-180" id="arrowss" style="transition: 0.2s ease">
                <i class="fa-solid fa-angle-down"></i>
            </span>
        </div>
    </div>
    <div class=" text-left text-sm mt-2 w-4/5 mx-auto text-gray-200 font-bold" id="submenu">
        @if ($categories->isNotEmpty())
            @foreach ($categories as $category)
                <h1 class="cursor-pointer p-2 ml-2 font-medium text-[14px] hover:bg-blue-600 rounded-md mt-1">
                    <a href="{{ route('items', $category->slug) }}">{{ $category->name }}</a>
                </h1>
            @endforeach
        @endif
    </div>

    <div class="p-2 mt-1 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white">
        <i class="fa-solid fa-store"></i>
        <a href="{{ route('products') }}" class="text-[14px] ml-4 text-gray-200 font-medium">Shop</a>
    </div>
    <div class="p-2 mt-1 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white">
        <i class="fa-solid fa-registered"></i>
        <a href="{{ route('requestProduct') }}" class="text-[14px] ml-4 text-gray-200 font-medium">Product Request</a>
    </div>
    @auth
        <div class="p-2 mt-1 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white">
            <i class="fa-regular fa-heart"></i>
            <a href="{{ route('account.wishlists') }}" class="text-[14px] ml-4 text-gray-200 font-medium">My wishlist</a>
        </div>

        <div class="p-2 mt-1 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white">
            <i class="fa-brands fa-product-hunt "></i>
            <a href="{{ route('account.requests') }}" class="text-[14px] ml-4 text-gray-200 font-medium">My request</a>
        </div>

        <div class="p-2 mt-1 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white">
            <i class="fa-solid fa-arrow-right-arrow-left "></i>
            <a href="{{ route('account.transactions') }}" class="text-[14px] ml-4 text-gray-200 font-medium">My
                transaction</a>
        </div>


        <div class="p-2 mt-1 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white">
            <i class="fa-solid fa-wallet "></i>
            <a href="{{ route('account.index') }}" class="text-[14px] ml-4 text-gray-200 font-medium">My wallet</a>
        </div>


        <div class="p-2 mt-1 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white">
            <i class="fa-solid fa-list "></i>
            <a href="{{ route('account.orders') }}" class="text-[14px] ml-4 text-gray-200 font-medium">My orders</a>
        </div>



        @if (Auth::user()->user_access == 'traveler')
            <div
                class="p-2 mt-1 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white">
                <i class="fa-solid fa-table-columns "></i>
                <a href="{{ route('traveler.dashboard') }}" class="text-[14px] ml-4 text-gray-200 font-medium">Traveler
                    dashboard</a>
            </div>
        @endif

    @endauth
    <div class="my-4 bg-gray-600 h-[1px]">
    </div>
    <div class="p-2 mt-1 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white">
        @if (Auth::check())
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
            <a href="{{ route('account.logout') }}" class="text-[14px] ml-4 text-gray-200 font-medium">Logout</a>
        @else
            <i class="fa-solid fa-right-to-bracket"></i>
            <a href="{{ route('login') }}" class="text-[14px] ml-4 text-gray-200 font-medium">Login</a>
        @endif
    </div>
</div>
