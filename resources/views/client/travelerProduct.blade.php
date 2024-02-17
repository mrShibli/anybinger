@extends('client.layouts.app')
@section('headers')
    <title>Traveler Products</title>
@endsection
@section('contents')
    <!-- main starts here -->
    <main class="max-w-[1200px] mx-auto px-3 mt-3 sm:px-6 md:px-8">
        <div class="bg-white inline-block">
            <div class="flex flex-row items-center justify-between">
                <a href="{{ route('index') }}" class="link">Home</a>
                <i class="fa-solid fa-chevron-right text-[12px] mx-1 text-gray-700"></i>
                <a href="" class="link">Traveler Product</a>
            </div>
        </div>
        <div class="mt-3 max-w-[1000px] mx-auto">
            <div class="flex justify-between">
                <h2 class="text-[20px] font-medium">
                    Traveler Product
                </h2>
                <a href="{{ route('traveler.dashboard') }}">Go to Dashboard</a>
            </div>
            @if ($travelerProduct->isNotEmpty())
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
                            </tr>
                        </thead>
                        <tbody id="cartProducts">
                            @foreach ($travelerProduct as $product)
                                @php
                                    $parsedUrl = $product->url;
                                    $parsedUrl = parse_url($product->url);
                                    $domain = isset($parsedUrl['host']) ? $parsedUrl['host'] : 'Not';

                                @endphp
                                <tr>
                                    <td class="p-3">
                                        <b>{{ $domain }}</b>
                                    </td>
                                    <td class="">
                                        <img src="{{ asset('uploads/requests/' . $product->image) }}" alt=""
                                            class="w-[100px] rounded max-h-[100px] mx-auto " />
                                    </td>
                                    <td class="p-3">
                                        <a target="_blank" href="{{ $product->url }}" class="text-[14px] link !leading-3">
                                            Product Link
                                        </a>
                                    </td>
                                    <td class="p-3">
                                        <button onclick="addProductTraveler({{ $product->id }})"
                                            class="hover:text-gray-600 px-2 md:px-3 py-[2px]">
                                            Add
                                            <i class="fa-solid fa-location-arrow" style="font-size: 25px"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
            @else
            <div class="bg-white mx-auto p-5 flex flex-col justify-center">
                <h2 class="text-[20px] text-center font-medium mt-2">No traveler product available</h2>
                <a href="{{ route('traveler.dashboard') }}" class=" mx-auto mt-6"><button class="btn-outline  px-2">My traveler dashboard</button></a>
            </div>
            @endif

        </div>
    </main>
@endsection
@section('customJs')
    <script>
        function addProductTraveler(id) {
            $.ajax({
                url: '{{ route('traveler.product') }}',
                type: 'POST',
                data: {id:id},
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: response.success,
                            text: '',
                            icon: 'success',
                            confirmButtonText: 'OK!',
                            preConfirm: () => {
                                window.location.reload();
                            }
                        });
                    } else if(response.status == false){
                        Swal.fire({
                            title: 'Warning',
                            text: response.faild,
                            icon: 'warning',
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
    </script>
@endsection
