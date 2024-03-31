@extends('dashboard.layouts.app')
  
@section('contents')

    @include('dashboard.layouts.sidebar')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12 col-md-6 col-lg-6 mx-auto">
                <div class="card">
                  <form id="TReviewForm" class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4>Traveler Review</h4>
                        <a href="{{ route('travelerreviews.index') }}" class="btn btn-primary">Back</a>
                    </div>
                    <div class="form-group">
                      <label>Traveler name</label>
                      <input type="text" name="name" id="name" value="{{ $travelerreview->name }}" class="form-control">
                    </div>
                    <div class="form-group">
                      <label>Traveler about</label>
                      <input type="text" name="about" id="about"  value="{{ $travelerreview->about }}" class="form-control">
                    </div>
                    <div class="form-group">
                      <label>Traveler review</label>
                      <textarea  name="review" id="review" class="form-control" style="height: 110px !important">{{ $travelerreview->review }}</textarea>
                    </div>

                    <div class="mt-2">
                        <button class="btn btn-info" id="SaveBtn">Update Review</button>
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
        
        $('#TReviewForm').on('submit', function(e){
            e.preventDefault();

            $('#SaveBtn').prop('disabled', true);
            $.ajax({
                url: "{{ route('travelerreviews.update', $travelerreview->id) }}",
                type: 'put',
                data: $(this).serializeArray(),
                success: function(response){
                    $('#SaveBtn').prop('disabled', false);
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
                            showCancelButton: false,
                            confirmButtonText: 'Confirm',
                            preConfirm: () => {
                                window.location.href = "{{ route('travelerreviews.index') }}";
                            }});
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'An error occurred',
                            text: 'Something went wrong',
                            showCancelButton: true,
                            confirmButtonText: 'Try again',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
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