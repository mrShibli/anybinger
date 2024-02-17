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
                            <h4>Brands</h4>
                            @if (Session::has('error'))
                                <h5 class="text-danger font-md">{{ Session::get('error') }}</h5>
                            @endif
                            <a href="{{ route('brands.create') }}" class="btn btn-primary">New Brand</a>
                        </div>
                        <div class="table-responsive">
                            @if ($brands->isNotEmpty())
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                ID
                                            </th>
                                            <th>Name</th>
                                            <th>Slug</th>
                                            <th>Products</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($brands as $brand)
                                            <tr>
                                                <td>{{ $brand->id }}</td>
                                                <td>{{ $brand->name }}</td>
                                                <td>{{ $brand->slug }}</td>
                                                <td>{{ count($brand->product) }}</td>
                                                <td>
                                                    <div
                                                        class="badge badge-{{ $brand->status == 'pending' ? 'danger' : 'success' }} badge-shadow text-capitalize">
                                                        {{ $brand->status }}</div>
                                                </td>
                                                <td>
                                                    <a href="{{ route('brands.edit', $brand->id) }}"
                                                        class="btn btn-dark">Edit</a>
                                                    <a href="javascript:void(0);"
                                                        onclick="deleteBrands({{ $brand->id }})"
                                                        class="ml-1 btn btn-danger">Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                            @else
                                <h4 class=" text-center">No brands found</h4>
                            @endif
                        </div>
                        <div class="mt-3 mx-auto">
                            {{ $brands->links('pagination::bootstrap-5') }}
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
        function deleteBrands(id) {
            Swal.fire({
                icon: 'warning',
                title: 'warning!',
                text: 'Are you sure to delete this brands? All releted products and info will be deleted',
                showCancelButton: true,
                confirmButtonText: 'Confirm Delete',
                preConfirm: () => {

                    var route = "{{ route('brands.destroy', 'ID') }}";
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
                                    text: 'brands successfully deleted',
                                    showCancelButton: false,
                                    confirmButtonText: 'Confirm',
                                    preConfirm: () => {
                                        window.location.href =
                                            "{{ route('brands.index') }}";
                                    }
                                });
                            } else {
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
