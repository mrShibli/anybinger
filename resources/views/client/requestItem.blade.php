@extends('client.layouts.app')

@section('headers')
    <title>Request for items</title>
@endsection

@section('contents')
    <main class="w-full max-w-[1400px] mx-auto px-3 sm:px-6 md:px-8">
        <div class="w-full md:w-[600px] mx-auto mt-5">
            <h2 class="text-[28px] text-center font-medium text-gray-700 mb-4 mt-2">
                Request for a product
            </h2>
            <div class="flex flex-col gap-4">
                <form id="requestForm"
                    class="w-[96%] sm:w-[90%] md:w-[400px] flex flex-col p-6 mx-auto mt-4 gap-2 border border-gray-200 shadow-md rounded-md bg-white">
                    <div class="w-full flex flex-col gap-2">
                        <label for="name" class="text-[15px] text-gray-800">Item link from US or UK based online
                            stores</label>
                        @if (empty($productUrl))
                            <input type="text" name="url" class="input !border-gray-400 focus:!border-slate-600"
                                placeholder="Enter your product url from usa uk-based store">
                        @else
                            <input type="text" name="url" value="{{ $productUrl }}" hidden>
                            <div id="linkPreview">

                                <p class="text-[15px]" style="word-wrap: break-word">{{ $productUrl }}</p>
                                <span class="text-[14px]"><b>Preview:</b> <a href="{{ $productUrl }}" target="_blank"
                                        class="hover:underline">View your product</a></span>
                            </div>
                        @endif

                    </div>

                    <div class="flex flex-col justify-center items-center gap-4">
                        <div class="w-full flex flex-col gap-1">
                            <label for="name" class="text-[15px] text-gray-800">Add a note</label>

                            <textarea name="notes" id="" class="textarea h-[120px] !border-gray-400 focus:!border-slate-600"
                                placeholder="Describe something about product. example: size,color or anything"></textarea>
                        </div>

                        <div class="w-full flex flex-col gap-1">
                            <label for="name" class="text-[15px] text-gray-800">Your Phone Number</label>
                            <input type="number" name="number" class="input !border-gray-400 focus:!border-slate-600"
                                placeholder="Enter your phone number">
                        </div>

                        <div class="w-full flex justify-between items-center">
                            <span class="text-[15px] font-medium text-gray-600">Quantity</span>

                            <div class="flex justify-between items-center">
                                <button type="button"
                                    class="flex-center border border-orange-dark rounded-sm w-[22px] h-[22px]"
                                    id="decrementBtn">
                                    <i class="fa-solid fa-minus text-[11px]"></i>
                                </button>
                                <button class="text-[13px] font-medium px-2" id="qtyValue" value="1" disabled>
                                    1
                                </button>
                                <button type="button"
                                    class="flex-center border border-orange-dark rounded-sm w-[22px] h-[22px]"
                                    id="incrementBtn">
                                    <i class="fa-solid fa-plus text-[11px]"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button class="btn-outline mt-2 !text-[13px]" id="requestBtn" type="submit">
                        Continue
                    </button>
                </form>

                <a href="" class="text-[14px] text-blue-dark hover:underline mx-auto mt-4">Learn how to request for a
                    product</a>
            </div>
        </div>
    </main>
@endsection

@section('customJs')
    <script>
        const incrementBtn = document.getElementById("incrementBtn");
        const decrementBtn = document.getElementById("decrementBtn");
        const qtyValue = document.getElementById("qtyValue");

        incrementBtn.addEventListener("click", function() {
            // if (qtyValue.value < 10) {
            qtyValue.value = parseInt(qtyValue.value, 10) + 1;
            qtyValue.innerText = qtyValue.value;
            // } else {
            //     alert("can't order more than 10 item");
            // }
        });

        decrementBtn.addEventListener("click", function() {
            if (qtyValue.value != 1) {
                qtyValue.value = parseInt(qtyValue.value, 10) - 1;
                qtyValue.innerText = qtyValue.value;
            }
        });
    </script>

    <script>
        $('#requestForm').on('submit', function(e) {
            e.preventDefault();

            var formData = {};
            $.each($(this).serializeArray(), function(index, field) {
                formData[field.name] = field.value;
            });
            formData['qty'] = $('#qtyValue').val();

            $('#requestBtn').prop('disabled', true);
            $.ajax({
                url: "{{ route('saveRequestProduct') }}",
                type: 'post',
                data: formData,
                success: function(response) {
                    $('#requestBtn').prop('disabled', false);

                    if (response.status == true) {
                        swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            confirmButtonText: 'view requests',
                            preConfirm: (() => {
                                window.location.href =
                                "{{ route('account.requests') }}";
                            })
                        })
                    } else {
                        swal.fire({
                            icon: 'warning',
                            title: 'Warning',
                            text: response.errors,
                            confirmButtonText: 'Confirm'
                        })
                    }
                },
                error: function() {
                    swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong',
                        confirmButtonText: 'Confirm',
                    })
                }
            });
        });
    </script>
@endsection
