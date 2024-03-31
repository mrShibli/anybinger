<!DOCTYPE html>
<html lang="en">


<!-- auth-login.html  21 Nov 2019 03:49:32 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>AnyBringr - Verify question</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('/dashboard/assets/css/app.min.css') }}">
  <link rel="stylesheet" href="assets/bundles/bootstrap-social/bootstrap-social.css') }}">
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('/dashboard/assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('/dashboard/assets/css/components.css') }}">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="{{ asset('/dashboard/assets/css/custom.css') }}">
  <link rel='shortcut icon' type='image/x-icon' href='{{ asset('/dashboard/assets/img/favicon.ico') }}' />
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="card card-primary">
              <div class="card-header">
                <h4>Security question</h4>
              </div>
              @if(Session::has('error'))
                    <div class="text-danger text-center mt-1">
                      {{Session::get('error')}}
                    </div>
              @enderror
              <div class="card-body">
                <form method="POST" action="{{ route('secured.verifyQuestion') }}" class="needs-validation" novalidate="">
                  @csrf
                  
                  <div class="form-group">
                    <label for="question">What is your email?</label>
                    <input id="name" type="name" class="form-control" name="name" tabindex="1" required autofocus>
                    <div class="invalid-feedback">
                      Please fill in your email
                    </div>
                    @error('name')
                    <div class="text-danger text-sm mt-1">
                      {{$message}}
                    </div>
                    @enderror
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Verify Question
                    </button>
                  </div>
                </form>
                
          </div>
        </div>
      </div>
    </section>
  </div>

  <script src="{{ asset('/dashboard/assets/js/app.min.js') }}"></script>
  <script src="{{ asset('/dashboard/assets/js/scripts.js') }}"></script>
</body>
</html>