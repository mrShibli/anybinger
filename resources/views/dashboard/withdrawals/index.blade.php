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
                            <h4>Withdrawals Requests</h4>
                            @if (Session::has('error'))
                                <h5 class="text-danger font-md">{{ Session::get('error') }}</h5>
                            @endif
                            {{-- <form class="input-group" style="width: 30%">
                                <input type="text" name="search" class="form-control"
                                    value="{{ request('search') ?? request('search') }}" placeholder="Search withdrawals">
                                <button type="submit" class="input-group-text"><i class="fa-solid fa-search"></i></button>
                            </form> --}}
                        </div>
                        <div class="table-responsive">
                            @if ($withdrawals->isNotEmpty())
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                ID
                                            </th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($withdrawals as $pay)
                                            <tr>
                                                <td class="text-center">{{ $pay->id }}</td>
                                                <td>{{ $pay->user->name }}</td>
                                                <td>{{ sprintf("%011d", $pay->phone) }}</td>
                                                <td>{{ $pay->amount }}</td>
                                                <td>
                                                    @if ($pay->status == 'awaiting')
                                                        <span class="badge badge-warning">Pending</span>
                                                    @elseif ($pay->status == 'completed')
                                                        <span class="badge badge-info">Completed</span>
                                                    @else
                                                        <span class="badge badge-danger">Cancelled</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if ($pay->status == 'awaiting')
                                                        <a href="javascript:void(0);"
                                                            onclick="updateWithdraw({{ $pay->id}}, 'completed')"
                                                            class="ml-1 btn btn-success">
                                                            Confirm
                                                        </a>
                                                        <a href="javascript:void(0);"
                                                            onclick="updateWithdraw({{ $pay->id }}, 'cancelled')"
                                                            class="ml-1 btn btn-danger">
                                                            Cancel
                                                        </a>
                                                    {{-- @else
                                                        <a href="javascript:void(0);"  class="ml-1 btn btn-danger">
                                                            Completed
                                                        </a> --}}
                                                    @endif

                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            @else
                                <h4 class=" text-center">No Withdrawals found</h4>
                            @endif
                        </div>
                        <div class="mt-3 mx-auto">
                            {{ $withdrawals->links('pagination::bootstrap-5') }}
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
        function updateWithdraw(id, type) {
            
            $.ajax({
                url: "{{ route('withdraw.update') }}",
                type: 'put',
                data: {id: id, type: type,},
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
            });
        }
    </script>
@endsection
