    @extends('client.layouts.app')

    @section('headers')
        <title>{{ $travelerSetting->title }}</title>
        <meta name="keywords" content="{{ $travelerSetting->meta_keyword }}" />
        <meta name="description" content="{{ $travelerSetting->meta_description }}" />

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
        <meta name="copyright" content="© {{ $travelerSetting->title }}" />
        <meta property='og:locale' content='en_US' />
        <meta property="og:locale:alternate" content='bn_BD' />
        <meta property="og:title" content="{{ $travelerSetting->title }}" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="https://www.anybringr.com/" />
        <meta property="og:image" content="" />
        <meta property="og:site_name" content="Anybringr" />
        <meta property="fb:app_id" content="235034696605750" />

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    @endsection

    @section('contents')
        <!-- main -->
        <main class="w-full max-w-[1400px] mx-auto px-3 mt-3 sm:px-6 md:px-8">
            <div
                class="flex justify-between items-end md:items-start  lg:overflow-hidden relative h-auto lg:h-[85vh] xl:max-h-[600px] mb-[450px] sm:mb-[300px] md:mb-[200px] lg:mb-10">
                @if ($travelerSetting->traveler_banner != '')
                    <img src="{{ asset('uploads/settings/') . '/' . $travelerSetting->traveler_banner }}" alt=""
                        class="w-full h-auto rounded-md">
                @else
                    <img src="{{ asset('client/images/best-travel-backpacks-blog-900x600.jpg') }}" alt=""
                        class="w-full h-auto rounded-md">
                @endif


                <div class="absolute top-0 left-0 bottom-0 right-0 bg-slate-900 opacity-50 rounded-md"></div>

                <div
                    class="absolute top-0 left-0 bottom-0 right-0 flex  flex-col lg:flex-row items-center justify-around opacity-100">
                    <div
                        class="w-full flex flex-col items-center lg:items-start gap-1 absolute top-6 lg:left-8 lg:relative">
                        <h2
                            class="text-2xl font-bold md:text-3xl lg:text-4xl text-white text-shadow text-center lg:text-left textsms mb-3" >
                            {!! wordwrap($travelerSetting->traveler_heading, 38, '<br>', true) !!}</h2>
                        <p class="text-[16px] md:!text-xl text-gray-200 text-center lg:text-left"
                            style="max-width: 750px; margin: 0 5px">
                            {{ $travelerSetting->traveler_desc }}
                        </p>

                    </div>

                    <div
                        class="flex flex-col gap-2 shadow-md px-6 py-4 bg-white  rounded-md w-[100%] xs:w-[380px] absolute top-[220px] justify-end lg:relative lg:top-0 lg:right-8">
                        <h2 class="text-[22px] font-medium">How you will earn</h2>

                        <!--<div class="flex flex-col gap-1">-->
                        <!--    <label for="" class="label !text-[16px]">Where are you from</label>-->
                        <!--    <select name="" id="" class="select !py-2 rounded-md">-->
                        <!--        <option value="" class="py-2">Bangladesh</option>-->
                        <!--        <option value="" class="py-2">United States</option>-->
                        <!--        <option value="" class="py-2">United kingdom</option>-->
                        <!--        <option value="" class="py-2">Canada</option>-->
                        <!--    </select>-->
                        <!--</div>-->

                        <div class="flex flex-col gap-1">
                            <label for="" class="label !text-[16px]">How much luggage space do you have?</label>
                            <select name="" id="" class="select !py-2 rounded-md">
                                <option value="" class="py-2">One luggage</option>
                                <option value="" class="py-2">Two luggages</option>
                                <option value="" class="py-2">Three luggages</option>
                                <option value="" class="py-2">More than three luggages</option>
                            </select>
                        </div>

                        <div class="flex flex-col gap-1">
                            <label for="" class="label !text-[16px]">Approx</label>
                            <h2 class="text-3xl font-bold">$75 - $125*</h2>

                            <p class="text-[14px] font-medium">You will earn 75 - 125 dollers for carring these bags</p>
                        </div>

                        <button
                            class="w-[150px] py-2 bg-orange-dark rounded-md text-white mt-4 hover:bg-orange-600 focus:ring ring-orange-400">Get
                            <a href="{{ route('traveler.req') }}">Started Now</a>
                        </button>
                    </div>
                </div>
            </div>


            <div class="w-full flex flex-col items-center justify-center">
                <h1 class="text-3xl font-medium text-center">How it works?</h1>

                <div class="w-[100%] md:w-[70%] lg:w-[60%] mx-auto mt-4">
                    <h2 class="my-3 text-[20px] font-medium text-slate-800 text-center">
                        {{ $travelerSetting->youtube_title }}</h2>
                    <div
                        class="w-full md:w-full h-[300px] sm:h-[320px] md:h-[320px] lg:h-[440px] rounded-md mx-auto mb-14 lg:mb-0 ">

                        <iframe class="w-full h-full" src="{{ $travelerSetting->youtube_video }}"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen></iframe>

                    </div>
                </div>

                @if ($travelerReview->isNotEmpty())
                    <div class="mt-16 w-full mx-auto px-3 sm:px-6 md:px-8">

                        <h1 class="text-3xl font-medium text-center !mb-5">Customer satisfaction</h1>
                        <br>
                        <div class="swiper !h-[300px]   shadow-md">
                            <div class="swiper-wrapper ">
                                @foreach ($travelerReview as $review)
                                    <div class="swiper-slide bggray flex-center">
                                        <div class="w-[300px] sm:w-[400px] md:w-[550px] lg:w-[650px]  mx-auto mt-4">
                                            <p class="text-sm"><i
                                                    class="fa-solid fa-quote-left text-3xl text-gray-700 mr-2"></i>{{ $review->review }}
                                            </p>

                                            <h2 class="text-[18px] font-bold text-gray-800 mt-4 capitalize">
                                                {{ $review->name }}</h2>
                                            <h4 class="text-[15px]">{{ $review->about }}</h4>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- <div class="swiper-pagination"></div> -->

                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>

                        </div>
                        
                    </div>
                @endif
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


        </main>
    @endsection

    @section('customJs')
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
                //   delay: 3000, // Set the delay in milliseconds (e.g., 5000 for 5 seconds)
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
    @endsection
