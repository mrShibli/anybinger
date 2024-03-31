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
                  <form id="SubCategoryForm" class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4>Sub Category</h4>
                        <a href="{{ route('subcategories.index') }}" class="btn btn-primary">Back</a>
                    </div>
                    <div class="form-group">
                      <label>Sub Category name</label>
                      <input type="text" name="name" id="name" class="form-control">
                    </div>
                    <div class="form-group">
                      <label>Main Category</label>
                      <select class="form-control" name="category_id" id="category_id" >
                        <option selected>Select a category</option>
                        @if ($categories->isNotEmpty())
                          @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                          @endforeach
                        @endif
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Status</label>
                      <select class="form-control" name="status" id="status" aria-placeholder="Select status">
                        <option value="pending" selected>Pending</option>
                        <option value="published">Published</option>
                      </select>
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
        
        $('#SubCategoryForm').on('submit', function(e){
            e.preventDefault();

            $('#SaveBtn').prop('disabled', true);
            $.ajax({
                url: "{{ route('subcategories.store') }}",
                type: 'post',
                data: $(this).serializeArray(),
                success: function(response){
                    $('#SaveBtn').prop('disabled', false);

                    if(response.status == false){
                      var message = 'Please fill all the fields';
                      if(response.errors.name == 'The name has already been taken.'){
                        message = 'The name has already been taken';
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
                            text: 'Sub category created successfully 🎉',
                            showCancelButton: true,
                            cancelButtonText: 'Create another',
                            confirmButtonText: 'All SubCategories',
                            preConfirm: () => {
                                // Redirect to your desired link
                                window.location.href = "{{ route('subcategories.index') }}";
                            }}).then((result) => {
                                if(!result.isConfirmed){
                                    $('#name').val('');
                                    $('#category_id').val('');
                                    $('#status').val('pending');
                                }
                            });
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'An error!',
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