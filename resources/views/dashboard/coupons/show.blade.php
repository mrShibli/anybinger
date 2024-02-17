@extends('dashboard.layouts.app')
  
@section('contents')

    @include('dashboard.layouts.sidebar')
    <!-- Main Content -->
    <div class="main-content">
        <div class="row">
            <div class="col-12">
            <div class="card">
                <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h4>Coupons</h4>
                    @if (Session::has('error'))
                        <h5 class="text-danger font-md">{{ Session::get('error') }}</h5>
                    @endif
                    <a href="{{ route('coupons.create') }}" class="btn btn-primary">Create Coupon</a>
                </div>
                <div class="table-responsive">
                    @if ($coupons->isNotEmpty())
                    <table class="table table-striped" id="table-1">
                    <thead>
                        <tr>
                        <th class="text-center">
                            ID
                        </th>
                        <th>Code</th>
                        <th>Type</th>
                        <th>Discount</th>
                        <th>Max usage</th>
                        <th>Status</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    @foreach ($coupons as $coupon)
                        <tr>
                            <td>{{ $coupon->id }}</td>
                            <td>{{ $coupon->code }}</td>
                            <td>{{ $coupon->type }}</td>
                            <td>{{ $coupon->discount_amount }}</td>
                            <td>{{ $coupon->max_usage }}</td>
                            <td>
                                <div class="badge badge-{{ $coupon->status == 'pending' ? 'danger' : 'success' }} badge-shadow text-capitalize">{{ $coupon->status }}</div>
                            </td>
                            <td>
                                <a href="{{ route('coupons.edit', $coupon->id) }}" class="btn btn-dark">Edit</a>
                                <a href="javascript:void(0);" onclick="deleteCoupon({{ $coupon->id }})" class="ml-1 btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                        
                    </tbody>
                    </table>
                    @else
                        <h4 class=" text-center">No Coupons found</h4>
                    @endif
                </div>
                <div class="mt-3 mx-auto">
                    {{ $coupons->links('pagination::bootstrap-5') }}
                </div>
                </div>

           
                </div>
            </div>
            </div>
        </div>
    </div>
  
@endsection


@section('customJs')
    <script>
    function deleteCoupon(id){
     Swal.fire({
            icon: 'warning',
            title: 'warning!',
            text: 'Are you sure to delete this Coupon?',
            showCancelButton: true,
            confirmButtonText: 'Confirm Delete',
            preConfirm: () => {   
            
                var route = "{{ route('coupons.destroy', 'ID') }}";
                const url = route.replace('ID', id);
                $.ajax({
                    url: url,
                    type: 'delete',
                    data: $(this).serializeArray(),
                    success: function(response){
                        if(response.status == true){
                            Swal.fire({
                                icon: 'success',
                                title: 'success',
                                text: response.message ,
                                showCancelButton: false,
                                confirmButtonText: 'Confirm',
                                preConfirm: () => {
                                    window.location.href = "{{ route('coupons.index') }}";
                                }});
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'An error occurred',
                                text: 'Something went wrong',
                                showCancelButton: false,
                                confirmButtonText: 'Reload page',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            });
                        }

                    }
                })
            }
        });
    }

    </script>
@endsection