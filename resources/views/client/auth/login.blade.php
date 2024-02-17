@extends('client.layouts.app')

@section('headers')
    <title>Login to account</title>
@endsection

@section('contents')
    <!-- main -->
    <main class="max-w-[1400px] mx-auto px-3 mt-3 sm:px-6 md:px-8">

        <div class="w-full w-[90%] md:w-[400px] px-6 py-4 mt-10 mx-auto bg-white rounded-lg shadow-md">
            <div class="flex justify-center text-xl font-medium mx-auto">User login </div>
            @if (Session::has('error'))
                <span class="block w-full text-[19px] text-red-600 my-2 text-center">{{ Session::get('error') }}</span>
            @endif

            <form class="mt-6" id="loginForm">
                <div>
                    <label for="email" class="block text-[13px] text-gray-800">Email</label>
                    <input type="text" name="email"
                        class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border rounded-lg focus:border-blue-400 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40" />
                </div>

                <div class="mt-4">
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-[13px] text-gray-800">Password</label>
                        <a href="{{ route('reset') }}" class="text-xs text-gray-600 hover:underline">Forget Password?</a>
                    </div>

                    <input type="password" name="password"
                        class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border rounded-lg focus:border-blue-400 focus:ring-blue-300 focus:outline-none focus:ring focus:ring-opacity-40" />
                </div>

                <div class="flex items-center my-4">
                    <input id="checkbox-1" name="remember" aria-describedby="checkbox-1" type="checkbox"
                        class="bg-gray-50 border-gray-300 focus:ring-3 focus:ring-blue-300 h-4 w-4 rounded"
                        checked="" />
                    <label for="checkbox-1" class="text-[13px] ml-3 font-medium text-gray-900">Remember login</label>
                </div>

                <div class="mt-6">
                    <button type="submit" id="submit"
                        class="w-full px-6 py-2.5 text-[13px] font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-gray-800 rounded-lg hover:bg-gray-700 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-50">
                        Sign In
                    </button>
                </div>
            </form>

            {{-- <p class="mt-8 text-xs font-light text-center text-gray-400">
                Don't have an account?
                <a href="#" class="font-medium text-gray-700 hover:underline">Create One</a>
            </p> --}}

            <div class="mt-5 flex items-center justify-between text-xs font-light text-center text-gray-400">
                <hr class="w-[40%]"><span class="text-blue-dark font-medium">Or</span>
                <hr class="w-[40%]">
            </div>

            <div class="mt-6">
                <a href="{{ route('redirectToGoogle') }}">
                    <button type="button"
                        class="flex-center gap-3 w-full px-6 py-2 text-[13px] font-medium tracking-wide text-blue-dark capitalize transition-colors border border-gray-300 duration-300 transform bg-white rounded-lg hover:bg-gray-200 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-50">
                        <img src="{{ asset('client/images/google.png') }}" alt="" style="width: 25px"> Continue with
                        google
                    </button>
                </a>
            </div>
        </div>

    </main>
@endsection

@section('customJs')
    <script>
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();
            const formData = $(this).serializeArray();
            $('#submit').prop('disabled', true);
            $.ajax({
                url: '{{ route('login.verify') }}',
                type: 'post',
                data: formData,
                success: function(response) {
                    $('#submit').prop('disabled', false);

                    if (response.status == true) {
                        window.location.href = '{{ route('account.index') }}';
                    } else if (response.status == 'url') {
                        window.location.href = response.intendedUrl;
                    } else {
                        swal.fire({
                            icon: 'warning',
                            title: 'Warning',
                            text: response.errors,
                            confirmButtonText: 'Confirm'
                        });
                    }
                },
                error: function(response) {
                    swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong',
                        confirmButtonText: 'Confirm'
                    });
                }
            });
        });
    </script>
@endsection
