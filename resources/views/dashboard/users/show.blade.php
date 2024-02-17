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
                            <h4>Manage users</h4>
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
                                            <th>User type</th>
                                            <th class="text-center"> Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($users as $user)
                                            <tr class="{{ $user->status == 'normal' ? '' : 'table-danger' }}">
                                                <td>{{ $user->id }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->phone ? $user->phone : 'Not added' }}</td>
                                                <td>
                                                    <span
                                                        class="badge badge-{{ $user->user_access == 'traveler' ? 'info' : ($user->user_access == 'dealer' ? 'warning' : 'success') }}">
                                                        {{ $user->user_access }}
                                                    </span>
                                                </td>


                                                <td>
                                                    @if ($user->status == 'normal')
                                                        @if ($user->user_access != 'dealer' && $user->user_access != 'traveler')
                                                            <a href="{{ route('users.dealerView', $user->id) }}"
                                                                class="btn btn-warning">Apply Dealer</a>
                                                        @elseif($user->user_access == 'dealer')
                                                            <a href="{{ route('users.dealerView', $user->id) }}"
                                                                class="btn btn-info">Update Dealer</a>
                                                        @else
                                                            {{-- {{ route('users.dealerView', $user->id) }} --}}
                                                            <a href="" class="btn btn-success">View traveler</a>
                                                        @endif


                                                        <a href="javascript:void(0);"
                                                            onclick="blockUser({{ $user->id }})"
                                                            class="ml-1 btn btn-{{ $user->status == 'normal' ? 'danger' : 'success' }}">{{ $user->status == 'normal' ? 'Block' : 'Unblock' }}</a>
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
        function blockUser(id) {
            Swal.fire({
                icon: 'warning',
                title: 'warning!',
                text: 'Are you sure to block this user?',
                showCancelButton: true,
                confirmButtonText: 'Block',
                preConfirm: () => {

                    var route = "{{ route('users.blockUser', 'ID') }}";
                    const url = route.replace('ID', id);
                    $.ajax({
                        url: url,
                        type: 'post',
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
                                            "{{ route('users.index') }}";
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
