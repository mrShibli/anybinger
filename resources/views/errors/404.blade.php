@extends('client.layouts.app')
<title>404 Request Page Not Found</title>

<style>
    .containerr {
        text-align: center;
        max-width: 1400px;
        width: 100%;
        padding: 20px;
    }
</style>

@section('headers')
@endsection

@section('contents')
    <!-- main starts here -->
    <main class="max-w-[1400px] mx-auto px-3 mt-3 sm:px-6 md:px-8">
        <div class="containerr bg-white my-5">
            <h1 class=" font-bold" style="font-size: 70px; font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif">404</h1>
            <p class="text-sm">Oops! Page not found.</p>
            <p class="text-sm">We are sorry, but the requested page wasnot found. Please tyy again</p>
            <div class="back-to-home mt-4">
                <a href="{{ route('index') }}" class="btn-outline ">Back to Home</a>
            </div>
        </div>
    </main>
@endsection

@section('customJs')
@endsection
