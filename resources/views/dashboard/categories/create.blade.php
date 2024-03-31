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
                  <form id="CategoryForm" class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4>Categories</h4>
                        <a href="{{ route('categories.index') }}" class="btn btn-primary">Back</a>
                    </div>
                    <div class="form-group">
                      <label>Category name</label>
                      <input type="text" name="name" id="name" class="form-control">
                    </div>
                    <div class="w-full d-flex  align-items-center justify-content-between">
                      <div class="form-group pr-2" style="width: 100%">
                        <label>Show on home</label>
                        <select class="form-control" name="show_home" id="show_home" aria-placeholder="Select status">
                          <option value="Yes" selected>Yes</option>
                          <option value="No">No</option>
                        </select>
                      </div>
                      <div class="form-group pl-2" style="width: 100%">
                        <label>Status</label>
                        <select class="form-control" name="status" id="status" aria-placeholder="Select status">
                          <option value="pending" selected>Pending</option>
                          <option value="published">Published</option>
                        </select>
                      </div>
                    </div>

                    <div class="mt-2">
                        <button class="btn btn-info" id="SaveBtn">Save Category</button>
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
        
        $('#CategoryForm').on('submit', function(e){
            e.preventDefault();

            $('#SaveBtn').prop('disabled', true);
            $.ajax({
                url: "{{ route('categories.store') }}",
                type: 'post',
                data: $(this).serializeArray(),
                success: function(response){
                    $('#SaveBtn').prop('disabled', false);

                    if(response.status == false){
                      var message = 'Please fill all the fields';
                      if(response.errors.name == 'The name has already been taken.'){
                        message = 'The name has already been taken.';
                      }
                        Swal.fire({
                            icon: 'warning',
                            title: 'warning',
                            text: message,
                            showCancelButton: false,
                        });

                    }else if(response.status == true){
                        Swal.fire({
                            icon: 'success',
                            title: 'success',
                            text: 'New category created 😎',
                            showCancelButton: true,
                            cancelButtonText: 'Create another',
                            confirmButtonText: 'All Categories',
                            preConfirm: () => {
                                // Redirect to your desired link
                                window.location.href = "{{ route('categories.index') }}";
                            }}).then((result) => {
                                if(!result.isConfirmed){
                                    $('#name').val('');
                                    $('#status').val('pending');
                                }
                            });
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'An error occurred',
                            text: 'Something went wrong',
                            showCancelButton: true,
                            confirmButtonText: 'Try again',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Redirect to your desired link
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