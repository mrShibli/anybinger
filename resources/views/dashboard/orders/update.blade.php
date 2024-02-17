@extends('dashboard.layouts.app')

@section('contents')
    @include('dashboard.layouts.sidebar')
    <!-- Main Content -->
    <div class="main-content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center py-3">
                            <h2 class="h5 mb-0"><a href="#" class="text-muted"></a> Order {{ $order->invoice_id }}</h2>
                            <div class="d-flex justify-content-center align-items-center px-2">

                                @if ($order->status == 'cancelled')
                                    <button disabled class="btn btn-danger">Order
                                        cancelled</button>
                                @else
                                    <button onClick="cancelOrder({{ $order->id }})" class="btn btn-danger">Cancel
                                        order</button>
                                @endif
                                <a href="{{ route('invoice.download', $order->id) }}">
                                    <button class=" btn btn-warning mx-2"
                                        style="padding: 5px 12px; font-size: 11px;"> {{ $order->status == 'delivered' ? 'Download Invoice' : 'Not delivered!' }} </button>
                                </a>
                                <a href="{{ route('orders.index') }}"><button class="btn btn-primary mx-2">Back</button></a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-8">

                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="mb-3 d-flex justify-content-between">
                                            <div>
                                                @if (!empty($order->orderItem()->first()->product_id))
                                                    <span class="badge badge-info">Custom order</span>
                                                @else
                                                    <span class="badge badge-danger">Request order</span>
                                                @endif
                                            </div>
                                            <div>

                                                <span
                                                    class="me-3">{{ date_format($order->created_at, 'j M Y - h:i:s A') }}</span>

                                                @if ($order->status == 'cancelled' || $order->status == 'pending')
                                                    <span
                                                        class="badge rounded-pill bg-danger text-white">{{ $order->status }}</span>
                                                @elseif ($order->status == 'pending_payment')
                                                    <span
                                                        class="badge rounded-pill bg-warning text-white">{{ $order->status }}</span>
                                                @else
                                                    <span
                                                        class="badge rounded-pill bg-info text-white">{{ $order->status }}</span>
                                                @endif

                                            </div>
                                        </div>
                                        <table class="table table-borderless">
                                            <tbody>

                                                @foreach ($order->orderItem as $item)
                                                    @if ($item->product_id)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center mb-2"
                                                                    style="{{ $item->status == 'cancelled' ? 'color: red !important' : '' }}">
                                                                    <div class="flex-shrink-0">
                                                                        <img src="{{ asset('uploads/products/' . $item->image) }}"
                                                                            alt width="35"
                                                                            class="img-fluid image-rounded mr-2">
                                                                    </div>
                                                                    <div class="flex-lg-grow-1 ms-3">
                                                                        <h5 class="small mb-0" style="font-size: 13px"><a
                                                                                href=""
                                                                                class="text-reset">{{ Str::substr($item->name, 0, 35) }}</a>
                                                                        </h5>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>{{ $item->qty }}x</td>

                                                            <td class="text-end">{{ $item->total }}<b
                                                                    style="font-size: 18px !important">&#2547;</b> </td>



                                                            <td class="d-flex align-items-center px-2">
                                                                @if ($item->status != 'cancelled')
                                                                    @if ($order->status != 'delivering' && $order->status != 'delivered' && $order->status != 'cancelled')
                                                                        <button style="margin-right: 8px"
                                                                            class="btn btn-warning"
                                                                            onclick="updateProduct('custom',{{ $item->id }},{{ $item->product_id }},'{{ $item->name }}')">
                                                                            <i class="fa-solid fa-edit"></i>
                                                                        </button>
                                                                    @endif


                                                                    @if ($order->status != 'delivering' && $order->status != 'delivered' && $order->status != 'cancelled')
                                                                        <button class="btn btn-danger"
                                                                            onclick="deleteItem({{ $order->id }},{{ $item->id }})"><i
                                                                                class="fa-solid fa-trash"></i></button>
                                                                    @endif
                                                                @else
                                                                    <p
                                                                        style="margin-bottom: 0px !important; color: red !important; font-size: 14px !important">
                                                                        Cancelled by admin</p>
                                                                @endif
                                                            </td>

                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center mb-2">
                                                                    <div class="flex-shrink-0">
                                                                        <img src="{{ asset('uploads/requests/' . $item->image) }}"
                                                                            alt width="35"
                                                                            class="img-fluid image-rounded mr-2">
                                                                    </div>
                                                                    <div class="flex-lg-grow-1 ms-3">
                                                                        <h5 class="small mb-0" style="font-size: 13px"><a
                                                                                href=""
                                                                                class="text-reset">{{ Str::substr($item->name, 0, 35) }}</a>
                                                                        </h5>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>{{ $item->qty }}x</td>
                                                            <td class="text-end">{{ $item->total }}<b
                                                                    style="font-size: 18px !important">&#2547;</b> </td>

                                                            <td class="d-flex align-items-center px-2">
                                                                @if ($item->status != 'cancelled')
                                                                    @if ($order->status != 'delivering' && $order->status != 'delivered' && $order->status != 'cancelled')
                                                                        <button style="margin-right: 8px"
                                                                            class="btn btn-warning"
                                                                            onclick="updateProduct('request',{{ $item->id }},{{ $item->r_product_id }},'{{ $item->name }}')"><i
                                                                                class="fa-solid fa-edit"></i></button>
                                                                    @endif

                                                                    @if ($order->status != 'delivering' && $order->status != 'delivered' && $order->status != 'cancelled')
                                                                        <button class=" btn btn-danger"
                                                                            onclick="deleteItem({{ $order->id }},{{ $item->id }})"><i
                                                                                class="fa-solid fa-trash"></i></button>
                                                                    @endif
                                                                @else
                                                                    <p
                                                                        style="margin-bottom: 0px !important; color: red !important; font-size: 14px !important">
                                                                        Cancelled by admin</p>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="2">Subtotal</td>
                                                    <td class="text-end">{{ $order->total }}<b
                                                            style="font-size: 18px !important">&#2547;</b></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">Shipping</td>
                                                    <td class="text-end">{{ $order->fees }}<b
                                                            style="font-size: 18px !important">&#2547;</b></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">Discount (Code:
                                                        {{ $order->discount_code ? $order->discount_code : 'No coupon applied' }})
                                                    </td>
                                                    <td class="text-end">{{ $order->discount }}<b
                                                            style="font-size: 18px !important">&#2547;</b></td>
                                                </tr>
                                                <tr class="fw-bold">
                                                    <td colspan="2">TOTAL</td>
                                                    <td class="text-end">
                                                        {{ $order->total + $order->fees - $order->discount }}<b
                                                            style="font-size: 18px !important">&#2547;</b></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                                <div class="card mb-4">
                                    <div class="card-body">

                                        <div class="d-flex justify-content-between">
                                            <h2 style="font-size: 19px !important">Payment Information</h2>

                                            <div>
                                                <span class="badge text-white"
                                                    style="background-color: rgb(193, 30, 243);">Paid
                                                    {{ $order->paid ? $order->paid : 0 }}<b
                                                        style="font-size: 15px !important">&#2547;</b></span>
                                                <span class="badge text-white"
                                                    style="background-color: rgb(250, 67, 67);">Due
                                                    {{ $order->total + $order->fees - $order->paid - $order->discount }}<b
                                                        style="font-size: 15px !important">&#2547;</b></span>
                                                @if ($order->status != 'cancelled')
                                                    <button
                                                        onclick="createPayment({{ $order->id }},{{ $order->user->id }})"
                                                        class="btn text-white "
                                                        style="padding: 2px 6px; background: rgb(27, 129, 245)">Create
                                                        payment</button>
                                                @endif
                                            </div>
                                        </div>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Id</th>
                                                    <th scope="col">Payment number</th>
                                                    <th scope="col">trxID</th>
                                                    <th scope="col">Amount</th>
                                                    <th scope="col">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($payments->isNotEmpty())
                                                    @foreach ($payments as $payment)
                                                        <tr class="!p-1">
                                                            <td>{{ $payment->id }}</td>
                                                            <td>{{ $payment->payment_number ?? 'Not paid' }}</td>
                                                            <td>{{ $payment->trxID ?? 'Not paid' }}</td>
                                                            <td>{{ $payment->pay_amount }}</td>
                                                            @if ($payment->status == 'pending')
                                                                <td class="text-danger">
                                                                @if ($order->status == 'cancelled')
                                                                    Cancelled
                                                                @else
                                                                {{ $payment->status }}
                                                                @endif
                                                                </td>
                                                            @else
                                                                <td class="text-success">{{ $payment->status }}</td>
                                                            @endif
                
                                        @if ($payment->status == 'paid')
                                                            <td>
                                                                <form action="{{ route('refundViewPost') }}" method="post" class="input-group" style="width: 30%">
                                                                    @csrf
                                                                    <input type="hidden" value="{{ $payment->id }}" name="id">
                                                                    <input type="hidden" value="{{ $payment->paymentID }}" name="paymeent_id">
                                                                    <input type="hidden" value="{{ $payment->trxID }}" name="trungsetion_id">
                                                                    <input type="hidden" value="{{ $payment->pay_amount }}" name="amount">
                                                                    <button type="submit">Submit</button>
                                                                </form>
                                                            </td>
                                                            @endif
                
                
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <td colspan="4">No Payment made</td>
                                                @endif
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card mb-4">
                                    <div class="card-body mb-4">
                                        @if ($order->status == 'pending')
                                            <h3 class="h6">Approve & confirm order</h3>
                                            <form id="orderApproveForm">

                                                <div class="mb-2">
                                                    <label>Delivery charge</label>
                                                    <input type="number" name="fees" class=""
                                                        style="padding: 4px 8px !important;">
                                                </div>

                                                <div class="mb-2">
                                                    <label>Payment type</label>
                                                    <select class="py-1" name="payment_type" id="SelectAmount">
                                                        <option value="half">Half</option>
                                                        <option value="full">Full</option>
                                                        <option value="custom">Custom amount</option>
                                                    </select>
                                                </div>

                                                <div class="mb-2" id="customAmountDiv">
                                                    <label>Enter custom amount</label>
                                                    <input type="number" name="custom_amount" class=""
                                                        style="padding: 4px 8px !important;">
                                                </div>

                                                <button id="orderApproveBtn" class="btn btn-success">Approve
                                                    order</button>
                                            </form>
                                        @elseif($order->status == 'pending_payment')
                                            <h3 class="h6">Waiting for customer payment .. <br> <br>
                                                Once customer make payment then you can update order status</h3>
                                        @elseif($order->status == 'cancelled')
                                            <h3 class="h6">This order has been cancelled by admin <br> <br>
                                            @else
                                                <h3 class="h6">Update order status</h3>
                                                <form>
                                                    <div class="mb-2">
                                                        <label>Order status</label>
                                                        <select class="py-1" name="order_status" id="updateStatusVal">
                                                            @if ($order->status != 'delivered')
                                                                <option value="flight"
                                                                    {{ $order->status == 'flight' ? 'selected' : '' }}>In
                                                                    flight
                                                                </option>
                                                                <option value="in_country"
                                                                    {{ $order->status == 'in_country' ? 'selected' : '' }}>
                                                                    In
                                                                    country</option>
                                                                <option value="delivering"
                                                                    {{ $order->status == 'delivering' ? 'selected' : '' }}>
                                                                    Delivering</option>
                                                            @endif


                                                            <option value="delivered"
                                                                {{ $order->status == 'delivered' ? 'selected' : '' }}>
                                                                Delivered
                                                                to home</option>
                                                        </select>
                                                    </div>

                                                    @if ($order->status != 'delivered')
                                                        <div class="mb-2">
                                                            <label>Add a order note</label>
                                                            <textarea name="admin_notes" id="admin_notes" class="form-control" style="height: 100px !important"
                                                                maxlength="250"></textarea>
                                                        </div>

                                                        <button id="orderStatusUpdate" class="btn btn-success">Update
                                                            status</button>
                                                    @endif
                                                </form>
                                        @endif

                                    </div>
                                </div>
                                <div class="card mb-4">

                                    <div class="card-body">
                                        <h3 class="h6">Shipping Information</h3>
                                        <strong>Customer:</strong> {{ $order->user->name }}<br>
                                        <strong>Phone:</strong> {{ $order->user->phone }}<br>
                                        <strong>Email:</strong> {{ $order->user->email }}

                                        {{-- <span><a href="#" class="text-decoration-underline"
                                            target="_blank">FF1234567890</a> <i
                                            class="bi bi-box-arrow-up-right"></i> </span> --}}
                                        <hr>
                                        <h3 class="h6">Address</h3>
                                        <address>
                                            <strong>City:</strong> {{ $order->user->city }}<br>
                                            <strong>Zone:</strong> {{ $order->user->zone }}<br>
                                            <strong>Address:</strong> {{ $order->user->address }}<br>
                                            <strong>Zipcode:</strong> {{ $order->user->address }}<br>
                                        </address>
                                    </div>
                                </div>

                                <div class="card mb-4">
                                    <div class="card-body">
                                        <h3 class="h6">Customer Notes</h3>
                                        <p>{{ $order->notes ? $order->notes : 'No customer notes' }}</p>
                                    </div>
                                </div>

                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('customJs')
    <style type="text/css">
        body {
            background: #eee;
        }

        .card {
            box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 0 solid rgba(0, 0, 0, .125);
            border-radius: 1rem;
        }

        .text-reset {
            --bs-text-opacity: 1;
            color: inherit !important;
        }

        a {
            color: #5465ff;
            text-decoration: none;
        }
    </style>


    <script>
        $('#orderStatusUpdate').on('click', function(e) {
            e.preventDefault();
            const status = $('#updateStatusVal').val();
            const adminNotes = $('#admin_notes').val();
            $('#orderStatusUpdate').prop('disabled', true);
            $.ajax({
                url: "{{ route('orders.updateStatus', $order->id) }}",
                type: 'put',
                data: {
                    status: status,
                    admin_notes: adminNotes
                },
                success: function(response) {
                    $('#orderStatusUpdate').prop('disabled', false);

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
        });

        function createPayment(order_id, user_id) {

            console.log(order_id, user_id);

            Swal.fire({
                input: 'number',
                title: `Create custom payment`,
                inputLabel: 'Pay amount',
                inputPlaceholder: 'Enter payment amount',
                showCancelButton: true,
                confirmButtonText: 'Confirm',
                inputValidator: (value) => {
                    if (!value || value <= 0) {
                        return 'Please enter a valid amount.';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const amount = result.value;

                    $.ajax({
                        url: "{{ route('orders.createPayment') }}",
                        type: 'post',
                        data: {
                            order_id: order_id,
                            user_id: user_id,
                            amount: amount
                        },
                        success: function(response) {
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
                }
            });
        }
    </script>

    <script>
        $('#orderApproveBtn').on('click', function(e) {
            e.preventDefault();

            const formData = $('#orderApproveForm').serializeArray();
            console.log(formData);
            $('#orderApproveBtn').prop('disabled', true);
            $.ajax({
                url: "{{ route('orders.approvee', $order->id) }}",
                type: 'put',
                data: formData,
                success: function(response) {
                    $('#orderApproveBtn').prop('disabled', false);
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


        function updateProduct(type, item_id, product_id, item_name) {

            Swal.fire({
                input: 'number',
                text: `Update price for ${item_name}`,
                inputLabel: 'Price',
                inputPlaceholder: 'Enter the price',
                showCancelButton: true,
                inputValidator: (value) => {
                    if (!value || value <= 0) {
                        return 'Please enter a valid price.';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const price = result.value;

                    $.ajax({
                        url: "{{ route('orders.itemUpdate') }}",
                        type: 'put',
                        data: {
                            type: type,
                            id: item_id,
                            product_id: product_id,
                            price: price
                        },
                        success: function(response) {
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
                }
            });



        }

        function deleteItem(order_id, id) {
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Are you sure to remove this item?',
                confirmButtonText: 'Confirm',
                showCancelButton: true
            }).then((result) => {
                if (result.isConfirmed) {
                    const price = result.value;

                    $.ajax({
                        url: "{{ route('orders.deleteItem') }}",
                        type: 'delete',
                        data: {
                            order_id: order_id,
                            id: id
                        },
                        success: function(response) {
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
                }
            });
        }
    </script>

    <script>
        $('#customAmountDiv').hide();
        $('#SelectAmount').on('change', function() {

            if ($(this).val() == 'custom') {
                $('#customAmountDiv').show();
            } else {
                $('#customAmountDiv').hide();
            }
        })
    </script>

    <script>
        function cancelOrder(id) {
            Swal.fire({
                icon: 'warning',
                title: 'Warning!',
                text: 'Are you sure to cancel this order? You cannot update this order later',
                showCancelButton: true,
                confirmButtonText: 'Confirm',
            }).then((result) => {
                if (result.isConfirmed) {
                    var route = "{{ route('orders.updateStatus', 'ID') }}";
                    const url = route.replace('ID', id);
                    $.ajax({
                        url: url,
                        type: 'put',
                        data: {
                            status: 'cancelled',
                            admin_notes: "Order cancelled by admin"
                        },
                        success: function(response) {
                            if (response.status == true) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'success',
                                    text: response.message,
                                    showCancelButton: false,
                                    confirmButtonText: 'Confirm'
                                });
                                window.location.reload();

                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'An error occurred',
                                    text: 'Something went wrong',
                                    showCancelButton: false,
                                    confirmButtonText: 'Reload page',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                });
                            }

                        }
                    })
                }
            });
        };
    </script>
@endsection
