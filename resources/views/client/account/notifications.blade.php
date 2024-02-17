@extends('client.layouts.app')

@section('headers')
    <title>My Notifications </title>

    @include('client.layouts.pagination')
@endsection

@section('contents')
    <!-- main -->
    <main class="max-w-[1400px] mx-auto px-3 mt-3 sm:px-6 md:px-8">
        <div class="inline-block">
            <div class="flex flex-row items-center justify-between">
                <a href="{{ route('index') }}" class="link">Home</a>
                <i class="fa-solid fa-chevron-right text-[12px] mx-1 text-gray-700"></i>
                <a href="{{ route('account.index') }}" class="link">Account</a>
                <i class="fa-solid fa-chevron-right text-[12px] mx-1 text-gray-700"></i>
                <a href="" class="link">Notifications</a>
            </div>
        </div>

        <div class="flex flex-col items-center justify-center gap-3">
            <h2 style="font-size:24px" class=" my-2 font-medium text-blue-dark bg-white inline-block">
                My Notifications
            </h2>

            <div class="flex flex-col md:w-auto w-[100%] items-center justify-center gap-4">
                @if ($notifications->isNotEmpty())
                    @foreach ($notifications as $notify)
                        <div
                            class="bg-white w-[95%] mdwidth550 border mx-auto flex gap-4 px-4 py-3 rounded-md overflow-hidden">
                            <div class="w-full flex flex-col sm:flex-row justify-between">
                                <div class="flex flex-col gap-[2px]">
                                    @php
                                        $url = $notify->route_name ? $notify->route_name : '';
                                        $params = $notify->route_params ? $notify->route_params : '';
                                    @endphp

                                    @if (!$notify->read)
                                        @php
                                            // Mark the notification as read
                                            $notify->read = true;
                                            $notify->save();
                                        @endphp
                                    @endif

                                    <a href="{{ $url ? route($url, $params) : '' }}" class="text-[15px] text-blue-dark">
                                        <i class="fa-regular fa-circle-question text-[14px] text-sky"
                                            style="margin-right: 5px"></i>
                                        {{ $notify->message }}
                                    </a>
                                    <a href="{{ $url ? route($url, $params) : '' }}"
                                        class="text-[14px] text-blue-dark hover:underline text-orange-dark">
                                        check notification
                                    </a>
                                </div>
                                <span class="text-small mt-1 sm:mt-0" style="white-space: nowrap; margin-top:2px">
                                    <i class="fa-regular fa-clock mx-1"></i>{{ $notify->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="w-[90%] mdwidth550 flex justify-center mx-auto flex  gap-4 px-4 py-3 rounded-md"
                        style="margin-top: 50px !important; margin-bottom:50px !important">
                        <h3 class="text-center">No notifcations available here</h3>
                    </div>
                @endif
            </div>

            @if ($notifications->hasPages())
                <div class="custom-pagination" style="margin-top: 50px !important">
                    <ul class="pagination">
                        @if ($notifications->onFirstPage())
                            <li class="disabled"><span><i class="fa-solid fa-angle-left"></i> Previous</span></li>
                        @else
                            <li><a href="{{ $notifications->previousPageUrl() }}"><i class="fa-solid fa-angle-left"></i> Previous</a></li>
                        @endif

                        @foreach ($notifications->links()->elements as $element)
                            @if (is_string($element))
                                <li class="disabled"><span>{{ $element }}</span></li>
                            @endif

                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    <li class="{{ $page == $notifications->currentPage() ? 'active' : '' }}">
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                            @endif
                        @endforeach

                        @if ($notifications->hasMorePages())
                            <li><a href="{{ $notifications->nextPageUrl() }}">Next <i class="fa-solid fa-angle-right"></i></a></li>
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
