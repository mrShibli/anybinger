@extends('client.layouts.app')

@section('headers')
    <title>Apply for traveler</title>
@endsection

@section('contents')
    <main class="w-full max-w-[1400px] mx-auto px-3 sm:px-6 md:px-8">
        <div class="bg-white inline-block mt-3">
            <div class="flex flex-row items-center justify-between">
                <a href="{{ route('index') }}" class="link">Home</a>
                <i class="fa-solid fa-chevron-right text-[12px] mx-1 text-gray-700"></i>
                <a href="" class="link">Traveler Request</a>
            </div>
        </div>

        <div class="w-[96%] md:w-[700px] mx-auto mt-5 bg-white px-3 py-2">
            @if (!is_null($status) && $status->status == 'pending')
                <h2 class="text-2xl text-center font-medium text-gray-700 mb-3" style="margin-top: 10vh; margin-bottom: 10vh">
                    Your Traveler request in review. Please wait for a confirmation message
                </h2>
            {{-- @elseif ( $status->status == 'approve')
            <h2 class="text-2xl font-medium text-gray-700 mb-3" style="margin-bottom: 20vh">
                You Traveler Accoutn Approve
            </h2> --}}
            @else
                <h2 class="text-2xl font-medium text-gray-700 mb-3">
                    Enter your information
                </h2>
                <div class="flex flex-col gap-4 ">
                    <form action="" class="flex flex-col gap-2" id="travelForm">
                        @csrf
                        <div class="flex flex-col sm:flex-row justify-between items-center gap-2 md:gap-5">
                            <div class="w-full flex flex-col gap-1">
                                <label for="name" class="text-[15px] text-gray-800">Full Name *</label>
                                <input type="text"
                                    class="w-full px-2 py-[3px] border border-slate-400 outline-none focus:!border-slate-700 rounded-sm"
                                    placeholder="Full name" value="{{ old('full_name') }}" name="full_name" />
                            </div>

                            <div class="w-full flex flex-col gap-1">
                                <label for="name" class="text-[15px] text-gray-800">Date of Birth *</label>
                                <input type="date"
                                    class="w-full px-2 py-[3px] border border-slate-400 outline-none focus:!border-slate-700 rounded-sm"
                                    value="{{ old('barth') }}" name="barth" />
                            </div>
                        </div>

                        <div class="flex justify-between items-center gap-2 md:gap-5">
                            <div class="w-full flex flex-col gap-1">
                                <label for="name" class="text-[15px] text-gray-800">Current Address</label>
                                <input type="text"
                                    class="w-full px-2 py-[3px] border border-slate-400 outline-none focus:!border-slate-700 rounded-sm"
                                    placeholder="Street address" value="{{ old('out_address') }}" name="out_address" />
                            </div>

                            <div class="w-full flex flex-col gap-1">
                                <label for="name" class="text-[15px] text-gray-800">Bangladesh Address</label>
                                <input type="text"
                                    class="w-full px-2 py-[3px] border border-slate-400 outline-none focus:!border-slate-700 rounded-sm"
                                    placeholder="Apartment/unit etc" value="{{ old('bd_address') }}" name="bd_address" />
                            </div>
                        </div>

                        <div class="flex justify-between items-center gap-2 md:gap-5">
                            <div class="w-full flex flex-col gap-1">
                                <label for="name" class="text-[15px] text-gray-800">Phone number</label>
                                <input type="number"
                                    class="w-full px-2 py-[3px] border border-slate-400 outline-none focus:!border-slate-700 rounded-sm"
                                    placeholder="Your current phone number" value="{{ old('out_cunt_num') }}" name="out_cunt_num" />
                            </div>

                            <div class="w-full flex flex-col gap-1">
                                <label for="name" class="text-[15px] text-gray-800">BD Phone number</label>
                                <input type="number"
                                    class="w-full px-2 py-[3px] border border-slate-400 outline-none focus:!border-slate-700 rounded-sm"
                                    placeholder="Your bangladesh phone number" value="{{ old('bd_number') }}" name="bd_number" />
                            </div>
                        </div>

                        <div class="flex justify-between items-center gap-2 md:gap-5">
                            <div class="w-full flex flex-col gap-1">
                                <label for="name" class="text-[15px] text-gray-800">City</label>
                                <input type="text"
                                    class="w-full px-2 py-[3px] border border-slate-400 outline-none focus:!border-slate-700 rounded-sm"
                                    placeholder="City" value="{{ old('city') }}" name="city" />
                            </div>

                            <div class="w-full flex flex-col gap-1" class="select">
                                <label for="name" class="text-[15px] text-gray-800">State</label>
                                <input type="text"
                                    class="w-full px-2 py-[3px] border border-slate-400 outline-none focus:!border-slate-700 rounded-sm"
                                    placeholder="State" value="{{ old('state') }}" name="state" />
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row justify-between items-center gap-2 md:gap-5">
                            <div class="w-full flex flex-col gap-1">
                                <label for="name" class="text-[15px] text-gray-800">Zipcode</label>
                                <input type="number"
                                    class="w-full px-2 py-[3px] border border-slate-400 outline-none focus:!border-slate-700 rounded-sm"
                                    placeholder="Zip code" value="{{ old('zip_code') }}" name="zip_code" />
                            </div>

                            <div class="w-full flex flex-col gap-1">
                                <label for="passport" class="text-[15px] text-gray-800">Upload passport</label>
                                <input type="file"
                                    class="w-full px-2 py-[3px] border border-slate-400 outline-none focus:!border-slate-700 rounded-sm"
                                    name="passport" />
                            </div>
                        </div>

                        {{-- <div class="flex flex-col sm:flex-row justify-between items-center gap-2 md:gap-5">
                        <div class="w-full flex flex-col gap-1">
                            <label for="name" class="text-[15px] text-gray-800">Username</label>
                            <input type="text"
                                class="w-full px-2 py-[3px] border border-slate-400 outline-none focus:!border-slate-700 rounded-sm"
                                placeholder="Your username" value="{{ old('name') }}" name="name" />
                        </div>

                        <div class="w-full flex flex-col gap-1">
                            <label for="name" class="text-[15px] text-gray-800">Email</label>
                            <input type="text"
                                class="w-full px-2 py-[3px] border border-slate-400 outline-none focus:!border-slate-700 rounded-sm"
                                placeholder="Your Email" value="{{ old('name') }}" name="name" />
                        </div>
                    </div> --}}

                        <button class="btn-outline mt-4">Continue</button>
                    </form>
            @endif
        </div>
        </div>

    </main>
@endsection
@section('customJs')
    <script>
        $(document).ready(function() {
            $('#travelForm').submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: '{{ route('traveler.store') }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
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
                        if (xhr.status === 422) {
                            // Validation errors
                            var errors = xhr.responseJSON.errors;
                            handleValidationErrors(errors);
                        } else {
                            Swal.fire({
                                title: 'Failed',
                                text: 'Something went wrong',
                                icon: 'error',
                                confirmButtonText: 'Confirm'
                            });
                        }

                    }
                });

            });

            function handleValidationErrors(errors) {
                // Clear previous validation errors
                $('.validation-error').remove();

                // Display validation errors
                $.each(errors, function(field, messages) {
                    var input = $('[name="' + field + '"]');
                    input.after('<div class="validation-error text-red-500">' + messages.join('<br>') +
                        '</div>');
                });
            }
        });
    </script>
@endsection
