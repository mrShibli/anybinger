@extends('dashboard.layouts.app')
  
@section('contents')

    @include('dashboard.layouts.sidebar')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12 col-md-8 col-lg-8 mx-auto">
                <div class="card">
                  <form id="RequestPForm" class="card-body" enctype="multipart/form-data" method="POST">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4>Requested product</h4>
                        <a href="{{ route('products.requests') }}" class="btn btn-primary">Back</a>
                    </div>

                    <div class="card border px-3 pt-3">
                    <h6>Customer name: <span class="text-dark">{{ $request->user->name }}</span></h6>

                        <h6>Product url: <a href="{{ $request->url }}" target="_blank">{{ $request->url }}</a></h6>
                    <h6>Quantity: <span class="text-info">{{ $request->qty }}</span></h6>
                    <h6>Customer note: <span class="text-dark">{{ $request->notes }}</span></h6>
                    </div>
                    

                    <div class="w-full d-flex  align-items-center justify-content-between">
                      <div class="form-group pr-2" style="width: 100%">
                        <label>Product name</label>
                        <input type="text" name="name" value="{{ $request->name ?? $request->name }}" id="link" class="form-control">
                      </div>

                      <div class="form-group pr-2" style="width: 100%">
                        <label>Product price</label>
                        <input type="text" name="price"  value="{{ $request->original_price ?? $request->original_price }}" class="form-control">
                      </div>
                    </div>

                    <div class="w-full d-flex  align-items-center justify-content-between">
                      <div class="form-group pr-2" style="width: 50%">
                        <label>Product qty</label>
                        <input type="number" name="qty" value="{{ $request->qty ?? $request->qty }}" id="link" class="form-control">
                      </div>

                      <div class="form-group">
                        <label>Product image</label>
                        <input type="file" name="image" id="image"  class="form-control">
                      </div>
                    </div>

                    <div class="mt-2">
                        <button class="btn btn-success" id="SaveBtn">Accept request</button>
                    </div>
                   </form>
                  </div>
                </div>
              </div>

              <div></div>
            </div>
          </div>
        </section>
      </div>
  

@endsection


@section('customJs')
    <script>
        
        $('#RequestPForm').on('submit', function(e){
            e.preventDefault();
            var formdata = new FormData(this);
            $('#SaveBtn').addClass('disabled btn-progress');
            $.ajax({
                url: "{{ route('products.acceptRequest', $request->id) }}",
                type: 'post',
                data: formdata,
                processData: false,
                contentType: false,
                success: function(response){
                    $('#SaveBtn').removeClass('disabled btn-progress');

                    if(response.status == false){
                        Swal.fire({
                            icon: 'warning',
                            title: 'warning',
                            text: response.errors,
                            showCancelButton: false,
                        });

                    }else if(response.status == true){
                        Swal.fire({
                            icon: 'success',
                            title: 'success',
                            text: response.message,
                            confirmButtonText: 'Confirm',
                            preConfirm: () => {
                                window.location.href = "{{ route('products.requests') }}";
                            }})
                    }
                },
                error: function(error){
                  Swal.fire({
                      icon: 'error',
                      title: 'An error occurred',
                      text: 'Something went wrong, try later',
                      showCancelButton: true,
                      confirmButtonText: 'Try again',
                  }).then((result) => {
                      if (result.isConfirmed) {
                          window.location.reload();
                      }
                  });
                }
            })
        });

    </script>
@endsection