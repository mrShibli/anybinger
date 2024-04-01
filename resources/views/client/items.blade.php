@extends('client.layouts.app')

@section('headers')
    <title>Disocover Products {{ Str::ucfirst($category) }} {{ $subcategory ? '- ' . Str::ucfirst($subcategory) : '' }}
    </title>
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
    <meta name="author" content="Shibli Raihan">

    <!-- og meta tag -->
    <meta name="robots" content="index, follow" />
    <meta name="googlebot" content="index, follow, archive, snippet" />
    <meta name="googlebot-news" content="snippet" />
    <meta name="googlebot-mobile" content="index, follow, archive" />
    <meta name="msnbot" content="index, follow" />
    <meta name="slurp" content="archive, ydir, snippet" />
    <meta name="revisit-after" content="0 days" />
    <meta name="copyright"
        content="© Disocover Products {{ Str::ucfirst($category) }} {{ $subcategory ? '- ' . Str::ucfirst($subcategory) : '' }}" />
    <meta property='og:locale' content='en_US' />
    <meta property="og:locale:alternate" content='bn_BD' />
    <meta property="og:title"
        content="Disocover Products {{ Str::ucfirst($category) }} {{ $subcategory ? '- ' . Str::ucfirst($subcategory) : '' }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://www.anybringr.com/" />
    <meta property="og:image" content="" />
    <meta property="og:site_name" content="Anybringr" />
    <meta property="fb:app_id" content="235034696605750" />
    @include('client.layouts.pagination')
@endsection

@section('contents')
    <!-- main starts here -->
    <main class="max-w-[1400px] mx-auto px-3 mt-3 sm:px-6 md:px-8">
        <div class="bg-white inline-block">
            <div class="flex flex-row items-center justify-between">
                <a href="{{ route('index') }}" class="link">Home</a>
                <i class="fa-solid fa-chevron-right text-[12px] mx-1 text-gray-700"></i>
                <a href="{{ route('products') }}" class="link">Products</a>
                <i class="fa-solid fa-chevron-right text-[12px] mx-1 text-gray-700"></i>
                <a href="{{ route('items', $category) }}" class="link">{{ $category }}</a>
                @if ($subcategory)
                    <i class="fa-solid fa-chevron-right text-[12px] mx-1 text-gray-700"></i>
                    <a href="" class="link">{{ $subcategory }}</a>
                @endif
            </div>
        </div>
        <hr class="mt-[3px]" />
        <div class="products">

            @if ($products->isNotEmpty())
                @foreach ($products as $product)
                    {{-- <div class="product">
                        <div class="flex justify-center items-center w-full relative group cursor-pointer overflow-clip">
                            @php
                                $productImages = $product
                                    ->productImage()
                                    ->latest()
                                    ->first();
                                $imageName = $productImages ? $productImages->name : null;
                                $discount = $product->compare_price - $product->price;
                            @endphp

                            @if ($product->compare_price > 0)
                                <div class="px-2 bg-red-500 text-white rounded-full flex-center absolute top-1 left-1 ">
                                    <span class="text-[11px]">-{{ $discount }}&#2547;</span>
                                </div>
                            @endif
                            <a href="{{ route('product', $product->slug) }}"><img
                                    src="{{ $imageName ? asset('uploads/products/' . $imageName) : asset('client/images/650.png') }}"
                                    alt="" class="w-full h-full rounded-lg mx-auto" /></a>

                            <div
                                class="px-[8px] bg-white sm:hidden absolute bottom-1 border rounded-[20px] group-hover:flex transition ease-in duration-150">
                                <i class=""></i>
                                <button onclick="addToCart({{ $product->id }})">
                                    <i
                                        class="fa-solid fa-cart-shopping icons text-slate-600 hover:text-gray-500 mr-1 transition"></i>
                                </button>
                                <button onclick="addToWishlist({{ $product->id }})">
                                    <i
                                        class="fa-regular fa-heart icons text-slate-600 hover:text-gray-500 mx-1 transition"></i>
                                </button>
                                <button>
                                    <i
                                        class="fa-solid fa-magnifying-glass icons text-slate-600 hover:text-gray-500 ml-1 transition"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mt-2 w-full text-center group relative">
                            <a href="{{ route('product', $product->slug) }}"
                                class="link !tex-[12px] sm:!text-[15px]">{{ $product->title }}</a>
                            <p class="flex justify-center items-center" style="margin-top: -9px ">
                                @php
                                    $reviews = \App\Models\Review::where('product_id', $product->id)
                                        ->where('status', 'published')
                                        ->get();
                                    $totalRating = $reviews->isEmpty() ? 0 : $reviews->avg('rating');
                                    $maxStars = 5;
                                    $filledStars = $totalRating ? min(5, max(1, $totalRating)) : 5;
                                @endphp

                                @for ($i = 1; $i <= $maxStars; $i++)
                                    @if ($i <= $filledStars)
                                        <i class="fa-solid fa-star text-[13px] text-orange-500"></i>
                                    @else
                                        <i class="fa-solid fa-star text-[13px] text-gray-500"></i>
                                    @endif
                                @endfor
                                <b class="  text-[13px]"
                                    style="padding-left: 6px !important">{{ number_format($totalRating, 1) }}</b>
                            </p>
                            <div class="flex flex-col xs:flex-row items-center gap-2 justify-center">
                                @if ($product->compare_price > 0)
                                    <p class="text-[13px] line-through text-gray-600">
                                        &#2547;{{ number_format($product->compare_price, 2) }}
                                    </p>
                                @endif
                                <span
                                    class="text-[18px] font-bold text-red-500">&#2547;{{ number_format($product->price, 2) }}</span>
                            </div>
                        </div>
                    </div> --}}
                    <div class="product border-slate-300 border-solid !border-2"
                        style="justify-content: space-between !important">
                        <div class="flex justify-center items-start w-full relative group cursor-pointer overflow-clip">
                            @php
                                $productImages = $product->productImage()->latest()->first();
                                $imageName = $productImages ? $productImages->name : null;
                                $discount = $product->compare_price - $product->price;
                            @endphp

                            @if ($product->compare_price > 0)
                                <div class="px-2 bg-red-500 text-white rounded-full flex-center absolute top-1 left-1 ">
                                    <span class="text-[11px]">-{{ $discount }}&#2547;</span>
                                </div>
                            @endif


                            <a href="{{ route('product', $product->slug) }}"><img style=" height:240px"
                                    alt="{{ $product->title }}"
                                    src="{{ $imageName ? asset('uploads/products/' . $imageName) : asset('client/images/650.png') }}"
                                    class="w-full h-full rounded-lg mx-auto" /></a>

                            <div
                                class="px-[8px] bg-white sm:hidden absolute bottom-1 border rounded-[20px] group-hover:flex transition ease-in duration-150">
                                <i class=""></i>
                                <button onclick="addToCart({{ $product->id }})">
                                    <i
                                        class="fa-solid fa-cart-shopping icons text-slate-600 hover:text-gray-500 mr-1 transition"></i>
                                </button>
                                <button onclick="addToWishlist({{ $product->id }})">
                                    <i
                                        class="fa-regular fa-heart icons text-slate-600 hover:text-gray-500 mx-1 transition"></i>
                                </button>
                                <button>
                                    <i
                                        class="fa-solid fa-magnifying-glass icons text-slate-600 hover:text-gray-500 ml-1 transition"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mt-2 w-full text-center group relative">


                            <a href="{{ route('product', $product->slug) }}"
                                class="link !tex-[12px] sm:!text-[15px]">{{ $product->title }}</a>
                            <p class="flex justify-center items-center" style="margin-top: -9px ">
                                @php
                                    $reviews = \App\Models\Review::where('product_id', $product->id)
                                        ->where('status', 'published')
                                        ->get();
                                    $totalRating = $reviews->isEmpty() ? 0 : $reviews->avg('rating');
                                    $maxStars = 5;
                                    $filledStars = $totalRating ? min(5, max(1, $totalRating)) : 5;
                                @endphp

                                @for ($i = 1; $i <= $maxStars; $i++)
                                    @if ($i <= $filledStars)
                                        <i class="fa-solid fa-star text-[13px] text-orange-500"></i>
                                    @else
                                        <i class="fa-solid fa-star text-[13px] text-gray-500"></i>
                                    @endif
                                @endfor
                                <b class="  text-[13px]"
                                    style="padding-left: 6px !important">{{ number_format($totalRating, 1) }}</b>
                            </p>

                            <div class="flex flex-col xs:flex-row items-center gap-2 justify-center">
                                @if ($product->compare_price > 0)
                                    <p class="text-[13px] line-through text-gray-600">
                                        &#2547;{{ number_format($product->compare_price, 2) }}
                                    </p>
                                @endif
                                <span
                                    class="text-[18px] font-bold text-red-500">&#2547;{{ number_format($product->price, 2) }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
        </div>
    @else
    </main>
    <div class="w-full max-w-[1400px] mx-auto flex items-center justify-center mt-8">
        <h2 class="text-2xl p-2 text-center text-blue-dark w-full">No products available here</h2>
    </div>
    @endif

    <!-- pagination start here  -->
    @if ($products->hasPages())
        <div class="custom-pagination" style="margin-top: 50px !important">
            <ul class="pagination">
                @if ($products->onFirstPage())
                    <li class="disabled"><span><i class="fa-solid fa-angle-left"></i> Previous</span></li>
                @else
                    <li><a href="{{ $products->previousPageUrl() }}"><i class="fa-solid fa-angle-left"></i> Previous</a>
                    </li>
                @endif

                @foreach ($products->links()->elements as $element)
                    @if (is_string($element))
                        <li class="disabled"><span>{{ $element }}</span></li>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            <li class="{{ $page == $products->currentPage() ? 'active' : '' }}">
                                <a href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach
                    @endif
                @endforeach

                @if ($products->hasMorePages())
                    <li><a href="{{ $products->nextPageUrl() }}">Next <i class="fa-solid fa-angle-right"></i></a></li>
                @else
                    <li class="disabled"><span>Next <i class="fa-solid fa-angle-right"></i></span></li>
                @endif
            </ul>
        </div>
    @endif
    </main>
@endsection

@section('customJs')
    @include('client.layouts.javascripts')
@endsection
