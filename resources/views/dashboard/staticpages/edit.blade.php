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
                  <form id="StaticPageForm" class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4>Static Pages</h4>
                        <a href="{{ route('staticpages.index') }}" class="btn btn-primary">Back</a>
                    </div>

                    <div class="form-group" >
                      <label>Page name</label>
                      <input type="text" name="name" id="name" value="{{ $staticpage->name }}"  class="form-control" disabled title="Can't change page name">
                    </div>

                    <div class="form-group">
                      <label>Description</label>
                      <textarea class="" id="description" name="description">{{ $staticpage->description }}</textarea>
                    </div>

                    <div class="form-group col-12 px-0">
                        <label class="col-form-label">Meta Keyword <span class="text-warning">(each word should seprated by coma)</span></label>
                        <input type="text" id="meta_keyword" value="{{ $staticpage->meta_keyword }}" name="meta_keyword" class="form-control">
                    </div>
                    <div class="form-group col-12 px-0">
                        <label class="col-form-label">Meta Description</label>
                        <textarea class="form-control" id="meta_description" name="meta_description" style="height: 100px !important">{{ $staticpage->meta_description }}</textarea>
                    </div>

                    <div class="mt-2">
                        <button class="btn btn-info" id="SaveBtn">Update Page</button>
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
    <script src="https://cdn.tiny.cloud/1/h2axwpnzfh7k1agff20oqbrdvqd0hpov0jv1oc3q8gb14mqi/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
      tinymce.init({
          selector: '#description',
          plugins: 'lists link image',
          toolbar: "undo redo | blocks | bold italic | alignleft aligncenter alignright alignjustify | outdent indent",
          height: 300, // Specify the height of the editor
      });
    </script>

    <script>
        
        $('#StaticPageForm').on('submit', function(e){
            e.preventDefault();
            tinymce.triggerSave();
            var formdata = new $(this).serializeArray();
            $('#SaveBtn').prop('disabled', true);
            $.ajax({
                url: "{{ route('staticpages.update', $staticpage->id) }}",
                type: 'put',
                data: formdata,
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
                            confirmButtonText: 'All Pages',
                            preConfirm: () => {
                                window.location.href = "{{ route('staticpages.index') }}";
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