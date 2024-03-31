@extends('client.layouts.app')

@section('headers')
<title>My wishlisted products</title>
@include('client.layouts.pagination')
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
                <a href="" class="link">Wishlist</a>
            </div>
        </div>
        <div class="flex flex-col items-center justify-center gap-3">
            <h2 class="text-[25px] my-2 mb-4 font-medium text-blue-dark bg-white inline-block">
                My wishlists
            </h2>
            <div class="flex flex-col md:w-auto w-[100%] items-center justify-center gap-4">

                @if ($wishlists->isNotEmpty())
                    @foreach ($wishlists->chunk(2) as $chunk)
                        <div class="w-full flex flex-col sm:flex-row items-center gap-4 justify-center">
                            @foreach ($chunk as $wishlist)
                                <div
                                    class="bg-white w-[90%] md:w-full md:w-auto border mx-auto flex flex-col sm:flex-row justify-between items-center p-1 smH120">
                                    <div class="flex flex-row w-full items-center gap-3">
                                        @php
                                            $productImage = $wishlist->product->productImage->last();
                                        @endphp
                                        <img src="{{ $productImage ? asset('uploads/products/' . $productImage->name) : asset('client/images/650.png') }}"
                                            alt class="w-[100px] rounded-md sm:w-[100px] h-[90px]" />
                                        <div class="flex flex-col gap-1">
                                            <a href="{{ route('product', $wishlist->product->slug) }}"
                                                class="text-[15px] text-blue-dark hover:bg-text-600 font-medium">{{ $wishlist->product->title }}</a>
                                            <span class="text-[15px] text-orange-dark">price:
                                                &#2547;<b>{{ $wishlist->product->price }}</b></span>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-center gap-2 !mt-2 sm:!mt-12">
                                        <button onclick="addToCart({{ $wishlist->product->id }})"
                                            class="hover:text-gray-600 px-4 sm:px-3 py-[2px]">
                                            <i class="fa-solid fa-cart-shopping"></i>
                                        </button>
                                        <button onclick="removeFromWishlist({{ $wishlist->id }})"
                                            class="hover:text-gray-600 px-4 sm:px-3 py-[2px]">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                @else
                    <h2 class="text-2xl">No items in your wishlist</h2>
                    <a href="{{ route('products') }}" class="btn-outline">Go to shop</a>
                @endif


                @if ($wishlist->hasPages ?? '')
                    <div class="custom-pagination " style="margin-top: 24px">
                        <ul class="pagination">
                            @if ($wishlists->onFirstPage())
                                <li class="disabled"><span><i class="fa-solid fa-angle-left"></i> Previous</span></li>
                            @else
                                <li><a href="{{ $wishlists->previousPageUrl() }}"><i class="fa-solid fa-angle-left"></i>
                                        Previous</a>
                                </li>
                            @endif

                            @foreach ($wishlists->links()->elements as $element)
                                @if (is_string($element))
                                    <li class="disabled"><span>{{ $element }}</span></li>
                                @endif

                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        <li class="{{ $page == $wishlists->currentPage() ? 'active' : '' }}">
                                            <a href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach
                                @endif
                            @endforeach

                            @if ($wishlists->hasMorePages())
                                <li><a href="{{ $wishlists->nextPageUrl() }}">Next <i class="fa-solid fa-angle-right"></i></a>
                                </li>
                            @else
                                <li class="disabled"><span>Next <i class="fa-solid fa-angle-right"></i></span></li>
                            @endif
                        </ul>
                    </div>
                @endif
                
            </div>
        </div>
    </main>

@endsection

@section('customJs')
    <script>
        function removeFromWishlist(id) {
            $.ajax({
                url: "{{ route('account.removeFromWishlist') }}",
                type: 'post',
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

        function addToCart(id) {
            const url = "{{ url('add-to-cart') }}/" + id;

            $.ajax({
                url: url,
                type: 'post',
                data: {},
                success: function(response) {
                    if (response.status == true) {
                        Swal.fire({
                            icon: "success",
                            title: 'success',
                            text: response.message,
                            confirmButtonText: 'Go to Cart',
                            showCancelButton: true,
                            cancelButtonText: 'Cancel',
                            preConfirm: (() => {
                                window.location.href = "{{ route('cart') }}";
                            })
                        });
                    } else if (response.status == 'inCart') {
                        Swal.fire({
                            icon: "warning",
                            title: 'Warning',
                            text: response.message,
                            confirmButtonText: 'Go to cart',
                            showCancelButton: true,
                            cancelButtonText: 'Cancel',
                            preConfirm: (() => {
                                window.location.href = "{{ route('cart') }}";
                            })
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: 'Error',
                            text: response.error,
                            confirmButtonText: 'Confirm',
                            preConfirm: (() => {
                                window.location.reload();
                            })
                        });
                    }
                },
                error: function(error) {
                    Swal.fire({
                        icon: "error",
                        title: 'Error',
                        text: 'Something went wrong'
                    });
                }
            })

        }
    </script>
@endsection
