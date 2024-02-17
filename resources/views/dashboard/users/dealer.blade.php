@extends('dashboard.layouts.app')

@section('contents')

    @include('dashboard.layouts.sidebar')
    <!-- Main Content -->
    <div class="main-content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form id="dealerPrices">
                            @csrf
                            <input type="text" name="descount_dealer" value="{{ $dealer_de->descount_dealer }}" class="mb-1">
                            <button type="submit" class="btn btn-primary" id="SaveBtn">Save</button>
                        </form>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h4>Manage dealers</h4>
                            @if (Session::has('error'))
                                <h5 class="text-danger font-md">{{ Session::get('error') }}</h5>
                            @endif

                        </div>
                        <div class="table-responsive">
                            @if ($users->isNotEmpty())
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                ID
                                            </th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Shop name</th>
                                            <th class="text-center"> Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($users as $user)
                                            <tr class="{{ $user->user->status == 'normal' ? '' : 'table-danger' }}">
                                                <td>{{ $user->user->id }}</td>
                                                <td>{{ $user->user->name }}</td>
                                                <td>{{ $user->user->email }}</td>
                                                <td>{{ $user->user->phone ? $user->user->phone : 'Not added' }}</td>
                                                <td>{{ $user->shop_name }}</td>

                                                <td>
                                                    @if ($user->user->status == 'normal')
                                                        <a href="{{ route('users.dealerView', $user->id) }}"
                                                            class="btn btn-info">Update Dealer</a>

                                                        <a href="javascript:void(0);"
                                                            onclick="blockUser({{ $user->user->id }})"
                                                            class="ml-1 btn btn-{{ $user->user->status == 'normal' ? 'danger' : 'success' }}">{{ $user->user->status == 'normal' ? 'Block' : 'Unblock' }}</a>
                                                    @else
                                                        <a href="javascript:void(0);"
                                                            onclick="blockUser({{ $user->id }})"
                                                            class="ml-1 btn btn-{{ $user->status == 'normal' ? 'danger' : 'success' }}">{{ $user->status == 'normal' ? 'Block' : 'Unblock' }}</a>
                                                    @endif

                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            @else
                                <h4 class=" text-center">No Users found</h4>
                            @endif
                        </div>
                        <div class="mt-3 mx-auto">
                            {{ $users->links('pagination::bootstrap-5') }}
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
    $(document).ready(function() {
        $('#dealerPrices').on('submit', function(e) {
            e.preventDefault();
            var formdata = $(this).serialize();

            $.ajax({
                url: "{{ route('dealer.descount')}}",
                type: 'post',
                data: formdata,
                dataType: 'json', // Assuming your response is JSON
                success: function(response) {
                    $('#SaveBtn').prop('disabled', false);

                    if (response.status == false) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Warning',
                            text: response.errors,
                            showCancelButton: false,
                            confirmButtonText: 'Confirm',
                        });

                    } else if (response.status == true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            showCancelButton: false,
                            confirmButtonText: 'Confirm',
                        });
                    }
                },
                error: function(error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'An error occurred',
                        text: 'Something went wrong, try later',
                        showCancelButton: true,
                        confirmButtonText: 'Try again',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                }
            });
        });
    });
</script>
@endsection

