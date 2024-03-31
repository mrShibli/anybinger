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
                    <h4>Faqs - Frequently asked question</h4>
                    @if (Session::has('error'))
                        <h5 class="text-danger font-md">{{ Session::get('error') }}</h5>
                    @endif
                    <a href="{{ route('faqs.create') }}" class="btn btn-primary">New faq</a>
                </div>
                <div class="table-responsive">
                    @if ($faqs->isNotEmpty())
                    <table class="table table-striped" id="table-1">
                    <thead>
                        <tr>
                        <th class="text-center">
                            ID
                        </th>
                        <th>Name</th>
                        <th>Faq description</th>
                        <th>Show on</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach ($faqs as $faq)
                            <tr>
                                <td>{{ $faq->id }}</td>
                                <td>{{ $faq->title }}</td>
                                <td>{{  Str::length($faq->description) > 40 ? Str::substr($faq->description, 0, 40) . '...' : $faq->description  }}</td>
                                <td>
                                    <div class="badge badge-{{ $faq->show_on == 'traveler' ? 'warning' : 'success' }} badge-shadow text-capitalize">{{ $faq->show_on }}</div>
                                </td>
                                <td>
                                    <a href="{{ route('faqs.edit', $faq->id) }}" class="btn btn-dark">Edit</a>
                                    <a href="javascript:void(0);" onclick="deleteFaq({{ $faq->id }})" class="ml-1 btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                        
                        
                    </tbody>
                    </table>
                    @else
                        <h4 class=" text-center">No Faqs found</h4>
                    @endif
                </div>
                <div class="mt-3 mx-auto">
                    {{ $faqs->links('pagination::bootstrap-5') }}
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
        function deleteFaq(id){
        Swal.fire({
                icon: 'warning',
                title: 'warning!',
                text: 'Are you sure to delete this faq?',
                showCancelButton: true,
                confirmButtonText: 'Confirm Delete',
                preConfirm: () => {   
                
                    var route = "{{ route('faqs.destroy', 'ID') }}";
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
                                    text: response.message,
                                    showCancelButton: false,
                                    confirmButtonText: 'Confirm',
                                    preConfirm: () => {
                                        window.location.href = "{{ route('faqs.index') }}";
                                    }});
                            }else{
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
                }
            });
        }
    </script>
@endsection