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
                    <h4>Categories</h4>
                    @if (Session::has('error'))
                        <h5 class="text-danger font-md">{{ Session::get('error') }}</h5>
                    @endif
                    <a href="{{ route('categories.create') }}" class="btn btn-primary">New Category</a>
                </div>
                <div class="table-responsive">
                    @if ($categories->isNotEmpty())
                    <table class="table table-striped" id="table-1">
                    <thead>
                        <tr>
                        <th class="text-center">
                            ID
                        </th>
                        <th>Name</th>
                        <th>Show Home</th>
                        <th>Products</th>
                        <th>Status</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->show_home }}</td>
                                <td>{{ count($category->product) }}</td>
                                <td>
                                    <div class="badge badge-{{ $category->status == 'pending' ? 'danger' : 'success' }} badge-shadow text-capitalize">{{ $category->status }}</div>
                                </td>
                                <td>
                                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-dark">Edit</a>
                                    <a href="javascript:void(0);" onclick="deleteCategory({{ $category->id }})" class="ml-1 btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                        
                        
                    </tbody>
                    </table>
                    @else
                        <h4 class=" text-center">No categories found</h4>
                    @endif
                </div>
                <div class="mt-3 mx-auto">
                    {{ $categories->links('pagination::bootstrap-5') }}
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
            text: 'Are you sure to delete this Category? All releted products and info will be deleted',
            showCancelButton: true,
            confirmButtonText: 'Confirm Delete',
            preConfirm: () => {   
            
                var route = "{{ route('categories.destroy', 'ID') }}";
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
                                    window.location.href = "{{ route('categories.index') }}";
                                }});
                        }else{
                            Swal.fire({
                                icon: 'danger',
                                title: 'danger',
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