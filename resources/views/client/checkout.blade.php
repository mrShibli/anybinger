    @extends('client.layouts.app')

    @section('headers')
        <title>Request for Checkout</title>
        <!-- Include Toastr CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

        <!-- Include jQuery and Toastr JS -->
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    @endsection

    @section('contents')
        <!-- main starts here -->
        <main class="max-w-[1200px] mx-auto px-3 sm:px-6 md:px-8">
            <div class="bg-white inline-block">
                <div class="flex flex-row items-center justify-between">
                    <a href="" class="link">Home</a>
                    <i class="fa-solid fa-chevron-right text-[12px] mx-1 text-gray-700"></i>
                    <a href="" class="link">Products</a>
                </div>
            </div>
            <div>
                <h2 class="text-xl font-medium text-gray-700 mt-4 bg-white inline-block">
                    Order Request
                </h2>
            </div>
            <div class="grid items-start grid-cols-1 md:grid-cols-3 gap-3 md:gap-5 mt-2">
                <div class="w-full grid grid-cols-1 py-3 shadow-md rounded-[4px] border-t border-gray-400 px-5 bg-white">
                    <h3 class="text-[16px] mb-2">Customer Information</h3>
                    <form id="userAddress" class="flex flex-col gap-2">
                        <div class="flex justify-between">
                            <div class="w-full flex flex-col justify-between">
                                <label for="fname" class="label">User Name</label>
                                <input type="text" name="username" id="username" value="{{ Auth::user()->name }}"
                                    placeholder="User name" class="input" />
                                <p class="text-[12px] mt-[2px] text-red-600 hidden errorMessageText"></p>
                            </div>

                        </div>
                        <div class="flex flex-col justify-between">
                            <label for="mobile" class="label">Phone number</label>
                            <input type="number" name="phone" id="phone"
                                value="{{ Auth::user()->phone ? Auth::user()->phone : '' }}" placeholder="Phone number"
                                class="input" />
                            <p class="text-[12px] mt-[2px] text-red-600 hidden errorMessageText"></p>
                        </div>
                        <div class="flex flex-col justify-between">
                            <label for="email" class="label">Email address</label>
                            <input type="text" value="{{ Auth::user()->email }}" placeholder="Email address"
                                class="input" disabled />
                        </div>
                        <div class="flex flex-col justify-between">
                            <label for="address" class="label">Address</label>
                            <input type="text" name="address"
                                value="{{ Auth::user()->address ? Auth::user()->address : '' }}" placeholder="Address"
                                id="address" class="input" />
                            <p class="text-[12px] mt-[2px] text-red-600 hidden errorMessageText"></p>

                        </div>
                        <div class="flex justify-between">
                            <div class="w-[48%] flex flex-col justify-between">
                                <label for="city" class="label">City</label>
                                <input type="text" name="city" id="city"
                                    value="{{ Auth::user()->city ? Auth::user()->city : '' }}" placeholder="City"
                                    class="input" />
                                <p class="text-[12px] mt-[2px] text-red-600 hidden errorMessageText"></p>

                            </div>
                            <div class="w-[48%] flex flex-col justify-between">
                                <label for="zone" class="label">Zone</label>
                                <select name="zone" id="zone" class="select">
                                    <option value="">Select zone</option>
                                    @php
                                        $zones = ['Barishal', 'Chattogram', 'Dhaka', 'Khulna', 'Rajshahi', 'Rangpur', 'Mymensingh', 'Sylhet'];
                                    @endphp

                                    @foreach ($zones as $zone)
                                        <option value="{{ $zone }}"
                                            {{ Auth::user()->zone == $zone ? 'selected' : '' }}>{{ $zone }}</option>
                                    @endforeach
                                </select>
                                <p class="text-[12px] mt-[2px] text-red-600 hidden errorMessageText"></p>

                            </div>
                            <input type="text" id="discountCodeI" name="couponCode" hidden>
                        </div>
                        <div class="flex flex-col justify-between mb-3">
                            <label for="notes" class="label">Notes</label>
                            <textarea name="notes" id="notes" class="textarea h-[70px]" placeholder="Additional notes"></textarea>
                        </div>
                        <input type="text" name="typeOfCheckout" value="{{ $typeOfCheckout }}" hidden>
                    </form>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 col-span-1 md:col-span-2 gap-3 md:gap-5">
                    <div
                        class="grid col-span-2 sm:col-span-1 py-3 shadow-md rounded-[4px] border-t border-gray-400 px-5 bg-white">
                        <h3 class="text-[16px] mb-2">Payment method</h3>

                        <label for="" class="label !text-[14px] mt-3">We support</label>
                        <img src="{{ asset('client/images/BKash-bKash2-Logo.wine.svg') }}" alt="" class="w-20" />

                    </div>
                    <div
                        class="!overflow-hidden grid col-span-2 sm:col-span-1 py-3 shadow-md rounded-[4px] border-t border-gray-400 bg-white px-5">

                        <div class="flex flex-col gap-1 justify-center items-center">
                            <label for="" class="label">Have a coupon code?</label>
                            <div class="flex items-center gap-1">
                                <input type="text" id="DiscountCode" name="coupon" placeholder="Coupon code"
                                    class="input" />
                                <button class="btn-outline" id="DiscountApply">Apply</button>
                            </div>
                            <span class="discountString text-red-600 mt-1 text-[13px] font-medium "></span>
                        </div>
                    </div>
                    <div class="grid col-span-2 py-3 shadow-md rounded-[4px] border-t border-gray-400 bg-white px-5">
                        <h3 class="text-[16px] mb-1">Order Overview</h3>
                        <hr />

                        @if (!empty($products))
                            <table class="table-auto">
                                <thead>
                                    <tr class="bg-slate-100">
                                        <th class="label !text-gray-700 py-1 px-2">Product name</th>
                                        <th class="label !text-gray-700 py-1 px-2">Price</th>
                                        <th class="label !text-gray-700 py-1 px-2">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $subtotal = 0;
                                    @endphp
                                    @if (!empty($carts))
                                        @foreach ($products as $key => $item)
                                            @php
                                                $total = $item->price * $carts[$key]['qty'];
                                                $subtotal += $total;
                                            @endphp
                                            <tr class="border-b">
                                                {{ $item->name }}
                                                <td class="label py-1 px-2">
                                                    {{ Str::substr($item->title, 0, 30) }}
                                                </td>
                                                <td class="label py-1 px-2">
                                                    <p style="font-weight: 600 !important">
                                                        {{ $item->price }}*{{ $carts[$key]['qty'] }}x</p>
                                                </td>
                                                <td class="label py-1 px-2" style="font-weight: 600 !important">
                                                    {{ $item->price * $carts[$key]['qty'] }}&#2547;
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        @elseif(!empty($productRequests))
                            <table class="table-auto">
                                <thead>
                                    <tr class="bg-slate-100">
                                        <th class="label !text-gray-700 py-1 px-2">Product name</th>
                                        <th class="label !text-gray-700 py-1 px-2">Price</th>
                                        <th class="label !text-gray-700 py-1 px-2">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $subtotal = 0;
                                    @endphp


                                    @foreach ($productRequests as $key => $item)
                                        @php
                                            $total = $item->original_price * $item->qty;
                                            $subtotal += $total;
                                        @endphp
                                        <tr class="border-b">
                                            <td class="label py-1 px-2">
                                                {{ Str::substr($item->name, 0, 30) }}
                                            </td>
                                            <td class="label py-1 px-2">
                                                <p style="font-weight: 600 !important">
                                                    {{ $item->original_price }}*{{ $item->qty }}x</p>
                                            </td>
                                            <td class="label py-1 px-2" style="font-weight: 600 !important">
                                                {{ $total }}&#2547;
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>


                        @endif

                        <div class="text-[12px] flex justify-end items-center">
                            <div class="label py-1 px-2 !text-gray-700">Sub Total: </div>
                            <div class="label py-1 px-2">
                                <span
                                    class="text-[13px] text-orange-dark font-medium"><b>{{ $subtotal }}</b>&#2547;</span>
                            </div>
                        </div>
                        <div class="text-[12px] flex justify-end items-center">
                            <div class="label py-1 px-2 !text-gray-700">Delivery Charge:</div>
                            <div class="label py-1 px-2">
                                <span class="text-[13px] text-orange-dark font-medium">Will be added later</span>
                            </div>
                        </div>
                        <div class="text-[12px] flex justify-end items-center">
                            <div class="label py-1 px-2 !text-gray-700">Discount:</div>
                            <div class="label py-1 px-2">
                                <span class="text-[13px] text-orange-dark font-medium"><b
                                        id="DiscountAmount">0</b>&#2547;</span>
                            </div>
                        </div>
                        @if (Auth::user()->user_access == 'dealer')
                            <div class="text-[12px] flex justify-end items-center">
                                @php
                                    $dealerDiscount = \App\Models\DealerDescutn::first()->descount_dealer;
                                    $discountOfDealer = ($subtotal / 100) * $dealerDiscount ;
                                @endphp
                                <div class="label py-1 px-2 !text-gray-700">Dealer discount:</div>
                                <div class="label py-1 px-2">
                                    <span class="text-[13px] text-orange-dark font-medium"><b
                                            >{{ $discountOfDealer }}</b>&#2547;</span>
                                </div>
                                
                            </div>
                           
                        @endif
                        <div class="text-[12px] flex justify-end items-center">
                            <div class="label py-1 px-2 !text-gray-700">Total:</div>
                            <div class="label py-1 px-2">
                                <span class="text-[13px] text-orange-dark font-medium"><b
                                        id="WithDiscountTotal">{{ $subtotal }}</b>&#2547;</span>
                            </div>
                        </div>

                        <input type="text" id="totalAmount" value="{{ $subtotal }}" hidden>

                        <div class="flex flex-col sm:flex-row justify-between gap-3 mt-5">
                            <div class="flex items-center gap-[5px]">
                                <input type="checkbox" name="agree" id="agree" />
                                <label for="agree" class="label">
                                    I have read and agree to the
                                    <a href="" class="text-[12px] text-orange-dark hover:underline">Terms and
                                        Conditions</a>,
                                    <a href="" class="text-[12px] text-orange-dark hover:underline">Privacy
                                        Policy</a>
                                    and
                                    <a href="" class="text-[12px] text-orange-dark hover:underline">Refund and
                                        Return Policy</a>
                                </label>
                            </div>
                            <button class="btn block flex-center !bg-blue-dark" style="border-radius: 2px !important"
                                id="addrSubBtn">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    @endsection

    @section('customJs')
        <script>
            $('#addrSubBtn').on('click', function() {

                const formData = $('#userAddress').serializeArray();

                $('#addrSubBtn').prop('disabled', true);
                $.ajax({
                    url: "{{ route('order.storeOrder') }}",
                    type: 'post',
                    data: formData,
                    success: function(response) {
                        $('#addrSubBtn').prop('disabled', false);
                        $('.errorMessageText').addClass('hidden');
                        $('.errorMessageText').html('');
                        if (response.status == false) {
                            const firstErrorKey = Object.keys(response.errors)[0];
                            const firstErrorMessage = response.errors[firstErrorKey][0];
                            toastr.error(firstErrorMessage);

                            $.each(response.errors, function(key, value) {
                                $('#' + key).siblings('p').removeClass('hidden');
                                $('#' + key).siblings('p').html(value);
                            });
                        } else if (response.status == true) {
                            Swal.fire({
                                title: 'Success',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'Confirm',
                                showClass: {
                                    popup: 'animated fadeIn'
                                },
                                hideClass: {
                                    popup: 'animated fadeOut'
                                },
                                timer: 1500,
                                showConfirmButton: false
                            });

                            setTimeout(() => {
                                window.location.href = "{{ route('account.orders') }}";
                            }, 2000);
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: response.errors,
                                icon: 'error',
                                confirmButtonText: 'Confirm',
                                preConfirm: (() => {
                                    window.location.href = "{{ route('cart') }}"
                                })
                            });
                        }

                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error',
                            text: 'Something went wrong',
                            icon: 'error',
                            confirmButtonText: 'Confirm',
                            preConfirm: (() => {
                                window.location.reload()
                            })
                        });
                    }
                })
            })
        </script>
        <script>
            $('#DiscountApply').on('click', function() {
                const code = $('#DiscountCode').val();
                const totalAmount = $('#totalAmount').val();

                $('#DiscountApply').prop('disabled', true);
                $.ajax({
                    url: "{{ route('apply.coupon') }}",
                    type: 'get',
                    data: {
                        code: code,
                        totalAmount: totalAmount,
                    },
                    success: function(response) {
                        $('#DiscountApply').prop('disabled', false);

                        $('.discountString').addClass('hidden');

                        if (response.status == true) {
                            $('#discountCodeI').val(response.code);

                            $('.discountString').removeClass('hidden');
                            $('.discountString').html('You have got ' + response.discount +
                                'TK discount for using ' + response.code + ' coupon code');
                            $('#DiscountAmount').html(response.discount);
                            $('#WithDiscountTotal').html(totalAmount - response.discount);

                        } else if (response.status == false) {
                            $('.discountString').removeClass('hidden');
                            $('.discountString').html(response.errors);
                        }

                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error',
                            text: 'Something went wrong',
                            icon: 'error',
                            confirmButtonText: 'Confirm',
                            preConfirm: (() => {
                                window.location.reload()
                            })
                        });
                    }
                })
            });
        </script>
    @endsection
