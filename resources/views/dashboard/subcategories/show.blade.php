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
                    <h4>Sub Categories</h4>
                    @if (Session::has('error'))
                        <h5 class="text-danger font-md">{{ Session::get('error') }}</h5>
                    @endif
                    <a href="{{ route('subcategories.create') }}" class="btn btn-primary">New SubCategory</a>
                </div>
                <div class="table-responsive">
                    @if ($subcategories->isNotEmpty())
                    <table class="table table-striped" id="table-1">
                    <thead>
                        <tr>
                        <th class="text-center">
                            ID
                        </th>
                        <th>Main catgory</th>
                        <th>SubCategory</th>
                        {{-- <th>Status</th> --}}
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach ($subcategories as $category)
                            <tr>
                                <td class="text-center">{{ $category->id }}</td>
                                <td>{{ $category->category->name }}</td>
                                <td>{{ $category->name }}</td>
                                {{-- <td>
                                    <div class="badge badge-{{ $category->status == 'pending' ? 'danger' : 'success' }} badge-shadow text-capitalize">{{ $category->status }}</div>
                                </td> --}}
                                <td>
                                    <a href="{{ route('subcategories.edit', $category->id) }}" class="btn btn-dark">Edit</a>
                                    <a href="javascript:void(0);" onclick="deleteCategory({{ $category->id }})" class="ml-1 btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                        
                        
                    </tbody>
                    </table>
                    @else
                        <h4 class=" text-center">No subcategories found</h4>
                    @endif
                </div>
                <div class="mt-3 mx-auto">
                    {{ $subcategories->links('pagination::bootstrap-5') }}
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
        
    function deleteCategory(id){

        Swal.fire({
            icon: 'warning',
            title: 'warning!',
            text: 'Are you sure to delete this subcategory?',
            showCancelButton: true,
            confirmButtonText: 'Confirm Delete',
            preConfirm: () => {
                var route = "{{ route('subcategories.destroy', 'ID') }}";
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
                                text: 'Category successfully deleted',
                                showCancelButton: false,
                                confirmButtonText: 'Confirm',
                                preConfirm: () => {
                                    window.location.href = "{{ route('subcategories.index') }}";
                                }});
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops an error occurd!',
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