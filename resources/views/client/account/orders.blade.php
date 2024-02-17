@extends('client.layouts.app')

@section('headers')
    <title>My orders</title>

    @include('client.layouts.pagination')
@endsection

@section('contents')
    <main class="max-w-[1400px] mx-auto px-3 sm:px-6 md:px-8 ">
        <div class="bg-white inline-block mt-3">
            <div class="flex flex-row items-center justify-between">
                <a href="{{ route('index') }}" class="link">Home</a>
                <i class="fa-solid fa-chevron-right text-[12px] mx-1 text-gray-700"></i>
                <a href="{{ route('account.index') }}" class="link">Account</a>
                <i class="fa-solid fa-chevron-right text-[12px] mx-1 text-gray-700"></i>
                <a href="" class="link">My orders</a>
            </div>
        </div>
        <div class="w-full flex flex-col items-center justify-center gap-3">
            <h2 style="font-size:24px" class=" my-2 font-medium text-blue-dark bg-white inline-block">
                My Orders
            </h2>

            @if ($orders->isNotEmpty())
                @foreach ($orders as $order)
                    <div class="w-[90%] lgMaxW700 flex flex-col shadow-sm">
                        <h3 style="width: 200px; padding: 3px 8px; border-top-left-radius: 5px; border-top-right-radius: 5px"
                            class="text-[14px] bg-blue-dark px-3 font-medium text-center text-white">
                            Invoice {{ $order->invoice_id }}
                        </h3>
                        <div class="w-full border flex-col sm:flex-row mx-auto bg-white flex "
                            style="align-items: stretch !important; justify-content:stretch !important">

                            <div
                                class="w-full flex flex-wrap gap-2 md:flex-nowrap justify-between items-center px-4 py-2 border-t-[1px] border-blue-dark ">
                                <div class="flex flex-col">
                                    <span class="text-[12px] uppercase">order placed</span>
                                    <p class="text-small !font-medium !text-blue-dark">
                                        {{ \Carbon\Carbon::parse($order->create_at)->format('j M, Y') }}

                                    </p>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[12px] uppercase">Total</span>
                                    <p class="text-small !font-medium !text-blue-dark">


                                        {{ $order->total + $order->fees - $order->discount }}&#2547;

                                    </p>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[12px] uppercase">current status</span>

                                    @if ($order->status == 'pending')
                                        <p class="text-small font-medium" style="color: #fc5555;">
                                            <i class="fa-solid fa-circle"></i> Pending
                                        </p>
                                    @elseif ($order->status == 'pending_payment')
                                        <p class="text-small font-medium" style="color: #ee8700;">
                                            <i class="fa-solid fa-circle"></i> Pending Payment
                                        </p>
                                    @elseif ($order->status == 'approved')
                                        <p class="text-small font-medium" style="color: #24a724;"> <!-- Green Color -->
                                            <i class="fa-solid fa-check-circle"></i> Approved
                                        </p>
                                    @elseif ($order->status == 'flight')
                                        <p class="text-small font-medium" style="color: #08c3e4;"> <!-- Purple Color -->
                                            <i class="fa-solid fa-plane"></i> In Flight
                                        </p>
                                    @elseif ($order->status == 'in_country')
                                        <p class="text-small font-medium" style="color: #ff41e6;"> <!-- Orange Color -->
                                            <i class="fa-solid fa-map-marker-alt"></i> In Country
                                        </p>
                                    @elseif ($order->status == 'delivering')
                                        <p class="text-small font-medium" style="color: #0de9e9;"> <!-- Teal Color -->
                                            <i class="fa-solid fa-truck"></i> Delivering
                                        </p>
                                    @elseif ($order->status == 'delivered')
                                        <p class="text-small font-medium" style="color: #1d0acc;"> <!-- Gray Color -->
                                            <i class="fa-solid fa-check-double"></i> Delivered
                                        </p>
                                    @else
                                        <p class="text-small font-medium" style="color: #FF0000;"> <!-- Red Color -->
                                            <i class="fa-solid fa-question-circle"></i> Cancelled
                                        </p>
                                    @endif
                                </div>

                                <div class="flex flex-col">
                                    <span class="text-[12px] uppercase">order type</span>

                                    @if ($order->orderItem()->first() && $order->orderItem()->first()->product_id != null)
                                        <p class="text-small text-center !font-medium  px-2  !text-white rounded-sm"
                                            style="background: rgb(33, 173, 216)">
                                            Custom
                                        </p>
                                    @else
                                        <p class="text-small !font-medium px-2  !text-white rounded-sm"
                                            style="background: rgb(255, 0, 119)">
                                            Request
                                        </p>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="bg-white w-full border mx-auto flex flex-col sm:flex-row justify-between items-center sm:items-start gap-3 sm:gap-2 shadow-gray-50 px-4 py-3"
                            style="border-top: none">

                            <div class="flex flex-wrap gap-4 justify-center items-center">
                                <a href="{{ route('account.orders', $order->id) }}">
                                <button class=" text-white text-[11px] rounded-sm"
                                    style="padding: 5px 12px; font-size: 11px;background: rgb(93, 93, 255)">Order
                                    details</button>
                                </a>
                                <a href="{{ route('invoice.view', $order->id) }}">
                                    <button class=" bg-gray-900 hover:bg-blue-dark text-white text-[11px] rounded-sm"
                                        style="padding: 5px 12px; font-size: 11px;"> {{ $order->status == 'delivered' ? 'Download Invoice' : 'Not delivered!' }} </button>
                                </a>

                                {{-- @if ($order->status == 'pending_payment')
                                <a href="{{ route('account.orders', $order->payment()->first()) }}">
                                    <button class=" bg-red-500 text-white text-[11px] rounded-sm"
                                    style="padding: 5px 12px; font-size: 11px;">Make payment</button>
                                </a>
                                @endif --}}
                            </div>

                        </div>
                    </div>
                @endforeach
            @else
                    <h2 class="text-xl my-3">No orders available</h2>
            @endif


            @if ($orders->hasPages())
                <div class="custom-pagination" style="margin-top: 50px !important">
                    <ul class="pagination">
                        @if ($orders->onFirstPage())
                            <li class="disabled"><span><i class="fa-solid fa-angle-left"></i> Previous</span></li>
                        @else
                            <li><a href="{{ $orders->previousPageUrl() }}"><i class="fa-solid fa-angle-left"></i> Previous</a></li>
                        @endif

                        @foreach ($orders->links()->elements as $element)
                            @if (is_string($element))
                                <li class="disabled"><span>{{ $element }}</span></li>
                            @endif

                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    <li class="{{ $page == $orders->currentPage() ? 'active' : '' }}">
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                            @endif
                        @endforeach

                        @if ($orders->hasMorePages())
                            <li><a href="{{ $orders->nextPageUrl() }}">Next <i class="fa-solid fa-angle-right"></i></a></li>
                        @else
                            <li class="disabled"><span>Next <i class="fa-solid fa-angle-right"></i></span></li>
                        @endif
                    </ul>
                </div>
            @endif


        </div>
    </main>
@endsection

@section('customJs')
@endsection
