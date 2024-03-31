@extends('client.layouts.app')

@section('headers')
    <title>Reset password</title>
@endsection

@section('contents')
    <!-- main -->
    <main class="max-w-[1400px] mx-auto px-3 mt-3 sm:px-6 md:px-8">

        <div class="w-full w-[90%] md:w-[400px] px-6 py-4 mt-10 mx-auto bg-white rounded-lg shadow-md">
            
            <div class="flex justify-center text-xl font-medium mx-auto" style="margin-top: 35px !important">Reset Password</div>
            @if (Session::has('error'))
                <span class="block w-full text-[14px] text-red-600 my-2 text-center">{{ Session::get('error') }}</span>
            @endif

            @if (Session::has('message'))
                <span style="color: rgb(0, 140, 255)" class="block w-full text-[14px]  my-2 text-center">{{ Session::get('message') }}</span>
            @endif

            
            <form action="{{ route('sendResetEmail') }}" method="post" style="margin-bottom: 30px; " id="resetForm">
                
                @csrf
                @method('post')

                <div>
                    <label for="email" class="block text-[13px] text-gray-800">Email</label>
                    <input type="text" name="email"
                        class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border rounded-lg focus:border-blue-400 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40" required/>
                </div>

                <div class="mt-6">
                    <button type="submit" id="submit"
                        class="w-full px-6 py-2.5 text-[13px] font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-gray-800 rounded-lg hover:bg-gray-700 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-50">
                        Send reset link
                    </button>
                </div>
            </form>
            

            


            
        </div>

    </main>
@endsection

@section('customJs')
   
@endsection
