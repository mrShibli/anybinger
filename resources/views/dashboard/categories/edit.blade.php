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
                      <input type="text" name="name" value="{{ $category->name }}" id="name" class="form-control">
                    </div>
                    <div class="w-full d-flex  align-items-center justify-content-between">
                      <div class="form-group pr-2" style="width: 100%">
                        <label>Show on home</label>
                        <select class="form-control" name="show_home" id="show_home" aria-placeholder="Select status">
                          <option value="Yes" {{ ($category->show_home == 'Yes') ? 'selected' : ''}}>Yes</option>
                          <option value="No" {{ ($category->show_home == 'No') ? 'selected' : ''}}>No</option>
                        </select>
                      </div>
                      <div class="form-group pl-2" style="width: 100%">
                        <label>Status</label>
                        <select class="form-control" name="status" id="status" aria-placeholder="Select status">
                          <option value="pending" {{ ($category->status == 'pending') ? 'selected' : ''}} >Pending</option>
                          <option value="published" {{ ($category->status == 'published') ? 'selected' : ''}}>Published</option>
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
                url: "{{ route('categories.update', $category->id) }}",
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
                            text: 'Category updated successfully',
                            showCancelButton: false,
                            confirmButtonText: 'Confirm',
                            preConfirm: () => {
                                window.location.href = "{{ route('categories.index') }}";
                            }});
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'An error occurred',
                            text: 'Category not found',
                            showCancelButton: false,
                            confirmButtonText: 'Go Back',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('categories.index') }}";
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