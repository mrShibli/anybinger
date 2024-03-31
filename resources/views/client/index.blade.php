@extends('client.layouts.app')
@php
    $banner = $anyBringrSettings->banner_image;
    $bannerImage = $banner ? asset('uploads/settings/' . $banner) : asset('client/images/home-bg.jpg');
@endphp
@section('headers')
    <link rel="contents" href="https://www.anybringr.com" title="{{ $anyBringrSettings->title }}">
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
    <meta name="copyright" content="© {{ $anyBringrSettings->title }}" />
    <meta property='og:locale' content='en_US' />
    <meta property="og:locale:alternate" content='bn_BD' />
    <meta property="og:title" content="{{ $anyBringrSettings->title }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://www.anybringr.com/" />
    <meta property="og:image" content="{{ $bannerImage }}" />
    <meta property="og:site_name" content="Anybringr" />
    <meta property="fb:app_id" content="235034696605750" />


    <title>{{ $anyBringrSettings->title }}</title>
    <meta name="keywords" content="{{ $anyBringrSettings->meta_keyword }}" />
    <meta name="description" content="{{ $anyBringrSettings->meta_description }}" />
    <meta name="audience" content="Everyone" />
    <meta name="robots" content="index, follow" />
    <meta name="author" content="Anybringr" />
    <meta name="publisher" content="Anybringr" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        /* For small screens and up */
        .marginA {
            margin-top: 1.25rem;
        }

        /* For medium screens and up */
        @media (min-width: 768px) {
            .marginA {
                margin-top: 3.5rem;
            }

            .sm25px {
                font-size: 25px !important;
            }
        }
    </style>
@endsection

@section('contents')

    <!-- sliders -->
    <div class="marginA w-[96%] sm:w-[94%] md:max-w-[1400px] bg-white  mx-auto">
        <div class="swiper rounded-md !w-full !h-full  shadow-2xl drop-shadow-2xl !bg-transparent">

            <div class="swiper-wrapper !w-full !h-full">
                @if ($sliders->isNotEmpty())
                    @foreach ($sliders as $slider)
                        <div class="swiper-slide !w-full !h-full">
                            <img src="{{ asset('uploads/sliders/' . $slider->image) }}" alt=""
                                class="w-full h-full">
                            @if ($slider->text != '')
                                <div class="bannerDiv z-10">
                                    <a href="{{ $slider->link }}" target="_blank" class="bannerBtn">{{ $slider->text }}</a>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif

            </div>

            <div class="swiper-pagination">
            </div>
            <div class="swiper-button-prev">
            </div>
            <div class="swiper-button-next">
            </div>
        </div>
    </div>

    @if ($homeCard->status == 'published')
        <section class="hidden lg:block ">
            <div class="flex flex-wrap justify-around mt-16 max-w-[1400px] mx-auto px-3 sm:px-6 md:px-8">
                @if ($homeCard->title1 != '')
                    <div class="flex flex-col justify-between border rounded-md max-w-[290px] mt-5 p-4 bg-white">
                        <p class="font-bold text-[19px] cursor-pointer">{{ $homeCard->title1 }}</p>
                        <p>{{ $homeCard->desc1 }}</p>
                    </div>
                @endif
                @if ($homeCard->title2 != '')
                    <div class="flex flex-col justify-between border rounded-md max-w-[290px] mt-5 p-4 bg-white">
                        <p class="font-bold text-[19px] cursor-pointer">{{ $homeCard->title2 }}</p>
                        <p>{{ $homeCard->desc2 }}</p>
                    </div>
                @endif
                @if ($homeCard->title3 != '')
                    <div class="flex flex-col justify-between border rounded-md max-w-[290px] mt-5 p-4 bg-white">
                        <p class="font-bold text-[19px] cursor-pointer">{{ $homeCard->title3 }}</p>
                        <p>{{ $homeCard->desc3 }}</p>
                    </div>
                @endif
                @if ($homeCard->title4 != '')
                    <div class="flex flex-col justify-between border rounded-md max-w-[290px] mt-5 p-4 bg-white">
                        <p class="font-bold text-[19px] cursor-pointer">{{ $homeCard->title4 }}</p>
                        <p>{{ $homeCard->desc4 }}</p>
                    </div>
                @endif




            </div>
        </section>
    @endif
    <!-- main -->
    <div
        class="flex  items-center gap-4 sm:gap-6 flex-col md:flex-row relative h-auto mt-16 max-w-[1400px] mx-auto px-3 sm:px-6 md:px-8">
        @if ($specialProduct)
            <div class="w-full md:w-[50%] mt-4" style="align-item: center; align-self: stretch;">
                <div class="product   bg-w-lws !border-t-0" style="height: 100%">
                    @php
                        $productImages = $specialProduct->product
                            ->productImage()
                            ->latest('id', 'desc')
                            ->first();
                        $imageName = $productImages ? $productImages->name : null;
                        $discount = $specialProduct->product->compare_price - $specialProduct->product->price;
                    @endphp
                    <div class="flex w-full h-full !justify-center relative group cursor-pointer overflow-clip">
                        @if ($specialProduct->product->compare_price > 0)
                            <div style="height: 40px"
                                class="px-3 bg-gradient-to-r from-pink-400 to-pink-600  text-white flex-center absolute top-1 left-1 rounded-full">
                                <span class="text-[14px]">{{ $discount }}&#2547; Discount</span>
                            </div>
                        @endif
                        <a href="{{ route('product', $specialProduct->product->slug) }}">
                            <img src="{{ $imageName ? asset('uploads/products/' . $imageName) : asset('client/images/650.png') }}"
                                alt="" class="w-full rounded-lg h-full" />
                        </a>
                    </div>
                    <div class="mt-2 w-full group relative px-4">
                        <a href="{{ route('product', $specialProduct->product->slug) }}"
                            class="link pb-1 text-center block font-extrabold" style="font-size: 21px"
                            id="sm25px">{{ $specialProduct->product->title }}</a>
                        <p class="flex justify-center items-center" style="margin-bottom: 8px ">
                            @php
                                $reviews = \App\Models\Review::where('product_id', $specialProduct->id)
                                    ->where('status', 'published')
                                    ->get();
                                $totalRating = $reviews->isEmpty() ? 0 : $reviews->avg('rating');
                                $maxStars = 5;
                                $filledStars = $totalRating ? min(5, max(1, $totalRating)) : 5;
                            @endphp

                            @for ($i = 1; $i <= $maxStars; $i++)
                                @if ($i <= $filledStars)
                                    <i class="fa-solid fa-star text-[15px] text-orange-500"></i>
                                @else
                                    <i class="fa-solid fa-star text-[15px] text-gray-500"></i>
                                @endif
                            @endfor
                            <b class="  text-[15px]"
                                style="padding-left: 6px !important">{{ number_format($totalRating, 1) }}</b>
                        </p>
                        <div class="flex items-center justify-end gap-2">
                            <div
                                class="px-[5px] hidden lg:block mr-16 py-1 bg-white  border rounded-[20px]  transition ease-in duration-150">
                                <button class="mx-4" onclick="addToCart({{ $specialProduct->product->id }})">
                                    <i
                                        class="fa-solid fa-cart-shopping icons text-slate-600 hover:text-gray-500 transition"></i>
                                </button>
                                <button class="mx-4" onclick="addToWishlist({{ $specialProduct->product->id }})">
                                    <i class="fa-regular fa-heart icons text-slate-600 hover:text-gray-500 transition"></i>
                                </button>
                                <a href="{{ route('product', $specialProduct->product->slug) }}"><button class="mx-4">
                                        <i
                                            class="fa-solid fa-link icons text-slate-600 hover:text-gray-500 transition"></i>
                                    </button></a>

                            </div>
                            @if ($specialProduct->product->compare_price != '')
                                <p class="text-[13px] line-through text-dark">
                                    &#2547;{{ $specialProduct->product->compare_price }}</p>
                            @endif

                            <span
                                class="text-[20px] font-extrabold bg-gradient-to-r from-rose-700 to-pink-600 text-transparent bg-clip-text">&#2547;{{ number_format($specialProduct->product->price, 2) }}</span>
                        </div>
                        <div
                            class="px-[5px] block mx-auto lg:hidden w-[200px] py-1 bg-white  border rounded-[20px]  transition ease-in duration-150">
                            <button class="mx-4">
                                <i
                                    class="fa-solid fa-cart-shopping icons text-slate-600 hover:text-gray-500 transition"></i>
                            </button>
                            <button class="mx-4">
                                <i class="fa-regular fa-heart icons text-slate-600 hover:text-gray-500 transition"></i>
                            </button>
                            <button class="mx-4">
                                <i class="fa-solid fa-link icons text-slate-600 hover:text-gray-500 transition"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif


        <a href="{{ route('products') }}"
            class="absolute -top-6 right-5 cursor-pointer border-b-2 border-spacing-1 text-xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-pink-500 to-violet-500">
            SPECIAL OFFER</a>
        @if ($latestProduct)
            <div class="w-full md:w-[50%] flex flex-wrap mt-4 gap-y-2 " style="align-items: stretch;">
                @foreach ($latestProduct as $product)
                    <div
                        class="product bg-white   mx-auto border !rounded-none p-[1px] !shadow-none lg:h-[360px] justify-between max-w-[48%] overflow-hidden">
                        <div class="flex justify-center items-center w-full relative group cursor-pointer overflow-clip">
                            @php
                                $productImages = $product
                                    ->productImage()
                                    ->latest()
                                    ->first();
                                $imageName = $productImages ? $productImages->name : null;
                                $discount = $product->compare_price - $product->price;
                                $title = Str::substr($product->title, 0, 25);
                                if (strlen($product->title) >= 25) {
                                    $title .= '...';
                                }
                            @endphp

                            @if ($product->compare_price > 0)
                                <div
                                    class="px-2 py-1 bg-red-500 text-white rounded-full flex-center absolute top-1 left-1">
                                    <span class="text-[10px]">-{{ $discount }}&#2547;</span>
                                </div>
                            @endif
                            <a href="{{ route('product', $product->slug) }}"><img
                                    src="{{ $imageName ? asset('uploads/products/' . $imageName) : asset('client/images/650.png') }}"
                                    alt="" class="w-full h-full rounded-lg mx-auto" /></a>



                        </div>
                        <div class="mt-2 w-full p-2">
                            <a href="{{ route('product', $product->slug) }}"
                                class="link !text-[15px]">{{ $title }}</a>

                            <div class="flex flex-col sm:flex-row items-center gap-2 justify-center">
                                @if ($product->compare_price > 0)
                                    <p class="text-[13px] line-through text-gray-600">
                                        &#2547;{{ number_format($product->compare_price, 2) }}
                                    </p>
                                @endif
                                <span
                                    class="text-[18px] font-bold text-red-500">&#2547;{{ number_format($product->price, 2) }}</span>
                            </div>
                        </div>
                        <div class="mx-auto px-[8px] bg-white  gap-2  visible  border  rounded-[20px] flex ">
                            <button onclick="addToCart({{ $product->id }})">
                                <i
                                    class="fa-solid fa-cart-shopping icons text-slate-600 hover:text-gray-500 transition"></i>
                            </button>
                            <button onclick="addToWishlist({{ $product->id }})">
                                <i class="fa-regular fa-heart icons text-slate-600 hover:text-gray-500 transition"></i>
                            </button>
                            <a href="{{ route('product', $product->slug) }}"><button>
                                    <i class="fa-solid fa-link icons text-slate-600 hover:text-gray-500 transition"></i>
                                </button></a>

                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
    </div>
    </div>


    <!-- customer feedback -->

    <h1 class=" mx-auto px-3 sm:px-6 md:px-8 text-2xl md:text-3xl font-extrabold text-center mt-14 mb-7"
        style="padding-top: 20px">Customer feedback at Anybringr</h1>
    <div class="max-w-[1400px] mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 px-3 sm:px-6 md:px-8 "
        id="FeedbackDiv">

    </div>



    <!-- frequently asked questions -->
    @if ($faqs->isNotEmpty())
        <div class=" flex justify-center items-start  max-w-[1400px] mx-auto px-3 sm:px-6 md:px-8"
            style="margin-top: 120px">
            <div class="w-full  mx-2 sm:mx-0 sm:w-10/12 md:w-3/5 my-1">
                <h2 class="text-2xl text-center font-semibold text-vnet-blue mb-2">Frequently Asked Questions</h2>
                <ul class="flex flex-col bg-white ">

                    @foreach ($faqs as $faq)
                        <li class="bg-white my-3 accordion-item border">
                            <h2 class="flex flex-row justify-between items-center font-semibold p-3 cursor-pointer">
                                <span>{{ $faq->title }}</span>
                                <svg class="fill-current text-blue-dark h-6 w-6 transform transition-transform duration-500 rotate-icon"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M13.962,8.885l-3.736,3.739c-0.086,0.086-0.201,0.13-0.314,0.13S9.686,12.71,9.6,12.624l-3.562-3.56C5.863,8.892,5.863,8.611,6.036,8.438c0.175-0.173,0.454-0.173,0.626,0l3.25,3.247l3.426-3.424c0.173-0.172,0.451-0.172,0.624,0C14.137,8.434,14.137,8.712,13.962,8.885 M18.406,10c0,4.644-3.763,8.406-8.406,8.406S1.594,14.644,1.594,10S5.356,1.594,10,1.594S18.406,5.356,18.406,10 M17.521,10c0-4.148-3.373-7.521-7.521-7.521c-4.148,0-7.521,3.374-7.521,7.521c0,4.147,3.374,7.521,7.521,7.521C14.148,17.521,17.521,14.147,17.521,10">
                                    </path>
                                </svg>
                            </h2>
                            <div class="border-l-2 border-gray-700 overflow-hidden max-h-0 duration-500 transition-all tab-content "
                                style="height: 200px">
                                <p class="p-3 text-gray-900">{{ $faq->description }}</p>
                            </div>
                        </li>
                    @endforeach

                </ul>
            </div>
        </div>
    @endif


    <!-- bottom banner -->

    <div class="flex-center flex-col relative mt-16 w-[96%] md:max-w-[1400px] mx-auto px-3 sm:px-6 md:px-8 bg-cover"
        style="background-image: url('{{ $bannerImage }}')">
        <div class="absolute inset-0 bg-black opacity-50">
        </div>
        <h1 class="text-[#fff] z-10 text-center text-[30px] font-extrabold mt-10 md:mt-40">
            {{ $anyBringrSettings->banner_title }}</h1>
        <h2 class="text-[#fff] z-10 text-sm text-center mt-5 px-3 md:text-xl font-bold mt-1 " style="max-width: 800px">
            {{ $anyBringrSettings->banner_paragraph }}</h2>
        <a href="{{ $anyBringrSettings->banner_link }}" class="z-10">
            <button
                class="bg-blue-dark text-white py-3 px-5 border border-white rounded-sm hover:bg-transparent mt-10 mb-20 md:mb-40 z-10">{{ $anyBringrSettings->banner_btn }}</button>
        </a>

    </div>



@endsection

@section('customJs')
    @include('client.layouts.javascripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Create a store object to hold the state
            const accordionStore = {
                tab: 0,
            };

            // Function to handle click event
            function handleClick(idx) {
                accordionStore.tab = accordionStore.tab === idx ? 0 : idx;
                updateAccordion();
            }

            // Function to handle rotate class
            function handleRotate(idx) {
                return accordionStore.tab === idx ? "rotate-180" : "";
            }

            // Function to handle toggle style
            function handleToggle(idx, tabElement) {
                return accordionStore.tab === idx ?
                    `max-height: ${tabElement.scrollHeight}px` :
                    "";
            }

            // Function to initialize accordion items
            function initAccordionItems() {
                const accordionItems = document.querySelectorAll(".accordion-item");

                accordionItems.forEach((item, idx) => {
                    item.addEventListener("click", function() {
                        handleClick(idx);
                    });
                    item.querySelector(".rotate-icon").className = handleRotate(idx);
                    item.querySelector(".tab-content").style.cssText = handleToggle(
                        idx,
                        item.querySelector(".tab-content")
                    );
                });
            }

            // Function to update accordion items based on store state
            function updateAccordion() {
                const accordionItems = document.querySelectorAll(".accordion-item");

                accordionItems.forEach((item, idx) => {
                    const rotateIcon = item.querySelector(".rotate-icon");
                    const tabContent = item.querySelector(".tab-content");

                    rotateIcon.className =
                        "fill-current text-blue-dark h-6 w-6 transform transition-transform duration-500 rotate-icon " +
                        handleRotate(idx);
                    tabContent.style.cssText = handleToggle(idx, tabContent);
                });
            }


            // Initialize accordion
            initAccordionItems();
        });
    </script>

    <script type="module">
        // Initialize Swiper
        const swiper = new Swiper('.swiper', {
            loop: true,
            // autoplay: {
            //   delay: 3000, 
            // },
            // Other options...
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    </script>

    <script>
        $(window).on('load', function() {
            var feedbacks = `@if ($feedback->feedback1 != '')
            <div
                class="w-full md:w-full h-[180px] md:h-[200px] lg:h-[190px] xs:h-[300px] xl:h-[250px] rounded-md mx-auto mb-14 lg:mb-0 ">
                <iframe class="w-full h-full " src="{{ $feedback->feedback1 }}" title="YouTube video player"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    loading: 'lazy'
                    allowfullscreen>
                </iframe>
                <div class="w-full">
                    <h2 class="text-[22px] font-bold text-center text-blue-dark mt-3 ">{{ $feedback->shopper1 }}</h2>
                    <h4 class="text-[18px] text-center">Shopper at Anybringr</h4>
                </div>
            </div>
        @endif


        @if ($feedback->feedback2 != '')
            <div
                class="w-full md:w-full h-[180px] md:h-[200px] lg:h-[190px] xs:h-[300px] xl:h-[250px] rounded-md mx-auto mb-14 lg:mb-0 ">
                <iframe class="w-full h-full " src="{{ $feedback->feedback2 }}" title="YouTube video player"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    loading: 'lazy'
                    allowfullscreen>
                </iframe>
                <div class="w-full">
                    <h2 class="text-[22px] font-bold text-center text-blue-dark mt-3 ">{{ $feedback->shopper2 }}</h2>
                    <h4 class="text-[18px] text-center">Shopper at Anybringr</h4>
                </div>
            </div>
        @endif

        @if ($feedback->feedback3 != '')
            <div
                class="w-full md:w-full h-[180px] md:h-[200px] lg:h-[190px] xs:h-[300px] xl:h-[250px] rounded-md mx-auto mb-14 lg:mb-0 ">
                <iframe class="w-full h-full " src="{{ $feedback->feedback3 }}" title="YouTube video player"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    loading: 'lazy'
                    allowfullscreen>
                </iframe>
                <div class="w-full">
                    <h2 class="text-[22px] font-bold text-center text-blue-dark mt-3 ">{{ $feedback->shopper3 }}</h2>
                    <h4 class="text-[18px] text-center">Shopper at Anybringr</h4>
                </div>
            </div>
        @endif`;

            setTimeout(() => {
                $('#FeedbackDiv').html(feedbacks);
            }, 2000);

        })
    </script>
@endsection
