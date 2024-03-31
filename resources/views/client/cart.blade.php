@extends('client.layouts.app')

@section('headers')
<title>Order Cart page</title>
@endsection


@section('contents')
    <!-- main starts here -->
    <main class="max-w-[1400px] mx-auto px-3 mt-3 sm:px-6 md:px-8">
        <div class="bg-white inline-block">
            <div class="flex flex-row items-center justify-between">
                <a href="{{ route('index') }}" class="link">Home</a>
                <i class="fa-solid fa-chevron-right text-[12px] mx-1 text-gray-700"></i>
                <a href="" class="link">Cart</a>
            </div>
        </div>
        <div class="mt-3 max-w-[1200px] mx-auto">
            @if (!empty($carts))
                <h2 class="text-[20px] font-medium">
                    Shopping Cart
                    <span class="text-small !text-yellow-600">{{ count($carts) }} items</span>
                </h2>
                <div class="grid items-start grid-cols-1 md:grid-cols-11 gap-4 md:gap-6 lg:gap-10 mt-2">
                    <div class="grid md:col-span-7 overflow-x-auto sm:overflow-x-hidden">
                        <table class="bg-white table-auto border-collapse border border-slate-300">
                            <thead>
                                <tr>
                                    <th class="hidden sm:block border-y border-slate-300 text-sm text-start p-3">
                                        <span class="text-[14px] font-medium">Image</span>
                                    </th>
                                    <th class="border-y border-slate-300 text-sm text-start p-3">
                                        <span class="text-[14px] font-medium">Product</span>
                                    </th>
                                    <th class="border-y border-slate-300 text-sm text-start p-3">
                                        <span class="text-[14px] font-medium">Quantity</span>
                                    </th>
                                    <th class="border-y border-slate-300 text-sm text-start p-3">
                                        <span class="text-[14px] font-medium">Price</span>
                                    </th>
                                    <th class="border-y border-slate-300 text-sm text-start p-3">
                                        <span class="text-[14px] font-medium">Total</span>
                                    </th>
                                    <th class="border-y border-slate-300 text-sm text-start p-3">
                                        <span class="text-[14px] font-medium">Action</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="cartProducts">

                                @foreach ($products as $key => $product)
                                    <tr id="itemDiv-{{ $product->id }}">
                                        <td class="hidden sm:block">
                                            @php
                                                $productFirstImage = $product
                                                    ->productImage()
                                                    ->latest()
                                                    ->first();
                                                $productImage = $productFirstImage ? $productFirstImage : null;
                                                $quantity = $carts[$key]['qty'];
                                            @endphp
                                            <img src="{{ $productImage ? asset('uploads/products/' . $productImage->name) : asset('client/images/650.png') }}"
                                                alt="" class="w-[50px] max-h-[60px] mx-auto " />
                                        </td>
                                        <td class="p-3">
                                            <a href="{{ route('product', $product->slug) }}"
                                                class="text-[14px] link !leading-3">{{ Str::substr($product->title, 0, 18) . '...' }}</a>
                                        </td>
                                        <td class="p-3">
                                            <div class="flex justify-between items-center " style="width: 65px">
                                                <button type="button" onclick="updateQty({{ $product->id }}, 'decrease')"
                                                    class="flex-center border border-orange-dark rounded-sm w-[22px] h-[22px]"
                                                    id="decrementBtn">
                                                    <i class="fa-solid fa-minus text-[11px]"></i>
                                                </button>
                                                <button class="text-[13px] font-medium px-2 border" value=""
                                                    disabled=""><span id="qtyValue">{{ $quantity }}</span></button>
                                                <button type="button" onclick="updateQty({{ $product->id }}, 'increase')"
                                                    class="flex-center border border-orange-dark rounded-sm w-[22px] h-[22px]"
                                                    id="incrementBtn">
                                                    <i class="fa-solid fa-plus text-[11px]"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="p-3">
                                            <p>
                                                <span class="text-[14px] text-orange-dark font-medium">&#2547;<b
                                                        id="price">{{ $product->price }}</b></span>
                                            </p>
                                        </td>
                                        <td class="p-3">
                                            <p>
                                                <span class="text-[14px] text-orange-dark font-medium">&#2547;<b
                                                        id="totalPrice">{{ $product->price * $quantity }}</b></span>
                                            </p>
                                        </td>
                                        <td class="p-3">
                                            <button onclick="removeFromCart({{ $product->id }})"
                                                class="hover:text-gray-600 px-2 md:px-3 py-[2px]">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div
                        class="bg-white grid items-start md:col-span-4 border border-slate-300 rounded-md shadow-sm p-3 md:p-4">
                        <h2 class="text-[16px] font-medium text-gray-800 uppercase mb-2 text-center">
                            Order Summery
                        </h2>
                        <div class="flex flex-col mt-2 gap-1 mb-1">
                            @php
                                $subtotal = 0;
                            @endphp

                            @foreach ($products as $key => $product)
                                @php
                                    $total = $product->price * $carts[$key]['qty'];
                                    $subtotal += $total;
                                @endphp
                                <div class="flex justify-between items-center" id="order-{{ $product->id }}">
                                    <p class="text-[14px] text-gray-700 font-medium">
                                        {{ Str::substr($product->title, 0, 15) }} <b
                                            id="orderQty">{{ $carts[$key]['qty'] }}</b>x
                                    </p>
                                    <span class="text-[14px] text-orange-dark font-medium">&#2547;<b
                                            id="orderPrice">{{ $total }}</b></span>
                                </div>
                            @endforeach


                        </div>
                        <hr class="bg-slate-600" />
                        <div class="flex justify-between items-center mt-1">
                            <p class="text-[14px]  font-medium text-blue-dark">Subtotal</p>
                            <span class="text-[14px]  text-orange-dark font-medium">&#2547;<b
                                    id="orderSubTotal">{{ $subtotal }}</b></span>
                        </div>

                        {{-- <div class="flex justify-between items-center">
                            <p class="text-[14px]  font-medium text-blue-dark">
                                Tax and Platform fees
                            </p>
                            <span class="text-[14px]  text-orange-dark font-medium">&#2547;4000</span>
                        </div> --}}
                        {{-- <a href="{{ route('order.request') }}"><button class="btn-outline text-[15px]  mt-5">Request order</button></a> --}}
                        <a href="{{ route('order.checkout', 'custom') }}"><button class="btn-outline text-[15px]  mt-5">Request order</button></a>
                    </div>
                    {{-- {{ dd($carts) }} --}}
                </div>
            @else
                <div class="bg-white mx-auto p-5 flex flex-col justify-center my-5">
                    <h2 class="text-[20px] text-center font-medium mt-2">No products in your cart</h2>
                    <a href="{{ route('products') }}" class=" mx-auto mt-6"><button class="btn-outline  w-[100px]">Go to
                            Shop</button></a>
                </div>
            @endif
        </div>
    </main>

@endsection

@section('customJs')
    <script>
        function removeFromCart(id) {
            $.ajax({
                url: "{{ route('removeFromCart') }}",
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

        function updateQty(id, work) {
            const itemDiv = document.querySelector('#itemDiv-' + id);
            const qtyValue = itemDiv.querySelector('#qtyValue');

            if (work == 'decrease' && qtyValue.innerText <= 1) {
                swal.fire({
                    title: 'Warning',
                    text: 'Minimum product quantity is 1',
                    icon: 'warning',
                    confirmButtonText: 'Confirm',
                })
            } else {
                $.ajax({
                    url: "{{ route('updateCart') }}",
                    type: 'post',
                    data: {
                        id: id,
                        work: work
                    },
                    success: function(response) {
                        if (response.status == true) {
                            const price = itemDiv.querySelector('#price');
                            const totalPrice = itemDiv.querySelector('#totalPrice');
                            const orderItem = document.getElementById('order-' + id);
                            const orderQty = orderItem.querySelector('#orderQty');
                            const orderPrice = orderItem.querySelector('#orderPrice');

                            qtyValue.innerText = response.cartQty;
                            price.innerText = response.price;
                            totalPrice.innerText = response.totalPrice;
                            orderQty.innerText = response.cartQty;
                            orderPrice.innerText = response.totalPrice;
                            orderSubTotal.innerText = response.subTotal;
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

        }
    </script>
@endsection
