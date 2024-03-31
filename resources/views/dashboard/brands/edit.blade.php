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
                  <form id="BrandForm" class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4>Brand</h4>
                        <a href="{{ route('brands.index') }}" class="btn btn-primary">Back</a>
                    </div>
                    <div class="form-group">
                      <label>Nrand name</label>
                      <input type="text" name="name" value="{{ $brand->name }}" id="name" class="form-control">
                    </div>
                    <div class="form-group">
                      <label>Status</label>
                      <select class="form-control" name="status" id="status" aria-placeholder="Select status">
                        <option value="pending" {{ ($brand->status == 'pending') ? 'selected' : ''}} >Pending</option>
                        <option value="published" {{ ($brand->status == 'published') ? 'selected' : ''}}>Published</option>
                      </select>
                    </div>

                    <div class="mt-2">
                        <button class="btn btn-info" id="SaveBtn">Update brand</button>
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
        
        $('#BrandForm').on('submit', function(e){
            e.preventDefault();

            $('#SaveBtn').prop('disabled', true);
            $.ajax({
                url: "{{ route('brands.update', $brand->id) }}",
                type: 'put',
                data: $(this).serializeArray(),
                success: function(response){
                    $('#SaveBtn').prop('disabled', false);

                    if(response.status == false){
                        
                        Swal.fire({
                            icon: 'warning',
                            title: 'warning',
                            text: response.errors.name+" Please try another name",
                            showCancelButton: false,
                        });

                    }else if(response.status == true){
                        Swal.fire({
                            icon: 'success',
                            title: 'success',
                            text: 'brand updated successfully',
                            showCancelButton: false,
                            confirmButtonText: 'Confirm',
                            preConfirm: () => {
                                window.location.href = "{{ route('brands.index') }}";
                            }});
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'An error occurred',
                            text: 'brand not found',
                            showCancelButton: false,
                            confirmButtonText: 'Go Back',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('brands.index') }}";
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