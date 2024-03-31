@extends('client.layouts.app')
@php
    $productImages = $product
        ->productImage()
        ->orderBy('id', 'desc')
        ->get();
    $productFirst = $product->productImage->last();
@endphp
@section('headers')
    <title>{{ $product->title }}</title>
    <meta name="keywords" content="{{ $product->meta_keyword }}" />
    <meta name="description" content="{{ $product->meta_description }}" />

    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
    <meta name="author" content="Shibli Raihan">

    <!-- og meta tag -->
    <meta name="robots" content="index, follow" />
    <meta name="googlebot" content="index, follow, archive, snippet" />
    <meta name="googlebot-news" content="snippet" />
    <meta name="googlebot-mobile" content="index, follow, archive" />
    <meta name="msnbot" content="index, follow" />
    <meta name="slurp" content="archive, ydir, snippet" />
    <meta name="revisit-after" content="0 days" />
    <meta name="copyright" content="© {{ $product->title }}" />
    <meta property='og:locale' content='en_US' />
    <meta property="og:locale:alternate" content='bn_BD' />
    <meta property="og:title" content="{{ $product->title }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://www.anybringr.com/" />
    <meta property="og:image"
        content="{{ $productFirst ? asset('uploads/products/' . $productFirst->name) : asset('/client/images/650.png') }}" />
        
    <meta property="og:site_name" content="AnyBringr" />
    <meta property="fb:app_id" content="235034696605750" />

    <meta name="audience" content="Everyone" />
    <meta name="robots" content="index, follow" />
    <meta name="author" content="AnyBringr" />
    <meta name="publisher" content="AnyBringr" />

    <style>
        .no-tailwind {
            all: unset !important;
        }

        .no-tailwind h1 {
            font-size: 30px !important;
            font-weight: bold !important;
        }

        .no-tailwind h2 {
            font-size: 26px !important;
            font-weight: bold !important;
        }

        .no-tailwind h3 {
            font-size: 22px !important;
            font-weight: bold !important;
        }

        .no-tailwind h4 {
            font-size: 17px !important;
            font-weight: bold !important;
        }

        .no-tailwind h5 {
            font-size: 15px !important;
            font-weight: bold !important;
        }

        .no-tailwind h6 {
            font-size: 14px !important;
            font-weight: bold !important;
        }
    </style>
    @include('client.layouts.pagination')
@endsection

@section('contents')
    <main class="max-w-[1400px] mx-auto px-3 mt-3 sm:px-6 md:px-8">

        <div class="bg-white inline-block">
            <div class="flex flex-row items-center justify-between">
                <a href="{{ route('index') }}" class="link">Home</a>
                <i class="fa-solid fa-chevron-right text-[12px] mx-1 text-gray-700"></i>
                <a href="{{ route('products') }}" class="link">Products</a>
                <i class="fa-solid fa-chevron-right text-[12px] mx-1 text-gray-700"></i>
                <a href="" class="link">{{ $product->title }}</a>

            </div>
        </div>
        <div id="fullscreenModal" class="fixed top-0 left-0 w-screen h-screen bg-gray-800 bg-opacity-70 z-20 hidden">
            <div class="flex items-center justify-center h-screen overflow-x-scroll mx-auto my-6">
                <div class="max-w-full max-h-full">
                    <i class="fa-solid fa-xmark absolute top-6 right-6 sm:top-8 sm:right-10 w-[30px] sm:w-[40px] h-[30px] sm:h-[40px] text-sm md:text-xl bg-blue-dark hover:bg-gray-700 flex-center rounded-full text-white cursor-pointer"
                        id="hideModalImage"></i>
                    <img id="modalImage" alt="Modal Image" class="!-mt-10 w-full h-[70vh] sm:h-[90vh] mx-auto max-h-fit" />
                </div>
            </div>
        </div>
        <div class="grid items-center grid-cols-1 md:grid-cols-2 gap-8 mt-4">

            <div class="flex flex-row items-center">

                <div class="flex flex-col gap-2 sm:gap-3 mt-3" id="productAllImages">
                    @if ($productImages)
                        @foreach ($productImages as $img)
                            <div
                                class="flex justify-center items-center p-1 bg-w-lws border w-[40px] xs:w-[70px] xl:w-[90] lg:w-[70px] md:w-[50px] sm:w-[70px]">
                                <img src="{{ asset('uploads/products/' . $img->name) }}" alt="{{ $product->title }}"
                                    class="w-full h-full" id="SiblingImages" />
                            </div>
                        @endforeach
                    @endif


                </div>
                <div class="border-gray-300 flex justify-center items-center p-2 h-full w-full lg:h-full md:h-[350px]">
                    <img src="{{ $productFirst ? asset('uploads/products/' . $productFirst->name) : asset('/client/images/650.png') }}"
                        alt="{{ $product->title }}" class="rounded-lg hover:cursor-pointer w-full h-full" id="mainImage"
                        onclick="openModal(this)" />
                </div>
            </div>
            <div class="grid bg-white rounded col-span-1 flex-col justify-center xs:justify-start">
                <div class="mb-4 px-3 sm:px-0">
                    <div class="flex flex-col gap-2">
                        <h1
                            class="text-[25px] md:text-[18px] lg:text-[25px] text-blue-dark font-medium text-start xs:text-left">
                            {{ $product->title }}
                        </h1>
                        <p class="text-md sm:text-small bg-white md:w-full lg:w-[80%] text-left">
                            {{ $product->short_description }}
                        </p>
                        <div class="flex items-center">
                            <span class="text-[16px] font-medium mr-1">Category:</span>
                            <h2 class="text-[16px] ">
                                {{ $product->category != null ? $product->category->name : 'This category was deleted' }}
                            </h2>
                        </div>

                        <div class="flex items-center">
                            @if ($product->brand_id != '')
                                <span class="text-[16px] font-medium mr-1">Brand:</span>

                                <h2 class="text-[16px] ">
                                    {{ $product->brand != null ? $product->brand->name : 'This brand was deleted' }}
                                </h2>
                            @endif
                        </div>

                        <div class="flex items-center gap-2">
                            <p class="flex items-center">
                                @php
                                    $maxStars = 5; // Maximum number of stars
                                    $filledStars = $totalRating ? min(5, max(1, $totalRating)) : 5;
                                @endphp

                                @for ($i = 1; $i <= $maxStars; $i++)
                                    @if ($i <= $filledStars)
                                        <i class="fa-solid fa-star text-[13px] text-orange-500"></i>
                                    @else
                                        <i class="fa-solid fa-star text-[13px] text-gray-500"></i>
                                    @endif
                                @endfor
                                <b class="  text-[13px]"
                                    style="padding-left: 6px !important">{{ number_format($totalRating, 1) }}</b>
                                <span class="ml-2 bg-white text-[13px]">( {{ $reviews->count() }}
                                    review)</span>
                            </p>

                        </div>

                    </div>
                    <div class="flex flex-col gap-1">
                        <div class="py-2 px-2 z-10 rounded-sm"
                            style="display: block;  margin-top: 8px; background: rgb(255, 241, 241)">
                            <i class="fa-regular text-[17px] ml-1 fa-lightbulb mr-1 text-orange-dark"></i>
                            <span class="text-sm font-medium" style="color: red">The product price could be update
                                according
                                to the market price.</span>
                        </div>
                        <div class="flex  xs:justify-start mt-4 md:mt-1 lg:mt-4 items-center gap-2">
                            @if ($product->compare_price != '')
                                <p class="text-[13px] line-through text-dark bg-white inline-block">
                                    &#2547;{{ number_format($product->compare_price, 2) }}
                                </p>
                            @endif

                            <span
                                class="inline-block md:text-[15px] lg:text-[20px] text-[20px] font-extrabold bg-gradient-to-r from-red-500 to-red-800 text-transparent bg-clip-text">
                                <i class="fa-solid fa-plus-minus ml-1"></i>
                                &#2547;{{ number_format($product->price, 2) }}</span>

                        </div>


                    </div>
                    <div
                        class="relative flex sm:flex-row flex-col items-center justify-center xs:justify-start gap-2 mt-4 lg:mt-4 sm:mt-6">
                        <div
                            class="absolute sm:static -top-12 -right-[5px] xs:right-1 sm:right-[1%] z-10 md:w-[100px] w-[40%] sm:w-[100px] flex items-center justify-around h-[30px] bg-white border border-gray-300 rounded-2xl sm:rounded-[3px] px-[2px] mt-[1px]">
                            <button class="sm:p-2 p-0 mb-[2px]" onclick="updateQty('decrease')">
                                <i class="fa-solid fa-minus text-[12px]"></i>
                            </button>
                            <span class="text-small" id="itemQty">1</span>
                            <button class="sm:p-2 p-0 mb-[2px]" onclick="updateQty('increase')">
                                <i class="fa-solid fa-plus text-[12px]"></i>
                            </button>
                        </div>
                        <div class="flex w-[100%] mx-auto justify-between sm:justify-center">
                            <button onclick="addToCart({{ $product->id }})"
                                class="btn-cart  w-[40%] sm:w-auto lg:text-[14px] md:text-[12px] !rounded-sm">
                                Add To Cart
                            </button>
                            <button onclick="addToWishlist({{ $product->id }})"
                                class="btn-cart  w-[40%] sm:w-auto lg:text-[14px] md:text-[12px] !rounded-sm">
                                <i class="fa-regular text-[13px] mr-1 fa-heart"></i> Wishlist
                            </button>
                        </div>
                        <div
                            class="!hidden sm:w-[30%] justify-between items-center px-4 mx-auto bg-white gap-2 visible border mt-2 rounded-[20px]">
                            <button onclick="addToCart({{ $product->id }})">
                                <i
                                    class="!text-[22px] sm:!text-[30px] py-2 text-center fa-solid fa-cart-shopping icons text-slate-600 hover:text-gray-500 transition"></i>
                            </button>
                            <button onclick="addToWishlist({{ $product->id }})">
                                <i
                                    class="!text-[22px] sm:!text-[30px] py-2 text-center fa-regular fa-heart icons text-slate-600 hover:text-gray-500 transition"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="  rounded-md mt-5 text-justify">
            <h1 class="text-xl font-extrabold underline underline-offset-8 mb-4">
                Product Description
            </h1>
            <div style="background: white !important">
                <div class="description no-tailwind ">
                    {!! $product->description !!}
                </div>
            </div>

            {{-- <textarea name="" id="description" style="width: 100%; height: auto; background:transparent">{{$product->description}}</textarea> --}}
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 items-start gap-4 md:gap-8  flex-row-reverse"
            style="margin-top: 50px">
            <div class="grid order-1">
                <div class="flex justify-between items-center">
                    <p class="text-xl font-medium ">Share your feedback about this product</p>
                </div>
                <div class="mt-6" style="margin-top: 50px">
                    <p class="text-md mb-2">
                        Your email address will not be published. Required fields are marked
                        <span class="text-red-600">*</span>
                    </p>
                    <div class="flex items-center gap-2 mb-1">
                        <p class="text-[15px]">
                            Rate this product: <span class="text-red-600">*</span>
                        </p>
                        <p class="flex" id="star-rating">
                            <i class="fa-regular fa-star text-[17px] cursor-pointer"></i>
                            <i class="fa-regular fa-star text-[17px] cursor-pointer"></i>
                            <i class="fa-regular fa-star text-[17px] cursor-pointer"></i>
                            <i class="fa-regular fa-star text-[17px] cursor-pointer"></i>
                            <i class="fa-regular fa-star text-[17px] cursor-pointer"></i>
                        </p>
                    </div>
                    <label for="review" class="label"
                        style="margin-top: 10px !important; font-size: 15px !important">Share your review <span
                            class="text-red-600">*</span>
                    </label>
                    <br />
                    <textarea name="review" id="review" placeholder="Write a review about {{ $product->title }}"
                        class="w-full h-[120px] mt-1 border border-gray-300 focus:outline-none focus:border-blue-dark p-2 text-[14px] rounded-md"></textarea>
                    <button id="submitReview" class="btn-outline mt-2">Submit Review</button>
                </div>

            </div>
            <div class="grid items-start order-0">
                <div class="flex justify-between items-center">
                    <p class="text-xl font-medium uppercase">reviews</p>
                </div>
                @if ($reviews->isNotEmpty())
                    @foreach ($reviews as $review)
                        <div class="min-w-full flex flex-col items-start gap-3 md:gap-4 mt-3 sm:mt-4">
                            <div
                                class=" min-w-full bg-white flex flex-col p-2 rounded-[4px] border border-gray-200 border-opacity-80">
                                <div class="flex justify-between items-center">
                                    <b class="text-[16px] font-medium">{{ $review->user->name }} &nbsp;

                                        @php
                                            $maxStars = 5; // Maximum number of stars
                                            $filledStars = min(5, max(1, $review->rating)); // Ensure the rating is between 1 and 5
                                        @endphp

                                        @for ($i = 1; $i <= $maxStars; $i++)
                                            @if ($i <= $filledStars)
                                                <i class="fa-solid fa-star text-[14px] text-orange-500"
                                                    style="margin: 0 -2px;"></i>
                                            @else
                                                <i class="fa-solid fa-star text-[14px] text-gray-500"
                                                    style="margin: 0 -2px;"></i>
                                            @endif
                                        @endfor
                                    </b>
                                    <span class="text-[15px]">{{ date_format($review->created_at, 'j M Y') }}</span>
                                </div>


                                </p>
                                <p class="text-[14px] mt-[3px] bg-white inline-block">
                                    {{ $review->review }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="w-full">
                        <h2>No Review available for this product</h2>
                    </div>
                @endif

                @if ($reviews->hasPages())
                    <div class="custom-pagination" style="margin-top: 50px !important">
                        <ul class="pagination">
                            @if ($reviews->onFirstPage())
                                <li class="disabled"><span><i class="fa-solid fa-angle-left"></i> Previous</span></li>
                            @else
                                <li><a href="{{ $reviews->previousPageUrl() }}"><i class="fa-solid fa-angle-left"></i>
                                        Previous</a></li>
                            @endif

                            @foreach ($reviews->links()->elements as $element)
                                @if (is_string($element))
                                    <li class="disabled"><span>{{ $element }}</span></li>
                                @endif

                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        <li class="{{ $page == $reviews->currentPage() ? 'active' : '' }}">
                                            <a href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach
                                @endif
                            @endforeach

                            @if ($reviews->hasMorePages())
                                <li><a href="{{ $reviews->nextPageUrl() }}">Next <i
                                            class="fa-solid fa-angle-right"></i></a></li>
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
        $(document).ready(function() {
            // Handle star rating interaction
            $("#star-rating i").click(function() {
                // Remove selected state from all stars
                $("#star-rating i").removeClass("text-orange-500 fa-solid").addClass("fa-regular");

                // Toggle selected state for the clicked star and its preceding stars
                $(this).toggleClass("text-orange-500 fa-solid").prevAll().toggleClass(
                    "text-orange-500 fa-solid");

                // Ensure succeeding stars have the regular style
                $(this).nextAll().removeClass("text-orange-500 fa-solid").addClass("fa-regular");
            });






            // Handle submit review button click
            $("#submitReview").click(function() {
                // Retrieve the selected rating and review text
                var rating = $("#star-rating i.text-orange-500").length;
                var reviewText = $("#review").val();



                $.ajax({
                    url: "{{ route('account.saveReview', $product->id) }}",
                    type: 'post',
                    data: {
                        rating: rating,
                        review: reviewText
                    },
                    success: function(response) {
                        if (response.status == true) {
                            Swal.fire({
                                icon: "success",
                                title: 'success',
                                text: response.message,
                                confirmButtonText: 'Confirm',
                                showCancelButton: true,
                                cancelButtonText: 'Cancel',
                                preConfirm: (() => {
                                    window.location.reload();
                                })
                            });
                        } else if (response.status == 'loginRequired') {
                            Swal.fire({
                                icon: "warning",
                                title: 'Warning',
                                text: response.errors,
                                confirmButtonText: 'Login',
                                showCancelButton: true,
                                cancelButtonText: 'Cancel',
                                preConfirm: (() => {
                                    window.location.href =
                                        "{{ route('login') }}";
                                })
                            });
                        } else if (response.status == false) {
                            Swal.fire({
                                icon: "warning",
                                title: 'Warning',
                                text: response.errors,
                                confirmButtonText: 'Confirm'
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

            });
        });
    </script>

    <script>
        function openModal(imageSrc) {
            document.getElementById("modalImage").src = imageSrc.src;
            document.getElementById("fullscreenModal").classList.remove("hidden");
            document.getElementById("fullscreenModal").classList.add("z-50");
        }

        document
            .getElementById("hideModalImage")
            .addEventListener("click", function() {
                document.getElementById("fullscreenModal").classList.add("hidden");
            });
        const images = document.querySelectorAll(
            "#productAllImages #SiblingImages"
        );
        const mainImage = document.getElementById("mainImage");
        images.forEach((img) => {
            img.addEventListener("click", function() {

                images.forEach((otherImg) => {
                    otherImg.parentNode.classList.remove("border-gray-400");
                });

                img.parentNode.classList.add("border-gray-400");

                var imgPath = img.src;
                mainImage.src = imgPath;
            });
        });

        function updateQty(work) {
            let qty = document.getElementById('itemQty');
            let qtyValue = parseInt(qty.innerText);

            if (work == 'increase') {
                qtyValue = qtyValue + 1;
            } else if (work == 'decrease' && qtyValue >= 2) {
                qtyValue = qtyValue - 1;
            }
            qty.innerText = qtyValue;
        }
    </script>

    <script>
        function addToCart(id) {
            const url = "{{ url('add-to-cart') }}/" + id;
            const qty = document.getElementById('itemQty').innerText;
            $.ajax({
                url: url,
                type: 'post',
                data: {
                    qty: qty
                },
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
                        getCart();
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

        function addToWishlist(id) {
            $.ajax({
                url: "{{ route('account.addToWishlist') }}",
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
                            confirmButtonText: 'View wishlist',
                            showCancelButton: true,
                            cancelButtonText: 'Confirm',
                            preConfirm: (() => {
                                window.location.href = "{{ route('account.wishlists') }}"
                            })
                        });
                    } else if (response.status == 'Unauthorized') {
                        Swal.fire({
                            title: 'Login Required',
                            text: "Login to save on wishlists",
                            icon: 'warning',
                            confirmButtonText: 'Login',
                            showCancelButton: true,
                            cancelButtonText: 'Cancel',
                            preConfirm: (() => {
                                window.location.href = "{{ route('login') }}"
                            })
                        });
                    } else {
                        Swal.fire({
                            title: 'Warning',
                            text: response.errors,
                            icon: 'warning',
                            confirmButtonText: 'View wishlist',
                            showCancelButton: true,
                            cancelButtonText: 'Confirm',
                            preConfirm: (() => {
                                window.location.href = "{{ route('account.wishlists') }}"
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
