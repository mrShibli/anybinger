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
                  <form id="FaqForm" class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4>Faqs</h4>
                        <a href="{{ route('faqs.index') }}" class="btn btn-primary">Back</a>
                    </div>
                    <div class="form-group">
                      <label>Faq title</label>
                      <input type="text" name="title" id="title" class="form-control">
                    </div>
                    <div class="form-group">
                      <label>Faq description</label>
                      <textarea  name="description" id="description" class="form-control" style="height: 110px !important"></textarea>
                    </div>

                    <div class="form-group pr-2" style="width: 100%">
                      <label>Show on</label>
                      <select class="form-control" name="show_on" id="show_on" aria-placeholder="Select status">
                        <option value="home" selected>Home page</option>
                        <option value="traveler">Traveler page</option>
                      </select>
                    </div>

                    <div class="mt-2">
                        <button class="btn btn-info" id="SaveBtn">Save Faq</button>
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
        
        $('#FaqForm').on('submit', function(e){
            e.preventDefault();

            $('#SaveBtn').prop('disabled', true);
            $.ajax({
                url: "{{ route('faqs.store') }}",
                type: 'post',
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
                            showCancelButton: true,
                            cancelButtonText: 'Create another',
                            confirmButtonText: 'All Faqs',
                            preConfirm: () => {
                                window.location.href = "{{ route('faqs.index') }}";
                            }}).then((result) => {
                                if(!result.isConfirmed){
                                    $('#title').val('');
                                    $('#description').val('');
                                    $('#show_on').val('home');
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