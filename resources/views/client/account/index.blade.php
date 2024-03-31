@extends('client.layouts.app')

@section('headers')
    <title>My account</title>
    @include('client.layouts.pagination')
@endsection

@section('contents')
    <!-- main starts here -->
    <main class="mt-3 max-w-[1200px] mx-auto px-3 sm:px-6 md:px-8">
        <div class="bg-white inline-block">
            <div class="flex flex-row items-center justify-between">
                <a href="{{ route('index') }}" class="link">Home</a>
                <i class="fa-solid fa-chevron-right text-[12px] mx-1 text-gray-700"></i>
                <a href="{{ route('account.index') }}" class="link">Account</a>
            </div>
        </div>
        <div class="flex flex-col md:flex-row items-start gap-4 mt-4 px-2 sm:px-4">
            <div class="bg-white w-full flex justify-between md:flex-col md:max-w-[200px] items-center gap-1 md:gap-0"
                id="profileBtn">
                <button
                    class="w-full p-4 shadow-md flex justify-center md:justify-start gap-2 md:shadow-none md:rounded-none rounded-md border md:border-gray-400 md:border-b-0 md:rounded-t-md">
                    <i class="fa-regular fa-address-card text-[20px] text-blue-dark"></i>
                    <span class="text-[15px] hidden md:block">Profile Information</span>
                </button>
                <button
                    class="w-full p-4 shadow-md flex justify-center md:justify-start gap-2 md:shadow-none md:rounded-none rounded-md border md:border-gray-400 md:border-b-0">
                    <i class="fa-solid fa-wallet text-[20px] text-blue-dark"></i>
                    <span class="text-[15px] hidden md:block">My Wallet</span>
                </button>
                <button
                    class="w-full p-4 shadow-md flex justify-center md:justify-start gap-2 md:shadow-none md:rounded-none rounded-md border md:border-gray-400 md:border-b-0">
                    <i class="fa-solid fa-lock text-[20px] text-blue-dark"></i>
                    <span class="text-[15px] hidden md:block">Reset Password</span>
                </button>
                <button
                    class="w-full p-4 shadow-md flex justify-center md:justify-start gap-2 md:shadow-none md:rounded-none rounded-md border md:border-gray-400 md:rounded-b-md">
                    <i class="fa-solid fa-bag-shopping text-[20px] text-blue-dark"></i>
                    <span class="text-[15px] hidden md:block">Shipping Address</span>
                </button>
            </div>
            <div class="w-full bg-white" id="profileForms">
                <!-- profile -->
                <div class="w-full !p-5 !px-8 accounts" id="Pform">
                    <div class="my-1 flex justify-between items-center">
                        <h2 class="sm:text-[21px] text-[19px] mb-[6px] text-slate-700">
                            Personal Informations
                        </h2>
                        <button id="showHideBtn" class="btn sm:w-[100px] text-center w-[60px] !bg-blue-dark">
                            Update
                        </button>
                    </div>
                    <div id="profileInfo">
                        <div class="my-1 flex items-center gap-1">
                            <i class="fa-solid text-[20px] fa-user text-gray-700"></i>
                            <h1 class="ml-3 text-[15px]">{{ Auth::user()->name }}</h1>
                        </div>
                        <div class="my-1 flex items-center gap-1">
                            <i class="fa-solid text-[20px] fa-envelope text-gray-700"></i>
                            <h1 class="ml-3 text-[15px]">{{ Auth::user()->email }}</h1>
                        </div>
                        <div class="my-1 flex items-center gap-1">
                            <i class="fa-solid text-[20px] fa-phone text-gray-700"></i>
                            <h1 class="ml-3 text-[15px]">
                                {{ Auth::user()->phone ? Auth::user()->phone : 'No phone number added' }}</h1>
                        </div>
                        <div>
                            <i class="fa-solid fa-wallet text-[20px] text-blue-dark mr-1"></i>
                            <span class="text-[15px] ml-2">Wallet balance:</span>
                            <span class="font-bold text-red-500">&#2547;{{ Auth::user()->balance }}</span>
                        </div>
                        <div class="!mt-4 flex lg:!flex-row !flex-col xs:flex-row xs:flex-wrap gap-1 my-3">
                            <div
                                class="w-[70%] xs:w-[60%] mx-auto lg:mx-0 lg:w-auto flex justify-between items-center gap-3 px-5 py-3 shadow rounded-sm border">
                                <i class="fa-solid fa-cart-flatbed text-2xl md:text-sm text-blue-dark"></i>
                                <a href="{{ route('account.orders') }}"
                                    class="!text-[14px] md:text-[15px] font-medium text-red-500">
                                    {{ $orderCount }} orders
                                </a>

                            </div>
                            <div
                                class="w-[70%] xs:w-[60%] mx-auto lg:mx-0 lg:w-auto flex justify-between items-center gap-3 px-5 py-3 shadow rounded-sm border">
                                <i class="fa-solid fa-hourglass-half text-2xl md:text-sm text-blue-dark"></i>
                                <a href="{{ route('account.requests') }}"
                                    class="!text-[14px] md:text-[15px] font-medium text-red-500">
                                    {{ $productreqCount }} Requests
                                </a>
                            </div>
                            <div
                                class="w-[70%] xs:w-[60%] mx-auto lg:mx-0 lg:w-auto flex justify-between items-center gap-3 px-5 py-3 shadow rounded-sm border">
                                <i class="fa-solid fa-arrow-right-arrow-left text-2xl md:text-sm text-blue-dark"></i>
                                <h2 class="!text-[14px] md:text-[15px] font-medium text-red-500">
                                    {{ $transactions->count() }} Transaction
                                </h2>
                            </div>
                            <div
                                class="w-[70%] xs:w-[60%] mx-auto lg:mx-0 lg:w-auto flex justify-between items-center gap-3 px-5 py-3 shadow rounded-sm border">
                                <i class="fa-solid fa-person-walking-luggage text-2xl md:text-sm text-blue-dark"></i>
                                <h2 class="!text-[14px] md:text-[15px] font-medium text-red-500">
                                    0 Carries
                                </h2>
                            </div>
                        </div>
                    </div>

                    <form action="" id="profileForm" class="hidden">
                        <div class="w-full flex flex-col gap-1">
                            <label for="name" class="text-[15px] text-gray-800">Username</label>
                            <input type="text"
                                class="w-full px-2 py-[3px] border border-slate-400 outline-none focus:!border-slate-700 rounded-sm"
                                placeholder="Your username" value="{{ Auth::user()->name }}" name="name">
                        </div>

                        <div class="w-full flex flex-col gap-1">
                            <label for="email" class="text-[15px] text-gray-800">Email</label>
                            <input type="email"
                                class="w-full px-2 py-[3px] border border-slate-400 outline-none focus:!border-slate-700 rounded-sm"
                                placeholder="Your Email" value="{{ Auth::user()->email }}" name="email" disabled>
                        </div>

                        <div class="w-full flex flex-col gap-1">
                            <label for="phone" class="text-[15px] text-gray-800">Phone number</label>
                            <input type="number"
                                class="w-full px-2 py-[3px] border border-slate-400 outline-none focus:!border-slate-700 rounded-sm"
                                placeholder="Phone no" value="{{ Auth::user()->phone }}" name="phone">
                        </div>
                        <h2 class="my-2 font-medium">Change password</h2>
                        <div class="w-full flex flex-col gap-1">
                            <label for="password" class="text-[15px] text-gray-800">New password</label>
                            <input type="text"
                                class="w-full px-2 py-[3px] border border-slate-400 outline-none focus:!border-slate-700 rounded-sm"
                                placeholder="enter new password" value="" name="password">
                        </div>
                        <button id="updateBtn1" class="btn-outline mt-4">Update </button>
                    </form>

                </div>

                <!-- wallet -->
                <div class="w-full accounts !p-5 px-5 !hidden" id="Pform">

                    <div class="my-1 flex justify-between items-center">
                        <h2 class="sm:text-[21px] text-[20px] mb-[6px] text-slate-700">
                            My wallet
                        </h2>
                        <button id="withBtns" class="btn sm:w-[100px] w-[90px] !bg-blue-dark">
                            Withdraw
                        </button>
                    </div>

                    <div>
                        <i class="fa-solid fa-wallet text-[20px] text-blue-dark mr-1"></i>
                        <span class="text-[15px] ml-2">Wallet balance:</span>
                        <span class="font-bold text-red-500">&#2547;{{ Auth::user()->balance }}</span>
                    </div>
                    <div id="withdrawalReqest">
                        <h2 class="mt-4 mb-3 font-medium">My recent transaction</h2>

                        <div class="w-full flex flex-col gap-2">
                            
                                {{-- <div class="flex justify-between items-center border px-2 py-2 my-1">
                                    <div class="flex justify-center items-center gap-2">
                                        <span class="text-[14px] font-medium">Withdrawal request</span>
                                        <p class="text-[14px] font-medium">500 BDT</p>
                                    </div>

                                    <div class="flex justify-center items-center gap-2">
                                        <i class="fa-solid fa-right-left text-red-600 mr-2"></i>
                                        
                                        <span class="text-[13px] bg-green-600 text-white px-[5px] py-[2px] rounded-md">Success</span>
                                    </div>
                                </div> --}}

                            @if ($transactions->isNotEmpty())
                                @foreach ($transactions as $pay)

                                <div class="flex justify-between items-center border px-2 py-2 my-1">
                                    <div class="flex justify-center items-center gap-2">
                                        <span class="text-[14px] font-medium">
                                            {{ $pay->type == 'discount' ? 'Order discount' : ($pay->type == 'payment' ? 'Order Payment' : 'Withdrawal request') }}
                                        </span>
                                        <p class="text-[14px] font-medium">{{ $pay->amount }}Tk</p>
                                    </div>

                                    <div class="flex justify-center items-center gap-2">
                                        <i class="fa-solid fa-right-left  {{ $pay->status == 'completed' ? 'text-green-600' : 'text-red-600' }} mr-2"></i>
                                        
                                        <span class="text-[13px]  {{ $pay->status == 'completed' ? 'bg-green-600' : 'bg-red-600' }} text-white px-[5px] py-[2px] rounded-md">
                                        @if ($pay->status == 'awaiting')
                                            Awaiting
                                        @elseif ($pay->status == 'completed')
                                            Completed
                                        @else
                                            Cancelled
                                        @endif
                                        </span>
                                    </div>
                                </div>

                                

                                @endforeach
                            @else
                                <div class="flex justify-center items-center px-2 py-1 my-2">

                                    <p class="text-[17px]">No transaction made</p>
                                </div>
                            @endif
                            
                        </div>

                        @if ($transactions->hasPages())
                            <div class="custom-pagination" style="margin-top: 50px !important">
                                <ul class="pagination">
                                    @if ($transactions->onFirstPage())
                                        <li class="disabled"><span><i class="fa-solid fa-angle-left"></i> Previous</span></li>
                                    @else
                                        <li><a href="{{ $transactions->previousPageUrl() }}"><i class="fa-solid fa-angle-left"></i> Previous</a></li>
                                    @endif

                                    @foreach ($transactions->links()->elements as $element)
                                        @if (is_string($element))
                                            <li class="disabled"><span>{{ $element }}</span></li>
                                        @endif

                                        @if (is_array($element))
                                            @foreach ($element as $page => $url)
                                                <li class="{{ $page == $transactions->currentPage() ? 'active' : '' }}">
                                                    <a href="{{ $url }}">{{ $page }}</a>
                                                </li>
                                            @endforeach
                                        @endif
                                    @endforeach

                                    @if ($transactions->hasMorePages())
                                        <li><a href="{{ $transactions->nextPageUrl() }}">Next <i class="fa-solid fa-angle-right"></i></a></li>
                                    @else
                                        <li class="disabled"><span>Next <i class="fa-solid fa-angle-right"></i></span></li>
                                    @endif
                                </ul>
                            </div>
                        @endif
                    </div>

                    <form id="withdrawForm" class="mt-2 hidden">
                        <h2 class="mt-4 mb-3 font-medium">Request for a withdrawal</h2>
                        <div class="w-full flex flex-col gap-1">
                            <label for="number" class="text-[15px] text-gray-800">Enter your bkash number</label>
                            <input type="number"
                                class="w-full px-2 py-[3px] border border-slate-400 outline-none focus:!border-slate-700 rounded-sm"
                                placeholder="Your bkash number" name="phone">
                        </div>

                        <div class="w-full flex flex-col gap-1">
                            <label for="number" class="text-[15px] text-gray-800">Enter amount</label>
                            <input type="amount"
                                class="w-full px-2 py-[3px] border border-slate-400 outline-none focus:!border-slate-700 rounded-sm"
                                placeholder="Enter withdrawal amount" name="amount">
                        </div>

                        <button id="withdrawBtn" class="btn-outline mt-4">Withdraw</button>
                    </form>

                </div>

                <!-- wallet -->
                <div class="w-full accounts !p-5 !px-8 !hidden" id="Pform">
                    <h2 class="text-[21px] mb-[6px] text-slate-700">Reset Password</h2>
                    <div class="w-full flex flex-col gap-1">
                        <label for="name" class="text-[15px] my-2 text-gray-800">You can reset your password while
                            updating your profile information</label>
                    </div>

                </div>

                <!-- Address update -->
                <div class="w-full accounts !p-5 !px-8 !hidden" id="Pform">
                    <form id="updateAddressForm">
                        <h2 class="text-[21px] mb-[6px] text-slate-700">
                            Update Shipping Address
                        </h2>
                        <div class="w-full flex flex-col gap-1">
                            <label for="name" class="text-[15px] text-gray-800">Email</label>
                            <input type="text"
                                class="w-full px-2 py-[3px] border border-slate-400 outline-none focus:!border-slate-700 rounded-sm"
                                placeholder="Your Email" value="{{ Auth::user()->email }}" name="name" disabled />
                        </div>
                        <div class="w-full flex flex-col gap-1">
                            <label for="name" class="text-[15px] text-gray-800">Phone number</label>
                            <input type="number"
                                class="w-full px-2 py-[3px] border border-slate-400 outline-none focus:!border-slate-700 rounded-sm"
                                placeholder="Phone no" value="{{ Auth::user()->phone }}" name="phone" />
                        </div>
                        <div class="w-full flex flex-col gap-1">
                            <label for="address" class="text-[15px] text-gray-800">Address</label>
                            <input type="text"
                                class="w-full px-2 py-[3px] border border-slate-400 outline-none focus:!border-slate-700 rounded-sm"
                                placeholder="Your Bio" value="{{ Auth::user()->address }}" name="address" />
                        </div>


                        <div class="w-full flex flex-col gap-1">
                            <label for="city" class="text-[15px] text-gray-800">City</label>
                            <input type="text"
                                class="w-full px-2 py-[3px] border border-slate-400 outline-none focus:!border-slate-700 rounded-sm"
                                placeholder="Your Bio" value="{{ Auth::user()->city }}" name="city" />
                        </div>
                        <div class="w-full flex flex-col gap-1">
                            <label for="zone" class="text-[15px] text-gray-800">Zone</label>
                            <select name="zone" id="zone" class="text-[15px] select">
                                <option value="">Select zone</option>
                                @php
                                    $zones = ['Barishal', 'Chattogram', 'Dhaka', 'Khulna', 'Rajshahi', 'Rangpur', 'Mymensingh', 'Sylhet'];
                                @endphp

                                @foreach ($zones as $zone)
                                    <option value="{{ $zone }}"
                                        {{ Auth::user()->zone == $zone ? 'selected' : '' }}>
                                        {{ $zone }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button class="btn-outline mt-4" id="updateAddress">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('customJs')
    <script>
        const profileBtn = document.querySelectorAll("#profileBtn button");
        const profileForms = document.querySelectorAll("#profileForms #Pform");
        profileBtn.forEach((btn, index) => {
            btn.addEventListener("click", function() {
                profileForms.forEach((form, i) => {
                    if (index === i) {
                        form.classList.remove("!hidden");
                        form.classList.add("!block");
                    } else {
                        form.classList.remove("!block");
                        form.classList.add("!hidden");
                    }
                });
            });
        });
    </script>

    <script>
        function formToggle() {
            $('#profileInfo').toggle('hidden');
            $('#profileForm').toggle('hidden');

            const newText = $('#showHideBtn').text() === 'Cancel' ? 'Update' : 'Cancel';
            $('#showHideBtn').text(newText);
        }


        function withdrawToggle() {
            $('#withdrawForm').toggle('hidden');
            $('#withdrawalReqest').toggle('hidden');

            const newText = $('#withBtns').text() === 'Cancel' ? 'Withdraw' : 'Cancel';
            $('#withBtns').text(newText);
        }


        $('#withBtns').on('click', withdrawToggle);

        $('#showHideBtn').on('click', formToggle);

        $('#profileForm').on('submit', function(e) {
            e.preventDefault();
            const formData = $(this).serializeArray();
            $('#updateBtn1').prop('disabled', true);
            $.ajax({
                url: "{{ route('account.updateProfile') }}",
                type: 'put',
                data: formData,
                success: function(response) {
                    $('#updateBtn1').prop('disabled', false);

                    if (response.status == true) {
                        swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            confirmButtonText: 'Confirm'
                        });
                        formToggle();
                    } else {
                        swal.fire({
                            icon: 'warning',
                            title: 'Warning',
                            text: response.errors,
                            confirmButtonText: 'Confirm'
                        });
                    }
                },
                error: function() {
                    swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong',
                        confirmButtonText: 'Confirm'
                    });
                }
            })
        })

        $('#updateAddressForm').on('submit', function(e) {
            e.preventDefault();
            const formData = $(this).serializeArray();
            $('#updateAddress').prop('disabled', true);
            $.ajax({
                url: "{{ route('account.updateAddress') }}",
                type: 'put',
                data: formData,
                success: function(response) {
                    $('#updateAddress').prop('disabled', false);

                    if (response.status == true) {
                        swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            confirmButtonText: 'Confirm'
                        });
                        window.location.reload();
                    } else {
                        swal.fire({
                            icon: 'warning',
                            title: 'Warning',
                            text: response.errors,
                            confirmButtonText: 'Confirm'
                        });
                    }
                },
                error: function() {
                    swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong',
                        confirmButtonText: 'Confirm'
                    });
                }
            })
        })

        $('#withdrawForm').on('submit', function(e){
            e.preventDefault();
            const formData = $(this).serializeArray();
            $('#withdrawBtn').prop('disabled', true);
            $.ajax({
                url: "{{ route('account.withdraw') }}",
                type: 'post',
                data: formData,
                success: function(response) {
                    $('#withdrawBtn').prop('disabled', false);

                    if (response.status == true) {
                        swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            confirmButtonText: 'Confirm'
                        });
                        window.location.reload();
                    } else {
                        swal.fire({
                            icon: 'warning',
                            title: 'Warning',
                            text: response.errors,
                            confirmButtonText: 'Confirm'
                        });
                    }
                },
                error: function() {
                    swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong',
                        confirmButtonText: 'Confirm'
                    });
                }
            })
        })
    </script>
@endsection
