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
                            <h4>Product reviews</h4>
                            @if (Session::has('error'))
                                <h5 class="text-danger font-md">{{ Session::get('error') }}</h5>
                            @endif
                            @if (Session::has('success'))
                                <h5 class="text-success font-md">{{ Session::get('success') }}</h5>
                            @endif
                            <a href="{{ route('reviews.pendings') }}" class="btn btn-primary">Pending reviews</a>
                        </div>
                        <div class="table-responsive">
                            @if ($reviews->isNotEmpty())
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                ID
                                            </th>
                                            <th>Username</th>
                                            <th>Product</th>
                                            <th>Rating</th>
                                            <th>Review</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($reviews as $review)
                                            <tr>
                                                <td>{{ $review->id }}</td>
                                                <td>{{ $review->user->name }}</td>
                                                <td>{{ $review->product->title }}</td>
                                                <td>{{ $review->rating }} stars</td>
                                                <td>{{ Str::length($review->review) > 40 ? Str::substr($review->review, 0, 40) . '...' : $review->review }}
                                                </td>
                                                <td>
                                                    @if ($review->status == 'pending')
                                                        <span class="badge badge-danger">Pending</span>
                                                    @else
                                                        <span class="badge badge-success">Approved</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('reviews.approve', $review->id) }}"
                                                        class="btn btn-dark">Approve</a>
                                                    <a href="{{ route('reviews.delete', $review->id) }}" 
                                                        onclick="deleteReview({{ $review->id }})"
                                                        class="ml-1 btn btn-danger">Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            @else
                                <h4 class=" text-center">No Reviews found</h4>
                            @endif
                        </div>
                        <div class="mt-3 mx-auto">
                            {{ $reviews->links('pagination::bootstrap-5') }}
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
        function deleteSlides(id) {
            Swal.fire({
                icon: 'warning',
                title: 'warning!',
                text: 'Are you sure to delete this Review?',
                showCancelButton: true,
                confirmButtonText: 'Confirm Delete',
                preConfirm: () => {

                    var route = "{{ route('reviews.delete', 'ID') }}";
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
                                            "{{ route('reviews.index') }}";
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
