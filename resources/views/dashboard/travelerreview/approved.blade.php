@extends('dashboard.layouts.app')

@section('contents')
    @include('dashboard.layouts.sidebar')
    <!-- Main Content -->
    <div class="main-content" style="height: 100vh !important">
        <div class="modal fade" id="fullscreenModal" tabindex="-1" aria-labelledby="fullscreenModalLabel" aria-hidden="true"
            style="background: rgba(224, 224, 224, 0.486); height: 100vh !important">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content" style="height: 90vh !important">
                    <button type="button" class="btn btn-dark text-white" data-bs-dismiss="modal" aria-label="Close"
                        onclick="closeModal()">Close Modal</button>
                    <img id="modalImage" alt="Modal Image" class="mt-3  mx-auto max-h-fit " style="width: 90%; " />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">


                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h4>Approved Traveler Request</h4>
                            @if (Session::has('error'))
                                <h5 class="text-danger font-md">{{ Session::get('error') }}</h5>
                            @endif

                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>BD Out Num</th>
                                        <th>BD Num</th>
                                        <th>Out Address</th>
                                        <th>BD Address</th>
                                        <th>Barth</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Zip Code</th>
                                        <th>Passport</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($travelers->isNotEmpty())
                                        @foreach ($travelers as $t)
                                            <tr>
                                                <td>{{ $t->full_name }}</td>
                                                <td>{{ $t->out_cunt_num }}</td>
                                                <td>{{ $t->bd_number }}</td>
                                                <td>{{ $t->out_address }}</td>
                                                <td>{{ $t->bd_address }}</td>
                                                <td>{{ $t->barth }}</td>
                                                <td>{{ $t->city }}</td>
                                                <td>{{ $t->state }}</td>
                                                <td>{{ $t->zip_code }}</td>
                                                <td>
                                                    <img width="50px" onClick="openModal(this)"
                                                        src="{{ asset('storage/' . $t->passport) }}" class="cursor-pointer"
                                                        alt="" style="cursor: pointer" srcset="">
                                                </td>

                                                <td>
                                                    <select id="role_{{ $t->id }}"
                                                        onchange="cancelTraveler('{{ $t->id }}')">
                                                        <option value="approve" selected>Approved</option>
                                                        <option value="cancelled">Cancelled</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="11" class="text-center">No Traveler approved</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customJs')
    <script>
        function openModal(imageSrc) {
            var modalImage = document.getElementById("modalImage");
            modalImage.src = imageSrc.src;

            // Show the Bootstrap modal
            $('#fullscreenModal').modal('show');
        }

        function closeModal() {
            // Hide the Bootstrap modal
            $('#fullscreenModal').modal('hide');
        }
    </script>


    <script>
        function cancelTraveler(id) {
            console.log("hi");
            $.ajax({
                url: '{{ route('traveler.role.delete') }}',
                type: 'POST',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}', // Add this line to include CSRF token
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: response.message,
                            text: '',
                            icon: 'success',
                            confirmButtonText: 'Confirm',
                            preConfirm: () => {
                                window.location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Failed',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'Confirm',
                            preConfirm: () => {
                                window.location.reload();
                            }
                        });
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    Swal.fire({
                        title: 'Failed',
                        text: 'Something went wrong',
                        icon: 'error',
                        confirmButtonText: 'Confirm'
                    });
                }
            });
        }
    </script>
@endsection
