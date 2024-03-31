<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('uploads/settings/' . $anyBringrSettings->logo) }}" type="image/png">
    @yield('headers')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Assistant:wght@200;300;400;500;600;700;800&family=Open+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('client/assets/index-2f719f37.css') }}" />
    <link rel="stylesheet" href="{{ asset('client/assets/custom.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
    
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-LRJWNT00EQ"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-LRJWNT00EQ');
</script>
    
</head>

<body class="bg-white">
    @auth
        @php
            $notificesOfme = \App\Models\Notification::where(['user_id' => Auth::user()->id, 'read' => false])
                ->latest()
                ->limit(5)
                ->get();
        @endphp
    @endauth

    @include('client.layouts.header')

    @yield('contents')

    <footer style="padding-top: 10px" class="bg-white mt-14   max-w-[1400px] mx-auto px-3 sm:px-6 md:px-8 pb6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-5 md:gap-6 overflow-hidden">
            <div class="flex flex-col">
                @if (file_exists(public_path('uploads/settings/' . $anyBringrSettings->logo)))
                    <img src="{{ asset('uploads/settings/' . $anyBringrSettings->logo) }}" alt=""
                        class="w-[70px] mb-3 drop-shadow" srcset="" />
                @else
                    <img src="{{ asset('client/images/Krisna-Chura-Logo.png') }}" alt="" srcset=""
                        class="w-[70px] mb-3 drop-shadow" />
                @endif
                <p class="text-[13px] font-medium text-blue-dark bg-white">{{ $anyBringrSettings->footer_desc }}</p>
                <div class="mt-5">
                    <h3 class="text-[15px] bg-white">Follow Us On</h3>
                    <div class="flex gap-2 mt-2">

                        @if ($anyBringrSettings->facebook_url != '')
                            <div
                                class="w-[32px] h-[32px] border flex-center rounded-full hover:bg-slate-200 hover:cursor-pointer">
                                <a href="{{ $anyBringrSettings->facebook_url }}" target="_blank">
                                    <i class="fa-brands fa-facebook-f text-blue"></i>
                                </a>
                            </div>
                        @endif
                        @if ($anyBringrSettings->youtube_url != '')
                            <div
                                class="w-[32px] h-[32px] border flex-center rounded-full hover:bg-slate-200 hover:cursor-pointer">
                                <a href="{{ $anyBringrSettings->youtube_url }}" target="_blank">
                                    <i class="fa-brands fa-youtube text-red-600"></i>
                                </a>
                            </div>
                        @endif
                        @if ($anyBringrSettings->whatsapp_url != '')
                            <div
                                class="w-[32px] h-[32px] border flex-center rounded-full hover:bg-slate-200 hover:cursor-pointer">
                                <a href="{{ $anyBringrSettings->whatsapp_url }}" target="_blank">
                                    <i class="fa-brands fa-whatsapp text-green-600"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-2 col-span-2 flex-row gap-4 md:gap-6">
                <div class="flex flex-col col-span-1">
                    <h3 class="text-[15px] bg-white">More Information</h3>
                    <hr class="h-[2px] bg-blue-dark" />
                    <div class="flex flex-col gap-2 mt-3">
                        <a href="{{ route('pages', 'about-us') }}" class="text-[14px] text-blue-dark hover:text-gray-700 bg-white">About us</a>
                        <a href="{{ route('pages', 'anybringr-shop') }}" class="text-[14px] text-blue-dark hover:text-gray-700 bg-white">Anybrinr
                            Shop</a>
                        <a href="{{ route('pages', 'help-questions') }}" class="text-[14px] text-blue-dark hover:text-gray-700 bg-white">Help & Questions</a>
                        <a href="{{ route('pages', 'contact-us') }}" class="text-[14px] text-blue-dark hover:text-gray-700 bg-white">Contact us</a>
                    </div>
                </div>
                <div class="flex flex-col col-span-1">
                    <h3 class="text-[15px] bg-white">Customer Area</h3>
                    <hr class="h-[2px] bg-blue-dark" />
                    <div class="flex flex-col gap-2 mt-3">
                        <a href="{{ route('account.index') }}" class="text-[14px] text-blue-dark hover:text-gray-700 bg-white">My account</a>
                        <a href="{{ route('account.orders') }}" class="text-[14px] text-blue-dark hover:text-gray-700 bg-white">Orders</a>
                        <a href="{{ route('account.wishlists') }}" class="text-[14px] text-blue-dark hover:text-gray-700 bg-white">Wishlist</a>
                        <a href="{{ route('track.order') }}" class="text-[14px] text-blue-dark hover:text-gray-700 bg-white">Track Your
                            Order</a>
                    </div>
                </div>
            </div>
            <div class="flex flex-col">
                <div>
                    <h3 class="text-[15px] bg-white">Get In Touch</h3>
                    <hr class="bg-blue-dark h-[2px]" />
                    <div class="flex items-center gap-3 mt-3">

                        <div class="flex flex-col">
                            <p class="text-small bg-white">Customer Support / Marketing Agent:</p>
                            <span
                                class="text-small font-medium bg-white">{{ $anyBringrSettings->service_phone ? $anyBringrSettings->service_phone : '+880 1798-833-942' }}</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 mt-3">
                        <div class="flex flex-col">
                            <p class="text-small bg-white">Official Email:</p>
                            <span
                                class="text-[14px] ">{{ $anyBringrSettings->service_email ? $anyBringrSettings->service_email : 'anybringr@email.com' }}</span>
                        </div>
                    </div>
                </div>
                <div class="mt-6">
                    <h3 class="text-[15px] bg-white">For Your Complain</h3>
                    <hr class="bg-blue-dark h-[2px]" />
                    <div class="flex items-center gap-3 mt-3">
                        <i class="fa-solid fa-envelopes-bulk text-xl text-gray-700"></i>
                        <div class="flex flex-col">
                            <p class="text-small bg-white">Office Time:</p>
                            <span class="text-small font-medium bg-white">
                                {{ $anyBringrSettings->office_time ? $anyBringrSettings->office_time : '10AM - 6PM' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="bg-blue-dark my-5 md:mt-8 md: mb-6" />
        <div class="flex flex-wrap justify-center items-center gap-4 md:gap-8">
            <a href="{{ route('pages', 'privacy-policy') }}"
                class="text-[12px] sm:text-[13px] font-medium text-slate-700 hover:text-slate-600 bg-white">PRIVACY
                POLICY</a>
            <a href="{{ route('pages', 'terms-conditions') }}"
                class="text-[12px] sm:text-[13px] font-medium text-slate-700 hover:text-slate-600 bg-white">TERMS &
                CONDITIONS</a>
            <a href="{{ route('pages', 'refund-policy') }}"
                class="text-[12px] sm:text-[13px] font-medium text-slate-700 hover:text-slate-600 bg-white">REFUND &
                RETURN POLICY</a>
            <a href="{{ route('pages', 'delivery-policy') }}"
                class="text-[12px] sm:text-[13px] font-medium text-slate-700 hover:text-slate-600 bg-white">DELIVERY
                POLICY</a>
            <a href="{{ route('pages', 'faqs') }}"
                class="text-[12px] sm:text-[13px] font-medium text-slate-700 hover:text-slate-600 bg-white">FAQS</a>
        </div>
    </footer>
    <div class="mx-auto  bg-blue-dark">
        <div
            class="max-w-[1400px] mx-auto px-6 py-2 lg:py-3 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-[14px] text-white text-center">&copy; 2023-24 Copyright by Anybringr | Designed & Developed
                by
                <a href="" class="text-[13px] text-w-lws">DevArtisan</a>
            </p>
            <img src="/client/images/bkash.png" alt="" class="bg-white h-6 md:h-7 "
                style="padding-left: 10px" />
        </div>
    </div>

    <div class="mt13 largemt0"></div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    <!-- javascript codes -->
    <script type="text/javascript">
        function dropdown() {
            $("#submenu").slideToggle();
            var $arrow = $("#arrowss");
            if ($arrow.hasClass('rotate-0')) {
                $arrow.removeClass('rotate-0').addClass('rotate-180');
            } else {
                $arrow.removeClass('rotate-180').addClass('rotate-0');
            }
        }

        dropdown();

        function openSidebar() {
            var $sidebar = $(".sidebar");
            if ($sidebar.is(":hidden")) {
                $sidebar.animate({
                    width: 'toggle'
                }, 300);
            } else {
                $sidebar.animate({
                    width: 'toggle'
                }, 300, function() {
                    $sidebar.hide();
                });
            }
        }

        function showMenus() {
            $('#userMenu').slideToggle('hidden');
        }

        function userNotifys() {
            $('#userNotifys').slideToggle('hidden');
        }

        function getCart() {
            $.ajax({
                url: "{{ route('cartCount') }}",
                type: 'get',
                success: function(response) {
                    var cartCountsElements = document.querySelectorAll('#cartCounts');

                    cartCountsElements.forEach(function(element) {
                        element.innerText = response.cartCount;
                    });
                }
            });
        }


        getCart();
    </script>

    <script>
        const texts = [
            "Paste a product link from a USA/UK-based store",
            "Search for a product. Example  t-shirts, shoe "
        ];

        const typingContainer = document.getElementById("typing-container");
        search = document.getElementById('productSearch');
        requestItem = document.getElementById('requestItem');

        function HideShowDiv() {
            typingContainer.classList.add('hidden');
            search.focus();
            requestItem.classList.remove('hidden');
            requestItem.classList.add('flex');
        }
        search.addEventListener('focus', () => {
            requestItem.classList.remove('hidden');
            requestItem.classList.add('flex');
        });
        search.addEventListener('keypress', () => {

            if (search.value.length > 0) {
                typingContainer.classList.add('hidden');
            } else {
                typingContainer.classList.remove('hidden');
            }
        });

        document.body.addEventListener('click', (event) => {
            // Check if the clicked element is not the search input or typingContainer
            if (!event.target.matches('#productSearch') && !event.target.matches('.typing-container')) {
                typingContainer.classList.remove('hidden');
                requestItem.classList.add('hidden');
                requestItem.classList.remove('flex');
            }

            if (!search.value.length == 0) {
                typingContainer.classList.add('hidden');
            }
        });


        function typeText(index) {
            const text = texts[index];
            let charIndex = 0;

            function type() {
                if (charIndex < text.length) {
                    typingContainer.textContent += text.charAt(charIndex);
                    charIndex++;
                    setTimeout(type, 50); // Adjust the typing speed
                } else {
                    setTimeout(() => {
                        fadeOut();
                    }, 500); // Adjust the pause duration before fading out
                }
            }

            function fadeOut() {
                let opacity = 1;
                const fadeOutInterval = setInterval(() => {

                    typingContainer.textContent = "";
                    typingContainer.style.opacity = 1;

                    // Move to the next text
                    index = (index + 1) % texts.length;
                    setTimeout(() => {
                        typeText(index);
                    }, 400); // Adjust the pause duration before typing the next text

                    clearInterval(fadeOutInterval);

                }, 50);
            }

            // Start typing the text
            type();
        }

        // Start the animation with the first text
        typeText(0);
    </script>


    <script>
        function showSearchMobile() {
            var showOnMobileElement = $('#ShowOnMobilee');
            var searchIconElement = $('#searchIcon');

            showOnMobileElement.toggleClass('activate');

            if (showOnMobileElement.hasClass('activate')) {
                searchIconElement.removeClass('fa-search').addClass('fa-times');
                showOnMobileElement.slideDown();
            } else {
                searchIconElement.removeClass('fa-times').addClass('fa-search');
                showOnMobileElement.slideUp();
            }
        }

        $('#pSearchFrom').on('submit', function(e) {
            e.preventDefault();

            const searche = $('#productSearch').val();

            if (searche && searche.trim() !== '') {
                const url = "{{ route('redirectSearch') }}";
                $('#SearchButton').prop('disabled', true);
                $.ajax({
                    url: url,
                    type: 'get',
                    data: {
                        search: searche
                    },
                    success: function(response) {
                        $('#SearchButton').prop('disabled', false);

                        let redirectUrl;
                        if (response.status == 'search') {
                            redirectUrl = `{{ route('products', ['search' => ':search']) }}`.replace(
                                ':search', response.search);
                        } else {
                            const encodedSearch = encodeURIComponent(response.search);
                            redirectUrl = `{{ route('requestProduct') }}?url=${encodedSearch}`;
                        }

                        window.location.href = redirectUrl;
                    },
                    error: function() {
                        swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong, please try later',
                            confirmButtonText: 'Confirm',
                            preConfirm: () => {
                                window.location.reload();
                            }
                        });
                    }
                });
            }
        });
    </script>

    @yield('customJs')
</body>

</html>
