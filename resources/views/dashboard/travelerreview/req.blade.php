@extends('dashboard.layouts.app')

@section('contents')

    @include('dashboard.layouts.sidebar')
    <!-- Main Content -->
    <div class="main-content">
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
                            <h4>New Traveler Request</h4>
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
                                        <th>Zipe Code</th>
                                        <th>Passport</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($traveler->isNotEmpty())
                                        @foreach ($traveler as $traveler)
                                            <tr>
                                                <td>{{ $traveler->full_name }}</td>
                                                <td>{{ $traveler->out_cunt_num }}</td>
                                                <td>{{ $traveler->bd_number }}</td>
                                                <td>{{ $traveler->out_address }}</td>
                                                <td>{{ $traveler->bd_address }}</td>
                                                <td>{{ $traveler->barth }}</td>
                                                <td>{{ $traveler->city }}</td>
                                                <td>
                                                    {{ $traveler->state }}
                                                </td>
                                                <td>{{ $traveler->zip_code }}</td>
                                                <td>
                                                    <img width="50px" onClick="openModal(this)"
                                                        src="{{ asset('storage/' . $traveler->passport) }}" class="cursor-pointer"
                                                        alt="" style="cursor: pointer" srcset="">
                                                </td>
                                                <td>
                                                    <select id="roleApprobe" name="status"
                                                        onChange="updateRole({{ $traveler->id }})">
                                                        <option value="{{ $traveler->status }}">{{ $traveler->status }}
                                                        </option>
                                                        <option value="approve">Approve</option>
                                                        <option value="cancelled">Cancelled</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="text-center" colspan="11">No Traveler review found</td>
                                            </h4>
                                    @endif
                                </tbody>
                            </table>

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
        function updateRole(id) {
            const role = $('#roleApprobe').val()

            $.ajax({
                url: '{{ route('traveler.role.update') }}',
                type: 'POST',
                data: {
                    role: role,
                    id: id
                },
                success: function(response) {
                    console.log();
                    if (response.success) {
                        Swal.fire({
                            title: 'Submitted',
                            text: response.message,
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
        $(document).ready(function() {});
    </script>
@endsection
