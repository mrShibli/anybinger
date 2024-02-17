@extends('dashboard.layouts.app')

@section('contents')
    @include('dashboard.layouts.sidebar')
    <!-- Main Content -->
    <div class="main-content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h4>Pending payment orders</h4>
                            @if (Session::has('error'))
                                <h5 class="text-danger font-md">{{ Session::get('error') }}</h5>
                            @endif
                            <form class="input-group" style="width: 30%">
                                <input type="text" name="search" class="form-control"
                                    value="{{ request('search') ?? request('search') }}" placeholder="Search users">
                                <button type="submit" class="input-group-text"><i class="fa-solid fa-search"></i></button>
                            </form>
                        </div>
                        <div class="table-responsive">
                            @if ($orders->isNotEmpty())
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

                                        @foreach ($orders as $order)
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

                                                    @if ($order->status == 'pending' || $order->status == 'cancelled')
                                                        <a href="javascript:void(0);"
                                                            onclick="deleteOrder({{ $order->id }})"
                                                            class="ml-1 btn btn-danger">Delete</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            @else
                                <h4 class=" text-center">No New Orders found</h4>
                            @endif
                        </div>
                        <div class="mt-3 mx-auto">
                            {{ $orders->links('pagination::bootstrap-5') }}
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    </div>
@endsection


@section('customJs')
    <script>
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
@endsection
