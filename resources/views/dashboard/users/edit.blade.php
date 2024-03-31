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
                            <form id="DealerUForm" class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h4>Apply to Dealer</h4>
                                    <a href="{{ route('users.index') }}" class="btn btn-primary">Back</a>
                                </div>
                                @if (!$user)
                                <div class="w-full d-flex  align-items-center justify-content-between">
                                    <div class="form-group pr-2" style="width: 100%">
                                        <label>Dealer shop name</label>
                                        <input type="text" name="shop_name" id=" link"
                                            value="" class="form-control">
                                    </div>

                                    <div class="form-group pr-2" style="width: 100%">
                                        <label>Dealer shop address</label>
                                        <input type="text" name="shop_address" id="text"
                                            value="" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group mt-1">
                                    <label>Dealer contact</label>
                                    <input type="text" name="contact" value=""
                                        class="form-control">
                                </div>
                                @else
                                <div class="w-full d-flex  align-items-center justify-content-between">
                                    <div class="form-group pr-2" style="width: 100%">
                                        <label>Dealer shop name</label>
                                        <input type="text" name="shop_name" id=" link"
                                            value="{{ $user->shop_name ? $user->shop_name : '' }}" class="form-control">
                                    </div>

                                    <div class="form-group pr-2" style="width: 100%">
                                        <label>Dealer shop address</label>
                                        <input type="text" name="shop_address" id="text"
                                            value="{{ $user->shop_address ? $user->shop_address : '' }}" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group mt-1">
                                    <label>Dealer contact</label>
                                    <input type="text" name="contact" value="{{ $user->contact ? $user->contact : ''}}"
                                        class="form-control">
                                </div>
                                @endif
                                

                                <div class="mt-2">
                                    <button class="btn btn-info" id="SaveBtn">Apply dealer</button>
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
        $('#DealerUForm').on('submit', function(e) {
            e.preventDefault();

            $('#SaveBtn').prop('disabled', true);

            var formdata = $(this).serializeArray();

            $.ajax({
                url: "{{ route('users.dealerApply', $usere->id) }}",
                type: 'post',
                data: formdata,
                success: function(response) {
                    $('#SaveBtn').prop('disabled', false);

                    if (response.status == false) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'warning',
                            text: response.errors,
                            showCancelButton: false,
                        });

                    } else if (response.status == true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'success',
                            text: response.message,
                            showCancelButton: false,
                            confirmButtonText: 'Confirm',
                            preConfirm: () => {
                                window.location.href = "{{ route('users.index') }}";
                            }
                        })
                    }
                },
                error: function(error) {
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
