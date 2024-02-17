@extends('client.layouts.app')

@section('headers')
<title>My requested products</title>
    <style>
        #RproductW {
            width: 300px;
            padding: 0 12px;
            border-radius: 5px
        }

         @media screen and (max-width: 450px) {
            .nameSmall {
            font-size: 12px !important;
            }
            .qtySmall {
                font-size: 12px !important;
            }
            .priceSmall {
                font-size: 12px !important;
            }
         }

        /* Small screens (sm) */
        @media screen and (min-width: 450px) {
            #RproductW {
                width: 380px;
            }
            .nameSmall {
            font-size: 13px !important;
            }
            .qtySmall {
                font-size: 13px !important;
            }
            .priceSmall {
                font-size: 13px !important;
            }
        }

        /* Small screens (sm) */
        @media screen and (min-width: 640px) {
            #RproductW {
                width: 450px;
            }
        }

        /* Medium screens (md) */
        @media screen and (min-width: 768px) {
            #RproductW {
                width: 380px;
            }
        }

        /* Large screens (lg) */
        @media screen and (min-width: 1024px) {
            #RproductW {
                width: 420px;
            }
        }

        
    </style>
@endsection


@section('contents')
    <!-- main starts here -->
    <main class="max-w-[1400px] mx-auto px-3 mt-3 sm:px-6 md:px-8">
        <div class="bg-white inline-block">
            <div class="flex flex-row items-center justify-between">
                <a href="{{ route('index') }}" class="link">Home</a>
                <i class="fa-solid fa-chevron-right text-[12px] mx-1 text-gray-700"></i>
                <a href="{{ route('account.index') }}" class="link">Account</a>
                <i class="fa-solid fa-chevron-right text-[12px] mx-1 text-gray-700"></i>
                <a href="" class="link">My requests</a>
            </div>
        </div>
        <div class="flex flex-col items-center justify-center gap-3 bg-white">
            <h2 class="text-[25px] my-2 mb-1 font-medium text-blue-dark bg-white inline-block">
                My Requests
            </h2>
            <div class="flex flex-col md:w-auto w-[100%] items-center justify-center gap-4">
                <div class="flex gap-3 mb-2">
                    <button class="btn-outline" data-tab="pendings">Pending Requests</button>
                    <button class="btn-outline" data-tab="accepted">Accepted Requests</button>
                </div>

                <div id="pendings" class="tab-content">
                    @if ($pending->isNotEmpty())
                        @foreach ($pending->chunk(2) as $chunk)
                            <div class="w-full flex flex-col md:flex-row items-center gap-4 justify-center">
                                @foreach ($chunk as $request)
                                    <div id="RproductW"
                                        class="bg-white  mt-3 w-[90%] md:w-full md:w-auto border mx-auto flex  justify-between items-center p-1 smH120">
                                        <div class="flex flex-row w-full items-center gap-3 overflow-hidden">
                                            @if ($request->image)
                                                <img src="{{ asset('uploads/requests/' . $request->image) }}" alt
                                                    class="w-[100px] rounded-md sm:w-[100px] h-[90px]" />
                                            @else
                                                <img src="{{ asset('client/images/650.png') }}" alt
                                                    class="w-[100px] rounded-md sm:w-[100px] h-[90px]" />
                                            @endif

                                            <div class="flex flex-col gap-1">
                                                <a href="{{ $request->url }}"
                                                    class="text-[15px] text-blue-dark hover:bg-text-600 font-medium">{{ $request->name ? $request->name : Str::substr($request->url, 0, 30) . '...' }}</a>
                                                <span class="text-[15px] text-orange-dark">Quantity:
                                                    <b>{{ $request->qty }}</b></span>
                                                @if ($request->original_price)
                                                    <span class="text-[15px] text-orange-dark">Price:
                                                        &#2547;<b>{{ $request->original_price }}</b></span>
                                                @endif

                                                @if ($request->status == 'pending')
                                                    <p class="text-red-600 text-[14px] font-medium"> <i
                                                            class="fa-solid fa-circle"></i> Pending</p>
                                                @else
                                                    <p class="text-green-600 text-[14px] font-medium"><i
                                                            class="fa-regular fa-circle-check"></i> Accepted</p>
                                                @endif

                                            </div>
                                        </div>
                                        
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    @else
                        <div class=" my-5">
                            <h2 class="text-xl my-2 text-center">No pending products available</h2>
                            <a href="{{ route('products') }}"
                                class="w-[150px] mt-12 mb-3 btn-outline text-center block mx-auto">Request for an item</a>
                        </div>
                    @endif
                </div>

                <div id="accepted" class="tab-content hidden">
                    <!-- Content for Accepted Requests tab -->
                    @if ($accepeted->isNotEmpty())
                        @foreach ($accepeted->chunk(2) as $chunk)
                            <div class="w-full flex flex-col md:flex-row items-center gap-4 justify-center">
                                @foreach ($chunk as $request)
                                    <div id="RproductW"
                                        class="bg-white mt-3  md:w-full md:w-auto border mx-auto flex  justify-between items-center p-1 smH120">
                                        <div class="flex flex-row w-full items-center gap-3 overflow-hidden">
                                            @if ($request->image)
                                                <img src="{{ asset('uploads/requests/' . $request->image) }}" alt
                                                    class="w-[100px] rounded-md sm:w-[100px] h-[90px]" />
                                            @else
                                                <img src="{{ asset('client/images/650.png') }}" alt
                                                    class="w-[100px] rounded-md sm:w-[100px] h-[90px]" />
                                            @endif

                                            <div class="flex flex-col sm:gap-1">
                                                <a href="{{ $request->url }}"
                                                    class="text-[15px] text-blue-dark hover:bg-text-600 font-medium nameSmall">{{ $request->name ? $request->name : Str::substr($request->url, 0, 30) . '...' }}</a>
                                                <span class="text-[15px] text-orange-dark qtySmall">Quantity:
                                                    <b class="qtySmall">{{ $request->qty }}</b></span>
                                                @if ($request->original_price)
                                                    <span class="text-[15px] text-orange-dark priceSmall">Price:
                                                        &#2547;<b class="qtySmall">{{ $request->original_price }}</b></span>
                                                @endif

                                                
                                                    <p class="text-green-600 text-[14px] font-medium nameSmall"><i
                                                            class="fa-regular fa-circle-check"></i> Accepted</p>
                                                

                                            </div>
                                        </div>

                                        <button onclick="deleteRequest({{$request->id}})" class="mr-2 text-blue-dark"><i class="fa-solid fa-trash"></i></button>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach

                        <div class="flex justify-end items-center my-3">
                            <a href="{{ route('order.checkout', 'request') }}">
                                <button class="btn-outline">Request order</button>
                            </a>
                        </div>
                    @else
                        <div class=" my-5">
                            <h2 class="text-xl my-2 text-center">No accepted products available</h2>
                            <a href="{{ route('products') }}"
                                class="w-[150px] mt-12 mb-3 btn-outline text-center block mx-auto">Request for an item</a>
                        </div>
                    @endif
                </div>


            </div>
        </div>
    </main>

@endsection

@section('customJs')
    <script>
        $(document).ready(function() {
            // Check if there's a hash in the URL
            var hash = window.location.hash.substring(1);

            // If hash exists, show the corresponding tab
            if (hash == '') {
                // Hide all tab contents
                $('.tab-content').addClass('hidden');

                // Show the tab corresponding to the hash
                $('#' + 'pendings').removeClass('hidden');

                // Add classes to the active tab
                $('button[data-tab="' + 'pendings' + '"]').addClass('bg-blue-dark !text-white');
            } else {
                // Hide all tab contents
                $('.tab-content').addClass('hidden');

                // Show the tab corresponding to the hash
                $('#' + hash).removeClass('hidden');

                // Add classes to the active tab
                $('button[data-tab="' + hash + '"]').addClass('bg-blue-dark !text-white');
            }

            // Handle tab click event
            $('.btn-outline').on('click', function() {
                // Remove classes from all tabs
                $('.btn-outline').removeClass('bg-blue-dark !text-white');

                // Hide all tab contents
                $('.tab-content').addClass('hidden');

                // Show the selected tab content
                var tabId = $(this).data('tab');
                $('#' + tabId).removeClass('hidden');

                // Add classes to the active tab
                $(this).addClass('bg-blue-dark !text-white');
            });
        });
    </script>
    <script>
        function deleteRequest(id) {
            $.ajax({
                url: "{{ route('account.deleteRequest') }}",
                type: 'delete',
                data: {
                    id: id
                },
                success: function(response) {
                    if (response.status == true) {
                        Swal.fire({
                            title: 'Success',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'Confirm',
                            preConfirm: (() => {
                                window.location.reload();
                            })
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: response.error,
                            icon: 'error',
                            confirmButtonText: 'Confirm',
                            preConfirm: (() => {
                                window.location.reload();
                            })
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: 'Error',
                        text: 'Something went wrong',
                        icon: 'error',
                        confirmButtonText: 'Confirm'
                    });
                }
            })
        }
    </script>
@endsection
