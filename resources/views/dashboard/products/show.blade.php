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
                            <h4>Product Lists</h4>
                            @if (Session::has('error'))
                                <h5 class="text-danger font-md">{{ Session::get('error') }}</h5>
                            @endif
                            <form class="input-group" style="width: 30%">
                                <input type="text" name="search" class="form-control"
                                    value="{{ request('search') ?? request('search') }}" placeholder="Search product">
                                <button type="submit" class="input-group-text"><i class="fa-solid fa-search"></i></button>
                            </form>
                            <a href="{{ route('products.create') }}" class="btn btn-primary">New Product</a>
                        </div>
                        <div class="table-responsive">
                            @if ($products->isNotEmpty())
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ID</th>
                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($products as $product)
                                            <tr>
                                                <td>{{ $product->id }}</td>
                                                <td>
                                                    @if ($product->productImage->isNotEmpty())
                                                        @php
                                                            $productImage = $product->productImage->last();
                                                        @endphp

                                                        <img src="{{ '/uploads/products/' . $productImage->name }}"
                                                            alt=""
                                                            style="width: 50px; max-height: 50px; border-radius: 5px; margin-right:4px;">
                                                    @else
                                                    @endif

                                                    {{ Str::substr($product->title, 0, 35) . '...' }}
                                                </td>
                                                <td>{{ $product->category ? $product->category->name : 'category was deleted' }}
                                                </td>
                                                <td>{{ number_format($product->price, 2) }}</td>
                                                <td>{{ $product->track_quantity == 'Yes' ? $product->quantity : '' }}</td>
                                                <td>
                                                    <div
                                                        class="badge badge-{{ $product->status == 'pending' ? 'danger' : 'success' }} badge-shadow text-capitalize">
                                                        {{ $product->status }}</div>
                                                </td>
                                                <td>
                                                    <a href="{{ route('products.makeSpecial', $product->id) }}"
                                                        class="btn btn-warning"><i class="fas fa-bullseye"
                                                            style="font-size: 12px !important"></i></a>
                                                    <a href="{{ route('products.edit', $product->id) }}"
                                                        class="ml-1 btn btn-dark"><i class="fa-solid fa-edit"
                                                            style="font-size: 12px !important"></i></a>
                                                    <a href="javascript:void(0);"
                                                        onclick="deleteProduct({{ $product->id }})"
                                                        class="ml-1 btn btn-danger"><i class="fa-solid fa-trash"
                                                            style="font-size: 12px !important"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                            @else
                                <h4 class=" text-center">No products found</h4>
                            @endif
                        </div>
                        <div class="mt-3 mx-auto">
                            {{ $products->links('pagination::bootstrap-5') }}
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
        function deleteProduct(id) {
            Swal.fire({
                icon: 'warning',
                title: 'warning!',
                text: 'Are you sure to delete this Product? All releted orders,invoices,payment will be cleared',
                showCancelButton: true,
                confirmButtonText: 'Confirm Delete',
                preConfirm: () => {

                    var route = "{{ route('products.destroy', 'ID') }}";
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
                                    text: 'Product successfully deleted',
                                    showCancelButton: false,
                                    confirmButtonText: 'Confirm',
                                    preConfirm: () => {
                                        window.location.href =
                                            "{{ route('products.index') }}";
                                    }
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'An error occurd',
                                    text: 'Product already deleted or something else',
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
