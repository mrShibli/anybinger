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
                    <h4>Product Requests</h4>
                    @if (Session::has('error'))
                        <h5 class="text-danger font-md">{{ Session::get('error') }}</h5>
                    @endif
                    {{-- <a href="{{ route('products.create') }}" class="btn btn-primary">New Product</a> --}}
                </div>
                <div class="table-responsive">
                    @if ($requests->isNotEmpty())
                    <table class="table table-striped" id="table-1">
                    <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th>Product url</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            {{-- <th>Fee</th> --}}
                            <th>Requested by</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach ($requests as $request)
                            <tr>
                                <td>{{ $request->id }}</td>
                                {{-- <td>
                                    @if ($product->productImage->isNotEmpty())
                                        @php
                                            $productImage = $product->productImage->first();
                                        @endphp

                                        <img src="{{ '/uploads/products/'.$productImage->name }}" alt="" style="width: 50px; max-height: 50px; border-radius: 5px; margin-right:4px;">
                                    @else

                                    @endif
                                    
                                    {{ $product->title }}
                                </td> --}}
                                <td>
                                    @if ($request->image != null)
                                        <img src="{{ asset('uploads/requests/'.$request->image) }}" alt="" style="width: 40px; height:40px">
                                    @endif
                                    {{ $request->name ? $request->name : Str::substr($request->url, 0, 20) }}</td>
                                <td>{{ $request->qty }}</td>
                                <td>{{ $request->original_price != null ? number_format($request->original_price, 2) : 'Pending...' }}</td>
                                
                                
                                <td>{{ $request->user->name }}</td>

                                <td>
                                    <div class="badge badge-{{ $request->status == 'pending' ? 'danger' : 'success' }} badge-shadow text-capitalize">{{ $request->status }}</div>
                                </td>
                                <td>
                                    <a href="{{ route('products.requestsView', $request->id) }}" class="btn btn-success">View</a>
                                    <a href="javascript:void(0);" onclick="deleteProduct({{ $request->id }})" class="ml-1 btn btn-dark">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                        
                        
                    </tbody>
                    </table>
                    @else
                        <h4 class=" text-center">No products request found</h4>
                    @endif
                </div>
                <div class="mt-3 mx-auto">
                    {{ $requests->links('pagination::bootstrap-5') }}
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
    function deleteProduct(id){

        Swal.fire({
            icon: 'warning',
            title: 'Write a reason to delete',
            input: 'text',
            inputPlaceholder: 'example - invalid product url',
            showCancelButton: true,
            confirmButtonText: 'Submit',
            cancelButtonText: 'Cancel',
            preConfirm: (value) => {
                // Handle the submitted value
                if (value) {
                    var route = "{{ route('products.deleteRequest', 'ID') }}";
                    const url = route.replace('ID', id);
                    $.ajax({
                        url: url,
                        type: 'delete',
                        data: {reason: value},
                        success: function(response){
                            if(response.status == true){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'success',
                                    text: 'Product successfully deleted',
                                    showCancelButton: false,
                                    confirmButtonText: 'Confirm',
                                    preConfirm: () => {
                                        window.location.href = "{{ route('products.requests') }}";
                                    }});
                            }else{
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
                } else {
                    Swal.fire('Please enter a reason', '', 'error' ,'error');
                }
            }
        });

    }

    </script>
@endsection