<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>AnyBringr - Admin Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('dashboard/assets/css/app.min.css') }}">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('dashboard/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/assets/css/components.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- toaster cdn-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <!-- dropzone -->
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <link rel="stylesheet" href="{{ asset('dashboard/assets/css/components.css') }}">
    <link rel="stylesheet"
        href="{{ asset('dashboard/assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/assets/bundles/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/assets/bundles/jquery-selectric/selectric.css') }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.6.0/bootstrap-tagsinput.css"
        integrity="sha512-3uVpgbpX33N/XhyD3eWlOgFVAraGn3AfpxywfOTEQeBDByJ/J7HkLvl4mJE1fvArGh4ye1EiPfSBnJo2fgfZmg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="{{ asset('dashboard/assets/css/custom.css') }}">
    <link rel="icon" href="{{ asset('uploads/settings/' . $anyBringrSettings->logo) }}" type="image/png">
</head>

<body>
    {{-- <div class="loader"></div> --}}
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            @yield('contents')

            @include('dashboard.layouts.themeSetting')
            {{-- <footer class="main-footer">
                <div class="footer-left">
                    <a href="resistano.net">Geek& Folicsoft</a></a>
                </div>
                <div class="footer-right">
                </div>
            </footer> --}}
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('dashboard/assets/js/app.min.js') }}"></script>
    <!-- JS Libraies -->
    <script src="{{ asset('dashboard/assets/bundles/apexcharts/apexcharts.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('dashboard/assets/js/page/index.js') }}"></script>
    <!-- Template JS File -->
    <script src="{{ asset('dashboard/assets/js/scripts.js') }}"></script>
    <!-- Custom JS File -->
    <script src="{{ asset('dashboard/assets/js/custom.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @yield('customJs')


    <!-- Include SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    {{-- <script src="/dashboard/assets/bundles/sweetalert/sweetalert.min.js"></script> --}}



</body>

</html>
