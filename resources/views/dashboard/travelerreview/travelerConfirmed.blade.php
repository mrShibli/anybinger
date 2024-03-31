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
                            <h4>Traveler Product Lists</h4>
                            @if (Session::has('error'))
                                <h5 class="text-danger font-md">{{ Session::get('error') }}</h5>
                            @endif
                        </div>
                        <div class="table-responsive">
                            @if ($product->isNotEmpty())
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ID</th>
                                            <th>Traveler</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($product as $product)
                                         @if ($product->productRequest)
                                            <tr>
                                                <td>{{ $product->id }}</td>
                                                <td>{{ $product->traveler->full_name }}</td>
                                                <td>
                                                    <img src="{{ '/uploads/requests/' . $product->productRequest->image }}"
                                                        alt=""
                                                        style="width: 50px; max-height: 50px; border-radius: 5px; margin-right:4px;">
                                                    {{ $product->title }}
                                                </td>
                                                <td>{{ $product->productRequest->name }}</td>
                                                <td>
                                                    {{ $product->productRequest->original_price }}
                                                </td>
                                                <td>
                                                    {{ $product->productRequest->qty }}
                                                </td>
                                                <td>
                                                    {{ $product->status }}
                                                </td>
                                            </tr>
                                                                    @endif

                                        @endforeach


                                    </tbody>
                                </table>
                            @else
                                <h4 class=" text-center">No products found</h4>
                            @endif
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    </div>

@endsection


@section('customJs')

@endsection
