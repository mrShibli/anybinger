@extends('dashboard.layouts.app')

@section('contents')

    @include('dashboard.layouts.sidebar')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <!-- info bar -->

            @if (Session::has('success'))
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-success">{{ Session::get('success') }}</h5>
                    </div>
                </div>
            @endif
            @if (Session::has('error'))
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-danger">{{ Session::get('error') }}</h5>
                    </div>
                </div>
            @endif


            <div class="row ">
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="card">
                        <div class="card-statistic-4">
                            <div class="align-items-center justify-content-between">
                                <div class="row ">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pr-0 pt-3">
                                        <div class="card-content">
                                            <h5 class="font-15">Orders last mounth</h5>
                                            <h2 class="mb-3 font-18">{{ $ordersLastMonth->count() }}</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="card">
                        <div class="card-statistic-4">
                            <div class="align-items-center justify-content-between">
                                <div class="row ">
                                    <div class="col-lg-12 col-md-6 col-sm-12 col-xs-12 pr-0 pt-3">
                                        <div class="card-content">
                                            <h5 class="font-15">Customers</h5>
                                            <h2 class="mb-3 font-18">{{ number_format($users) }}</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="card">
                        <div class="card-statistic-4">
                            <div class="align-items-center justify-content-between">
                                <div class="row ">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                        <div class="card-content">
                                            <h5 class="font-15">Travelers</h5>
                                            <h2 class="mb-3 font-18">{{ number_format($travelers) }}</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="card">
                        <div class="card-statistic-4">
                            <div class="align-items-center justify-content-between">
                                <div class="row ">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pr-0 pt-3">
                                        <div class="card-content">
                                            <h5 class="font-15">Sells last month</h5>
                                            <h2 class="mb-3 font-18">{{ number_format($totalRevenueLastMonth) }}&#2547;</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Recent Product Request -->
            <div class="row">
                <div class="col-12 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Recent Product Requests</h4>
                        </div>
                        <div class="card-body px-4">
                            <div class="table-responsive">
                                @if ($productRequests->isNotEmpty())
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">ID</th>
                                                <th>Product url</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                {{-- <th>Fee</th> --}}
                                                <th>Requested by</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($productRequests as $request)
                                                <tr>
                                                    <td>{{ $request->id }}</td>
                                                    <td>
                                                        @if ($request->image != null)
                                                            <img src="{{ asset('uploads/requests/' . $request->image) }}"
                                                                alt="" style="width: 40px; height:40px">
                                                        @endif
                                                        {{ $request->name ? $request->name : Str::substr($request->url, 0, 20) }}
                                                    </td>
                                                    <td>{{ $request->qty }}</td>
                                                    <td>{{ $request->original_price != null ? number_format($request->original_price, 2) : 'Pending...' }}
                                                    </td>


                                                    <td>{{ $request->user->name }}</td>

                                                    <td>
                                                        <div
                                                            class="badge badge-{{ $request->status == 'pending' ? 'danger' : 'success' }} badge-shadow text-capitalize">
                                                            {{ $request->status }}</div>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('products.requestsView', $request->id) }}"
                                                            class="btn btn-success">View</a>
                                                        <a href="javascript:void(0);"
                                                            onclick="deleteProduct({{ $request->id }})"
                                                            class="ml-1 btn btn-dark">Delete</a>
                                                    </td>
                                                </tr>
                                            @endforeach


                                        </tbody>
                                    </table>
                                @else
                                    <h4 class=" text-center">No products request found</h4>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Recent Order -->
            <div class="row">
                <div class="col-12 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Recent Orders</h4>
                        </div>
                        <div class="card-body px-4">
                            @if ($ordersLastMonth->isNotEmpty())
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    ID
                                                </th>
                                                <th>Username</th>
                                                <th>Phone</th>
                                                <th>Total amount</th>

                                                <th>Paid</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($ordersLastMonth as $order)
                                                <tr>
                                                    <td>{{ $order->id }}</td>
                                                    <td>{{ $order->user->name }}</td>
                                                    <td>{{ $order->user->phone }}</td>
                                                    <td>{{ $order->total }}</td>
                                                    <td>{{ $order->paid ? $order->paid : 0 }}</td>
                                                    <td>
                                                        <div
                                                            class="badge badge-{{ $order->status == 'pending'
                                                                ? 'warning'
                                                                : ($order->status == 'cancelled'
                                                                    ? 'danger'
                                                                    : ($order->status == 'pending_payment'
                                                                        ? 'warning'
                                                                        : 'info')) }} badge-shadow text-capitalize">
                                                            {{ $order->status }}
                                                        </div>

                                                    </td>
                                                    <td>

                                                        <a href="{{ route('orders.update', $order->id) }}"
                                                            class="btn btn-success"><i class="fa-solid fa-edit"></i>
                                                        </a>

                                                        @if ($order->status == 'pending')
                                                            <a href="javascript:void(0);"
                                                                onclick="deleteOrder({{ $order->id }})"
                                                                class="ml-1 btn btn-danger">Delete</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <h4 class=" text-center">No Recent Orders found</h4>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Travler Request -->
            <div class="row">
                <div class="col-12 col-md-6 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Recent Travler Requests</h4>
                        </div>
                        <div class="card-body px-4">
                            @if ($traveler->isNotEmpty())
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>BD Out Num</th>
                                                <th>BD Num</th>
                                                <th>Out Address</th>
                                                <th>BD Address</th>
                                                <th>Barth</th>
                                                <th>City</th>
                                                <th>State</th>
                                                <th>Zipe Code</th>
                                                <th>Passport</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($traveler as $traveler)
                                                <tr>
                                                    <td>{{ $traveler->full_name }}</td>
                                                    <td>{{ $traveler->out_cunt_num }}</td>
                                                    <td>{{ $traveler->bd_number }}</td>
                                                    <td>{{ $traveler->out_address }}</td>
                                                    <td>{{ $traveler->bd_address }}</td>
                                                    <td>{{ $traveler->barth }}</td>
                                                    <td>{{ $traveler->city }}</td>
                                                    <td>
                                                        {{ $traveler->state }}
                                                    </td>
                                                    <td>{{ $traveler->zip_code }}</td>
                                                    <td>
                                                        <img width="50px" onClick="openModal(this)"
                                                            src="{{ asset('storage/' . $traveler->passport) }}"
                                                            class="cursor-pointer" alt="" style="cursor: pointer"
                                                            srcset="">
                                                    </td>
                                                    <td>
                                                        <select id="roleApprobe" name="status"
                                                            onChange="updateRole({{ $traveler->id }})">
                                                            <option value="{{ $traveler->status }}">
                                                                {{ $traveler->status }}
                                                            </option>
                                                            <option value="approve">Approve</option>
                                                            <option value="cancelled">Cancelled</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <h4>No Traveler request found</h4>
                            @endif
                        </div>
                    </div>
                </div>
            </div>


        </section>

    </div>

@endsection


@section('customJs')
    <script>
        function deleteProduct(id) {

            Swal.fire({
                icon: 'warning',
                title: 'Write a reason to delete',
                input: 'text',
                inputPlaceholder: 'example - invalid product url',
                showCancelButton: true,
                confirmButtonText: 'Submit',
                cancelButtonText: 'Cancel',
                preConfirm: (value) => {
                    // Handle the submitted value
                    if (value) {
                        var route = "{{ route('products.deleteRequest', 'ID') }}";
                        const url = route.replace('ID', id);
                        $.ajax({
                            url: url,
                            type: 'delete',
                            data: {
                                reason: value
                            },
                            success: function(response) {
                                if (response.status == true) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'success',
                                        text: 'Product successfully deleted',
                                        showCancelButton: false,
                                        confirmButtonText: 'Confirm',
                                        preConfirm: () => {
                                            window.location.href =
                                                "{{ route('products.requests') }}";
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'An error occurd',
                                        text: 'Product already deleted or something else',
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
                    } else {
                        Swal.fire('Please enter a reason', '', 'error', 'error');
                    }
                }
            });

        }

        function deleteOrder(id) {
            Swal.fire({
                icon: 'warning',
                title: 'warning!',
                text: 'Are you sure to delete this Order, User will lost all order information?',
                showCancelButton: true,
                confirmButtonText: 'Confirm Delete',
                preConfirm: () => {

                    var route = "{{ route('orders.destroy', 'ID') }}";
                    const url = route.replace('ID', id);
                    $.ajax({
                        url: url,
                        type: 'delete',
                        data: $(this).serializeArray(),
                        success: function(response) {
                            if (response.status == true) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'success',
                                    text: response.message,
                                    showCancelButton: false,
                                    confirmButtonText: 'Confirm',
                                    preConfirm: () => {
                                        window.location.href =
                                            "{{ route('orders.index') }}";
                                    }
                                });
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
        }
    </script>

    <script>
        function openModal(imageSrc) {
            var modalImage = document.getElementById("modalImage");
            modalImage.src = imageSrc.src;

            // Show the Bootstrap modal
            $('#fullscreenModal').modal('show');
        }

        function closeModal() {
            // Hide the Bootstrap modal
            $('#fullscreenModal').modal('hide');
        }
    </script>
    <script>
        function updateRole(id) {
            const role = $('#roleApprobe').val()

            $.ajax({
                url: '{{ route('traveler.role.update') }}',
                type: 'POST',
                data: {
                    role: role,
                    id: id
                },
                success: function(response) {
                    console.log();
                    if (response.success) {
                        Swal.fire({
                            title: 'Submitted',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'Confirm',
                            preConfirm: () => {
                                window.location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Failed',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'Confirm',
                            preConfirm: () => {
                                window.location.reload();
                            }
                        });
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    Swal.fire({
                        title: 'Failed',
                        text: 'Something went wrong',
                        icon: 'error',
                        confirmButtonText: 'Confirm'
                    });
                }
            });

        }
        $(document).ready(function() {});
    </script>
@endsection
