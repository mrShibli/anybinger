@include('dashboard.layouts.navbar')
    <div class="main-sidebar sidebar-style-2">
        @php
            $productRequestsCount = \App\Models\ProductRequest::where('status', 'pending')->count();
            $newOrderCount = \App\Models\Order::where('status', 'pending')->count();
            $newTravelerCount = \App\Models\Traveler::where('status', 'pending')->count();
            $newPaymentCount = \App\Models\Payment::where('status', 'pending')->count();
            $newWithdrawalCount = \App\Models\Transaction::where(['status' => 'awaiting', 'type' => 'withdraw'])->count();
        @endphp
        <aside id="sidebar-wrapper">
            <div class="sidebar-brand">
                <a href="index.html"> <img alt="image" src="{{ asset('uploads/settings/' . $anyBringrSettings->logo) }}" class="header-logo" /> <span
                        class="logo-name">AnyBringr</span>
                </a>
            </div>
            <ul class="sidebar-menu">
                <li class="menu-header">Main</li>
                <li class="dropdown {{ in_array(Route::currentRouteName(), ['secured.dashboard']) ? 'active' : '' }}">
                    <a href="{{ route('secured.dashboard') }}" class="nav-link"><i
                            data-feather="monitor"></i><span>Dashboard</span></a>
                </li>
                {{-- Request --}}
                <li class="dropdown {{ in_array(Route::currentRouteName(), ['products.requests']) ? 'active' : '' }}">
                    <a href="{{ route('products.requests') }}"><i data-feather="info"></i><span >
                            Product Requests  <b class="badge badge-danger">{{ $productRequestsCount }}</b> </span> <p class="mt-3 badge badge-danger"></p> </a>
                </li>

                {{-- cat & brand --}}
                <li
                    class="dropdown  {{ in_array(Route::currentRouteName(), ['categories.index', 'subcategories.index', 'brands.index']) ? 'active' : '' }}">
                    <a href="#"
                        class="menu-toggle nav-link has-dropdown {{ in_array(Route::currentRouteName(), ['categories.index', 'subcategories.index', 'brands.index']) ? 'toggled' : '' }}"><i
                            data-feather="calendar"></i><span>Category & Brands</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ route('categories.index') }}">Category</a></li>
                        <li><a class="nav-link" href="{{ route('subcategories.index') }}">Sub Category</a></li>
                        <li><a class="nav-link" href="{{ route('brands.index') }}">Brands</a></li>
                    </ul>
                </li>

                {{-- product --}}

                <li
                    class="dropdown {{ in_array(Route::currentRouteName(), ['products.index', 'products.create', 'products.specialProduct']) ? 'active' : '' }}">
                    <a href="#"
                        class="menu-toggle nav-link has-dropdown {{ in_array(Route::currentRouteName(), ['products.index', 'products.create', 'products.specialProduct']) ? 'toggled' : '' }}"><i
                            data-feather="shopping-bag"></i><span>Product</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ route('products.index') }}">All Products</a></li>
                        <li><a class="nav-link" href="{{ route('products.create') }}">Add Product</a></li>
                        <li><a class="nav-link" href="{{ route('products.specialProduct') }}">Special Product</a></li>
                    </ul>
                </li>


                <li
                    class="dropdown {{ in_array(Route::currentRouteName(), ['orders.index', 'orders.newOrders', 'orders.payOrders', 'orders.proOrders', 'orders.canOrders']) ? 'active' : '' }}">


                    <a href="#"
                        class="menu-toggle nav-link has-dropdown {{ in_array(Route::currentRouteName(), ['orders.index', 'orders.newOrders', 'orders.payOrders', 'orders.proOrders', 'orders.canOrders']) ? 'toggled' : '' }}">
                        <i data-feather="shopping-bag"></i> <span>Orders <b class="badge badge-danger mr-2">{{ $newOrderCount }}</b></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('orders.index') }}">All Orders</a></li>
                        <li><a href="{{ route('orders.newOrders') }}">New orders</a></li>
                        <li><a href="{{ route('orders.payOrders') }}">Pending Payments</a></li>
                        <li><a href="{{ route('orders.proOrders') }}">Proccessing</a></li>
                        <li><a href="{{ route('orders.canOrders') }}">Cancelled</a></li>
                    </ul>
                </li>

                <li class="dropdown {{ in_array(Route::currentRouteName(), ['payments.index']) ? 'active' : '' }}">
                    <a href="{{ route('payments.index') }}" class=""><i data-feather="credit-card"></i><span>Payments <b class="badge badge-danger mr-2">{{ $newPaymentCount }}</b> </span></a>

                </li>
                <li class="dropdown {{ in_array(Route::currentRouteName(), ['withdrawals.index']) ? 'active' : '' }}">
                    <a href="{{ route('withdrawals.index') }}" class=""><i data-feather="codepen"></i><span>Withdrawals <b class="badge badge-danger mr-2">{{ $newWithdrawalCount }}</b></span></a>

                </li>
                <li class="dropdown {{ in_array(Route::currentRouteName(), ['reviews.index']) ? 'active' : '' }}">
                    <a href="{{ route('reviews.index') }}" class=""><i data-feather="message-square"></i><span>Reviews</span></a>
                </li>
                <li
                    class="dropdown {{ in_array(Route::currentRouteName(), ['users.index', 'users.allDealers', 'users.dealerView']) ? 'active' : '' }}">
                    <a href="#"
                        class="menu-toggle nav-link has-dropdown {{ in_array(Route::currentRouteName(), ['users.index', 'users.allDealers', 'users.dealerView']) ? 'toggled' : '' }}"><i
                            data-feather="user"></i><span>Users & Dealer</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ route('users.index') }}">Users</a></li>
                        <li><a class="nav-link" href="{{ route('users.allDealers') }}">All Dealer</a></li>
                        {{-- <li><a class="nav-link" href="modal.html">Normal Customer</a></li> --}}
                    </ul>
                </li>

                <li class="dropdown {{ in_array(Route::currentRouteName(), ['coupons.index']) ? 'active' : '' }}">
                    <a href="{{ route('coupons.index') }}" class="nav-link "><i
                            data-feather="refresh-ccw"></i><span>Coupon</span></a>
                </li>
                <li
                    class="dropdown {{ in_array(Route::currentRouteName(), ['admin.traveler.req', 'admin.traveler.approved', 'travelerreviews.index']) ? 'active' : '' }}">
                    <a href="#"
                        class="menu-toggle nav-link has-dropdown {{ in_array(Route::currentRouteName(), ['admin.traveler.req', 'admin.traveler.approved', 'travelerreviews.index']) ? 'toggled' : '' }}"><i
                            data-feather="user-check"></i><span>Traveler <b class="badge badge-danger mr-2">{{ $newTravelerCount }}</b></span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="{{ route('admin.traveler.req') }}">New Traveler Request</a></li>
                        <li><a class="nav-link" href="{{ route('admin.traveler.approved') }}">Approved Traveler</a>
                        </li>
                        <li><a class="nav-link" href="{{ route('travelerreviews.index') }}">Traveler Reviews</a></li>
                        <li><a class="nav-link" href="{{ route('travelerreviews.product.admin') }}">Traveler
                                Product</a></li>
                    </ul>
                </li>

                <li class="menu-header">Settings</li>

                <li class="dropdown">
                    <a href="{{ route('sliders.index') }}" class=" nav-link"><i
                            data-feather="layers"></i><span>Sliders</span></a>
                </li>
                <li class="dropdown">
                    <a href="{{ route('staticpages.index') }}" class=" nav-link"><i
                            data-feather="file-text"></i><span>Static Pages</span></a>
                </li>
                <li class="dropdown">
                    <a href="{{ route('faqs.index') }}" class=" nav-link"><i data-feather="list"></i><span>Manage
                            FAQS</span></a>
                </li>
                <li class="dropdown">
                    <a href="{{ route('settings.index') }}" class=" nav-link "><i
                            data-feather="settings"></i><span>Settings</span></a>
                </li>

                <li class="dropdown">
                    <a href="{{ route('settings.migrate') }}" class="nav-link "><i
                            data-feather="server"></i><span>Optimize site</span></a>
                </li>

            </ul>

            <br><br><br>
            <br><br><br>
            <br><br><br>
        </aside>
    </div>