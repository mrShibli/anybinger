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
                    <h4>Sliders</h4><b>1365 × 519 px Image Size</b>
                    @if (Session::has('error'))
                        <h5 class="text-danger font-md">{{ Session::get('error') }}</h5>
                    @endif
                    <a href="{{ route('sliders.create') }}" class="btn btn-primary">New Slides</a>
                </div>
                <div class="table-responsive">
                    @if ($sliders->isNotEmpty())
                    <table class="table table-striped" id="table-1">
                    <thead>
                        <tr>
                        <th class="text-center">
                            ID
                        </th>
                        <th>Link</th>
                        <th>Text</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    @foreach ($sliders as $slides)
                        <tr>
                            <td>{{ $slides->id }}</td>
                            <td>{{ Str::length($slides->link) > 40 ? Str::substr($slides->link, 0, 40) . '...' : $slides->link }}</td>
                            <td>{{ $slides->text }}</td>
                            <td>
                                @if ($slides->image)
                                    <img src="{{ asset('/uploads/sliders') . '/' .$slides->image }}" alt="" style="width: 100%; max-height:50px">
                                @endif
                            </td>
                            <td>
                                <div class="badge badge-{{ $slides->status == 'pending' ? 'danger' : 'success' }} badge-shadow text-capitalize">{{ $slides->status }}</div>
                            </td>
                            <td>
                                <a href="{{ route('sliders.edit', $slides->id) }}" class="btn btn-dark">Edit</a>
                                <a href="javascript:void(0);" onclick="deleteSlides({{ $slides->id }})" class="ml-1 btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                        
                    </tbody>
                    </table>
                    @else
                        <h4 class=" text-center">No Sliders found</h4>
                    @endif
                </div>
                <div class="mt-3 mx-auto">
                    {{ $sliders->links('pagination::bootstrap-5') }}
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
    function deleteSlides(id){
     Swal.fire({
            icon: 'warning',
            title: 'warning!',
            text: 'Are you sure to delete this Slides?',
            showCancelButton: true,
            confirmButtonText: 'Confirm Delete',
            preConfirm: () => {   
            
                var route = "{{ route('sliders.destroy', 'ID') }}";
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
                                text: response.message ,
                                showCancelButton: false,
                                confirmButtonText: 'Confirm',
                                preConfirm: () => {
                                    window.location.href = "{{ route('sliders.index') }}";
                                }});
                        }else{
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