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
                  <form id="SliderUForm" class="card-body" >
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4>Update Sliders</h4>
                        <a href="{{ route('sliders.index') }}" class="btn btn-primary">Back</a>
                    </div>

                    <div class="w-full d-flex  align-items-center justify-content-between">
                      <div class="form-group pr-2" style="width: 100%">
                        <label>Slides link</label>
                        <input type="text" name="link" id="link"  value="{{ $slides->link }}" class="form-control">
                      </div>

                      <div class="form-group pr-2" style="width: 100%">
                        <label>Slides text</label>
                        <input type="text"  name="text" id="text" value="{{ $slides->text }}" class="form-control">
                      </div>
                    </div>
                    @if ($slides->image)
                        <img src="{{ asset('/uploads/sliders') . '/' .$slides->image }}" alt="" style="width: 100%; max-height:140px">
                    @endif
                    <div class="form-group mt-1">
                      <label>Slides image</label>
                      <input type="file" name="image" id="image" class="form-control">
                    </div>
                    <div class="form-group" style="width: 100%">
                        <label>Status</label>
                        <select class="form-control" name="status" id="status" aria-placeholder="Select status">
                        <option value="pending" {{ $slides->status == 'pending' ? 'selected' : '' }} >Pending</option>
                        <option value="published" {{ $slides->status == 'published' ? 'selected' : '' }} >Published</option>
                        </select>
                    </div>

                    <div class="mt-2">
                        <button class="btn btn-info" id="SaveBtn">Update Slides</button>
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
        
        $('#SliderUForm').on('submit', function(e){
            e.preventDefault();

            $('#SaveBtn').prop('disabled', true);

              var formdata = new FormData(this);

              $.ajax({
                  url: "{{ route('sliders.change', $slides->id) }}",
                  type: 'post',
                  data: formdata,
                  processData: false,
                  contentType: false,
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
                              confirmButtonText: 'All Sliders',
                              preConfirm: () => {
                                  window.location.href = "{{ route('sliders.index') }}";
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