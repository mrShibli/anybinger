  <div class="py-1 fixed bottom-0 justify-around items-center text-[18px]  w-[98%] ml-[1%] rounded-t-full flex bg-blue-dark z-50 mdHiddenNav" style="border-top-right-radius: 20px; border-top-left-radius: 20px;"> 
    
    <a href="{{ route('index') }}" class="px-2 py-2">
      <i class="fa-solid fa-house-chimney text-white text-[18px]"></i>
    </a>
    <div class="relative">
      <a href="javascript:void(0)" onclick="showSearchMobile()" class="px-[5px] py-[4px]">
        <i id="searchIcon" class="fa-solid fa-search text-white text-[19px]"></i>
      </a>
    </div>
    @auth
    <div class=" relative">
      <a href="{{ route('account.notifications') }}"  class="px-[5px] py-[4px]">
        <i class="fa-regular fa-bell text-white text-[20px]"></i>
      </a>
      <div class="absolute flex-center bg-red-600 -top-1 -right-2 w-[15px] h-[15px] rounded-full text-center">
        <span class="text-white font-bold text-[9px]">{{ $notificesOfme->count() }}</span>
      </div>
    </div>
    @endauth
    

    <div class=" relative">
      <a href="{{ route('cart') }}"  class="px-[5px] py-[4px]">
        <i class="fa-solid fa-cart-arrow-down  text-white  text-[19px]"></i>
      </a>
      <div class="absolute flex-center bg-red-600 -top-1 -right-2 w-[15px] h-[15px] rounded-full text-center">
        <span class="text-white font-bold text-[9px]" id="cartCounts">0</span>
      </div>
    </div>
    
    <a href="{{ route('login') }}" class="px-2 py-2">
      <i class="fa-regular text-white fa-user text-[19px]"></i>
    </a>
  </div>
  <header>
    <!-- Top Header -->
    <div id="header" class="">
      <div class="bg-blue-dark h-8 w-full mx-auto flex flex-row gap-3 justify-end text-white items-center">
        <div class="border-r-2 px-3 hidden lg:block">
          <p class="text-sm">Dhaka Delivery Charge ৳{{ $anyBringrSettings->delivery_dhaka ? $anyBringrSettings->delivery_dhaka : 80 }}
            <span>|</span>Outside of Dhaka ৳{{ $anyBringrSettings->delivery_outside ? $anyBringrSettings->delivery_outside : 130}} </p>
        </div>
        <div class="border-r-2 px-3 flex text-sm">
          <a class="mx-2 hidden lg:block" href="{{ route('track.order') }}">TRACK YOUR ORDER</a>
          <a class="mx-2 hidden lg:block" href="{{ route('pages', 'delivery-policy') }}">DELIVERY POLICY</a>
        </div>
        <div class="mr-10 hidden lg:block">
        <a href="{{ $anyBringrSettings->facebook_url }}">
          <i class="fa-brands fa-facebook text-white cursor-pointer"></i>
        </a>
        </div>
      </div>
    </div>

    @include('client.layouts.navbar')

    <div class="border border-x-0 hidden md:block bg-white ">
      <div class="max-w-[1400px] mx-auto">
        <div id="cat" class="sm:w-[90%] md:max-w-[65%] sm:px-6 md:px-8 mx-auto flex justify-center gap-8 h-10 items-center">
        
          @if ($categories->isNotEmpty())
            @foreach ($categories as $category)
              <div class="group text-gray-500 uppercase border-b border-white hover:border-b hover:border-blue-dark cursor-pointer transextion">
               
                <h2 class="text-[14px] relative"> <a href="{{ route('items', $category->slug) }}"> {{ $category->name }}</a>
                  @if ($category->subcategory->isNotEmpty())
                  <div class="z-10 absolute top-[18px] mt-1 w-[200px] hidden group-hover:flex flex-col gap-0 border px-3 py-2 bg-w-lws shadow-md rounded-[4px]">
                        @foreach ($category->subcategory as $subcategory)
                          <a href="{{ route('items', [$category->slug, $subcategory->slug]) }}" class="my-2 font-medium   hover:ml-2 transition ease-in-out">
                          <i class="fa-solid fa-angle-right mr-1"></i>{{ $subcategory->name }}</a>
                        @endforeach
                  </div>
                  @endif
                </h2>
              </div>
            @endforeach
          @endif
        </div>
      </div>
      
    </div>
  </header>