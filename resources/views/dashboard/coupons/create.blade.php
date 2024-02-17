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
                  <form id="CouponForm" class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4>Coupons</h4>
                        <a href="{{ route('coupons.index') }}" class="btn btn-primary">Back</a>
                    </div>

                    <div class="w-full d-flex  align-items-center justify-content-between">
                      <div class="form-group pr-2" style="width: 100%">
                        <label>Coupon code</label>
                        <input type="text" name="code" id="code" class="form-control">
                      </div>

                      <div class="form-group pr-2" style="width: 100%">
                        <label>Discount type</label>
                        <select name="type" id="" class="form-control">
                          <option value="fixed">Fixed</option>
                          <option value="percentage">Percentage</option>
                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <label>Minimum Amount for Discount</label>
                      <input type="number" name="min_amount"  class="form-control">
                    </div>

                    <div class="w-full d-flex  align-items-center justify-content-between">
                      <div class="form-group pr-2" style="width: 100%">
                        <label>Discount amount</label>
                        <input type="number" name="discount_amount" class="form-control">
                      </div>

                    </div>

                    <div class="w-full d-flex  align-items-center justify-content-between">
                      <div class="form-group pr-2" style="width: 100%">
                        <label>Expire date</label>
                        <input type="datetime-local" name="expire_date"  class="form-control">
                      </div>

                      <div class="form-group pr-2" style="width: 100%">
                        <label>Status</label>
                        <select class="form-control" name="status"  aria-placeholder="Select status">
                        <option value="pending" selected>Pending</option>
                        <option value="published">Published</option>
                        </select>
                      </div>
                    </div>
                    
                    <div class="mt-2">
                        <button class="btn btn-info " type="submit" id="SaveBtn">Save Coupon</button>
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
        
        $('#CouponForm').on('submit', function(e){
            e.preventDefault();
            let formdata = $(this).serializeArray();
            $('#SaveBtn').addClass('disabled btn-progress');
            $.ajax({
                url: "{{ route('coupons.store') }}",
                type: 'post',
                data: formdata,
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
                            showCancelButton: false,
                            confirmButtonText: 'All Coupons',
                            preConfirm: () => {
                                window.location.href = "{{ route('coupons.index') }}";
                            }})
                    }
                },
                error: function(error){
                  $('#SaveBtn').removeClass('disabled btn-progress');
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