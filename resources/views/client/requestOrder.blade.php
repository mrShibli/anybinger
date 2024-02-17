    @extends('client.layouts.app')

    @section('headers')
        <title>My order requests</title>
    @endsection

    @section('contents')
        <!-- main starts here -->
    <main class="max-w-[1400px] mx-auto px-3 mt-3 sm:px-6 md:px-8">
        <div class="bg-white inline-block">
            <div class="flex flex-row items-center justify-between">
                <a href="{{ route('index') }}" class="link">Home</a>
                <i class="fa-solid fa-chevron-right text-[12px] mx-1 text-gray-700"></i>
                <a href="{{ route('account.index') }}" class="link">Account</a>
                <i class="fa-solid fa-chevron-right text-[12px] mx-1 text-gray-700"></i>
                <a href="" class="link">My order requests</a>
            </div>
        </div>
        <div class="flex flex-col items-center justify-center gap-3 bg-white">
            <h2 class="text-[25px] my-2 mb-1 font-medium text-blue-dark bg-white inline-block">
                My Order Requests
            </h2>
            <div class="flex flex-col md:w-auto w-[100%] items-center justify-center gap-4">

            
                <!-- Content for Accepted Requests tab -->
                @if ($accepeted->isNotEmpty())
                    @foreach ($accepeted->chunk(2) as $chunk)
                        <div class="w-full flex flex-col md:flex-row items-center gap-4 justify-center">
                            @foreach ($chunk as $request)
                                <div id="RproductW"
                                    class="bg-white mt-3  md:w-full md:w-auto border mx-auto flex  justify-between items-center p-1 smH120">
                                    <div class="flex flex-row w-full items-center gap-3 overflow-hidden">
                                        @if ($request->image)
                                            <img src="{{ asset('uploads/products/' . $request->image) }}" alt
                                                class="w-[100px] rounded-md sm:w-[100px] h-[90px]" />
                                        @else
                                            <img src="{{ asset('client/images/650.png') }}" alt
                                                class="w-[100px] rounded-md sm:w-[100px] h-[90px]" />
                                        @endif

                                        <div class="flex flex-col gap-1">
                                            <a href=""
                                                class="text-[15px] text-blue-dark hover:bg-text-600 font-medium">{{Str::substr($request->product->title, 0, 30) . '...' }}</a>
                                            <span class="text-[15px] text-orange-dark">Quantity:
                                                <b>{{ $request->qty }}</b></span>
                                            @if ($request->price)
                                                <span class="text-[15px] text-orange-dark">Price:
                                                    &#2547;<b>{{ $request->price }}</b></span>
                                            @endif

                                            @if ($request->status == 'approved')
                                                <p class="text-green-600 text-[14px] font-medium"><i
                                                        class="fa-regular fa-circle-check"></i> Approved</p>                                             
                                            @endif

                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    @endforeach
                @else
                    <h2 class="text-2xl">No approved order requests</h2>
                    <a href="{{ route('products') }}" class="btn-outline">Request new order</a>
                @endif


            </div>
        </div>
    </main>
    @endsection

    @section('customJs')
        <script>
            
        </script>
    @endsection
