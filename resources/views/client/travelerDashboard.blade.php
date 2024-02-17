@extends('client.layouts.app')
@section('headers')
    <title>Traveler dashboard</title>
@endsection
@section('contents')
    <!-- main starts here -->
    <main class="max-w-[1200px] mx-auto px-3 mt-3 sm:px-6 md:px-8">
        <div class="bg-white inline-block">
            <div class="flex flex-row items-center justify-between">
                <a href="{{ route('index') }}" class="link">Home</a>
                <i class="fa-solid fa-chevron-right text-[12px] mx-1 text-gray-700"></i>
                <a href="" class="link">Traveler Dashboard</a>
            </div>
        </div>
        <div class="mt-3 max-w-[1000px] mx-auto">
            <div class="flex justify-between">
                <h2 class="text-[20px] font-medium">
                    Traveler Dashboard
                </h2>
            </div>
            @if (!empty($data))
                <div class="grid items-start mt-2">
                    <div class="grid  md:col-span-7 overflow-x-auto sm:overflow-x-hidden">
                        <table class="text-center bg-white table-auto border-collapse border border-slate-300">
                            <thead class="text-center">
                                <tr>
                                    <th class="border-y border-slate-300 text-sm p-3">
                                        <span class="text-[14px] font-medium">Site Name</span>
                                    </th>
                                    <th class="border-y border-slate-300 text-sm p-3">
                                        <span class="text-[14px] font-medium">Image</span>
                                    </th>
                                    <th class="border-y border-slate-300 text-sm p-3">
                                        <span class="text-[14px] font-medium">Product</span>
                                    </th>
                                    <th class="border-y border-slate-300 text-sm p-3">
                                        <span class="text-[14px] font-medium">Action</span>
                                    </th>
                                    <th class="border-y border-slate-300 text-sm p-3">
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="cartProducts">
                                @foreach ($data as $product)
                                    @php
                                        $parsedUrl = $product->productRequest->url;
                                        $parsedUrl = parse_url($product->productRequest->url);
                                        $domain = isset($parsedUrl['host']) ? $parsedUrl['host'] : 'Not';

                                    @endphp
                                    <tr>
                                        <td class="p-3">
                                            <b>{{ $domain }}</b>
                                        </td>
                                        <td >

                                            <img src="{{ asset('uploads/requests/' . $product->productRequest->image) }}" alt=""
                                                class="w-[100px] rounded max-h-[100px] mx-auto " />
                                        </td>
                                        <td class="p-3">
                                            <a target="_blank" href="{{ $product->productRequest->url }}" class="text-[14px] link !leading-3">
                                                Product Link
                                            </a>
                                        </td>
                                        <td class="p-3">
                                            @if ($product->status == 'confirmed')
                                                <p>Can't Delete.</p>
                                            @else
                                            <button onclick="deleteTravelerProduct({{ $product->id }})"
                                                class="hover:text-gray-600 px-2 md:px-3 py-[2px]">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                            @endif
                                        </td>
                                        <td class="p-3">
                                            @if ($product->status == 'confirmed')
                                                <p style="color: red">Confirmed</p>
                                            @else

                                            <button onclick="statusProductTraveler({{ $product->id }})"
                                                class="hover:text-gray-600 px-2 md:px-3 py-[2px]">
                                                Confirme
                                            </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>

            @else
                <div class="bg-white mx-auto p-5 flex flex-col justify-center">
                <h2 class="text-[20px] text-center font-medium mt-2">No Product found</h2>
                <a href="{{ route('traveler.products') }}" class=" mx-auto mt-6"><button class="btn-outline  px-2">Accept traveler product</button></a>
            </div>
            @endif



        </div>
    </main>
@endsection
@section('customJs')
    <script>
        function statusProductTraveler(id) {
            $.ajax({
                url: '{{ route('traveler.product.status') }}',
                type: 'POST',
                data: {id:id},
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: "Success",
                            text: 'Product has been removed',
                            icon: 'success',
                            confirmButtonText: 'OK!',
                            preConfirm: () => {
                                window.location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Failed',
                            text: response.faild,
                            icon: 'error',
                            confirmButtonText: 'Confirm',
                            preConfirm: () => {
                                window.location.reload();
                            }
                        });
                    }
                },
                error: function() {

                        Swal.fire({
                            title: 'Failed',
                            text: 'Something went wrong',
                            icon: 'error',
                            confirmButtonText: 'Confirm'
                        });

                }
            });
        }

        function deleteTravelerProduct(productId) {
            if (confirm("Are you sure you want to delete this traveler product?")) {
            $.ajax({
                type: 'POST',
                url: '{{ route('traveler.product.delete') }}',
                data: {
                    id: productId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Handle success response
                    if (response.success) {
                        alert(response.message); // Show success message
                        // Optionally, you can remove the deleted product from the DOM
                        // $(this).closest('tr').remove(); // Remove the row from the table
                        location.reload(); // Reload the page to reflect changes
                    } else {
                        alert('Failed to delete traveler product.'); // Show error message
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(xhr.responseText); // Log error message
                    alert('An error occurred while processing your request.'); // Show generic error message
                }
            });
        }
        }
    </script>
@endsection
