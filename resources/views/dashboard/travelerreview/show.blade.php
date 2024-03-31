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
                    <h4>Traveler Reviews</h4>
                    @if (Session::has('error'))
                        <h5 class="text-danger font-md">{{ Session::get('error') }}</h5>
                    @endif
                    <a href="{{ route('travelerreviews.create') }}" class="btn btn-primary">New review</a>
                </div>
                <div class="table-responsive">
                    @if ($travelerreviews->isNotEmpty())
                    <table class="table table-striped" id="table-1">
                    <thead>
                        <tr>
                        <th class="text-center">
                            ID
                        </th>
                        <th>Name</th>
                        <th>About</th>
                        <th>Review</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach ($travelerreviews as $review)
                            <tr>
                                <td>{{ $review->id }}</td>
                                <td>{{ $review->name }}</td>
                                <td>{{ $review->about }}</td>
                                <td>{{  Str::length($review->review) > 40 ? Str::substr($review->review, 0, 40) . '...' : $review->review  }}</td>
                                <td>
                                    <a href="{{ route('travelerreviews.edit', $review->id) }}" class="btn btn-dark">Edit</a>
                                    <a href="javascript:void(0);" onclick="deleteReview({{ $review->id }})" class="ml-1 btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                        
                        
                    </tbody>
                    </table>
                    @else
                        <h4 class=" text-center">No Traveler review found</h4>
                    @endif
                </div>
                <div class="mt-3 mx-auto">
                    {{ $travelerreviews->links('pagination::bootstrap-5') }}
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
        function deleteReview(id){
        Swal.fire({
                icon: 'warning',
                title: 'warning!',
                text: 'Are you sure to delete this review?',
                showCancelButton: true,
                confirmButtonText: 'Confirm Delete',
                preConfirm: () => {   
                
                    var route = "{{ route('travelerreviews.destroy', 'ID') }}";
                    const url = route.replace('ID', id);
                    $.ajax({
                        url: url,
                        type: 'delete',
                        data: $(this).serializeArray(),
                        success: function(response){
                            if(response.status == true){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'success',
                                    text: response.message,
                                    showCancelButton: false,
                                    confirmButtonText: 'Confirm',
                                    preConfirm: () => {
                                        window.location.href = "{{ route('travelerreviews.index') }}";
                                    }});
                            }else{
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

                        },
                        error: function(error){
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
                    })
                }
            });
        }
    </script>
@endsection