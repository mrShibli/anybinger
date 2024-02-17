@extends('dashboard.layouts.app')
@section('contents')
    @include('dashboard.layouts.sidebar')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row ">
                    <div class="col-sm-12">
                        <form id="ProductForm" class="card">
                            <div class="card-header d-flex justify-content-between align-items-center mb-2">
                                <h4>Update product</h4>

                                <a href="{{ route('products.index') }}" class="btn btn-primary">Back</a>
                            </div>
                            <div class="card-body">
                                <div class="form-group row mb-4">
                                    <div class="col-sm-12 col-md-6">
                                        <label class="col-form-label ">Title</label>
                                        <input type="text" id="title" value="{{ $product->title }}" name="title"
                                            class="form-control">
                                        <p class="text-danger d-none" id="errText"></p>
                                    </div>

                                    <div class="col-sm-12 col-md-4">

                                        <label class="col-form-label">Category</label>
                                        <select class="form-control selectric" id="categories" name="category_id">
                                            <option value="" id="categoryInitial">Select a category</option>
                                            @if ($categories->isNotEmpty())
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>

                                        <div id="category_id" class="d-none"></div>
                                        <p class="text-danger d-none" id="errText"></p>

                                    </div>

                                    <div class="col-sm-12 col-md-4">
                                        <label class="col-form-label">Sub Category</label>
                                        <select class="form-control selectric" id="subcategory_id" name="subcategory_id">
                                            <option value="">Select a Subcategory</option>

                                        </select>
                                        <p class="text-danger d-none" id="errText"></p>

                                    </div>

                                    <div class="col-sm-12 col-md-4">
                                        <label class="col-form-label">Brand</label>
                                        <select class="form-control selectric" name="brand_id">
                                            <option value="">Select a brand</option>
                                            @if ($brands->isNotEmpty())
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}"
                                                        {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                                        {{ $brand->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 col-md-2">
                                        <label class="col-form-label">Price</label>
                                        <input type="number" id="price" value="{{ $product->price }}" name="price"
                                            class="form-control ">
                                        <p class="text-danger d-none" id="errText"></p>
                                    </div>
                                    <div class="col-sm-6 col-md-2">
                                        <label class="col-form-label">Compare Price</label>
                                        <input type="number" id="compare_price" value="{{ $product->compare_price }}"
                                            name="compare_price" class="form-control">
                                    </div>

                                    <div class="col-sm-12 col-md-3 mt-2">
                                        <input type="hidden" name="track_quantity" value="No">
                                        <input type="checkbox" name="track_quantity" value="Yes"
                                            class="form-check-input ml-2" id="track_quantity"
                                            {{ $product->track_quantity == 'Yes' ? 'checked' : '' }}>
                                        <label class="form-check-label ml-4 mb-1" for="track_quantity">Track
                                            Quantity</label>
                                        <input type="number" id="quantity"
                                            value="{{ $product->quantity ?? $product->quantity }}" name="quantity"
                                            class="form-control">
                                        <p class="text-danger d-none" id="errText"></p>

                                    </div>


                                    <div class="col-sm-12 col-md-3">
                                        <label class="col-form-label">Status</label>
                                        <select class="form-control selectric" id="status" name="status">
                                            <option value="pending" {{ $product->status == 'pending' ? 'selected' : '' }}>
                                                Pending</option>
                                            <option value="published"
                                                {{ $product->status == 'published' ? 'selected' : '' }}>Published</option>
                                        </select>
                                        <p class="text-danger d-none" id="errText"></p>
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 col-md-8">
                                        <label class="col-form-label">Short Description</label>
                                        <textarea class="form-control" id="short_description"  style="height: 180px !important" name="short_description">{{ $product->short_description }}</textarea>
                                        <p class="text-danger d-none" id="errText"></p>

                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <div class="col-sm-12 col-md-12">
                                        <label class="col-form-label">Description</label>
                                        <textarea class="" id="descriptions" name="descriptions">{{ $product->description }}</textarea>
                                        <p class="text-danger d-none" id="errText"></p>

                                    </div>
                                </div>


                            </div>
                            <div class="form-group row m-l-4">
                                <div class="col-sm-12 ">
                                    <div class="card-header d-flex justify-content-between align mb-1">
                                        <h4>Product Images</h4>
                                        <a href="https://cloudconvert.com/" target="_blank">Compress image to webp
                                            format</a>
                                    </div>
                                    <div class="card-body mt-2">
                                        <div class="dropzone" id="mydropzone">
                                            <div class="fallback">
                                                <input id="" name="file" type="file" multiple />
                                            </div>
                                        </div>
                                        <div id="productImages"
                                            class="d-flex flex-wrap align-items-center justify-content-start mt-4">
                                            @if ($product->productImage->isNotEmpty())
                                                @php
                                                    $productImage = $product->productImage;
                                                @endphp

                                                @foreach ($productImage as $image)
                                                    <div class="d-flex flex-column px-2" id="image-{{ $image->id }}">
                                                        <input type="text" value="${response.imageId}" hidden>
                                                        <img src="{{ asset('/uploads/products/' . $image->name) }}"
                                                            alt="" class="rounded"
                                                            style="width: 140px; max-height: 100px: ">
                                                        <button type="button"
                                                            onclick="deleteProductImage({{ $image->id }})"
                                                            class="btn btn-danger px-2 py-1 mt-2">Delete</button>
                                                    </div>
                                                @endforeach
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="ml-2">
                                            <div class="card-header">
                                                <h4>Seo Inputs</h4>
                                            </div>
                                            <div class="col-sm-12 col-md-8">
                                                <label class="col-form-label">Tag</label>
                                                <div class="u-tagsinput w-full">
                                                    <input id="tags" name="tags" value="{{ $product->tags }}"
                                                        type="text" data-role="tagsinput">
                                                    <p class="text-danger d-none" id="errText"></p>
                                                </div>


                                            </div>

                                            <div class="col-sm-8 col-md-8">
                                                <label class="col-form-label">Meta Keyword</label>
                                                <input type="text" id="meta_keyword"
                                                    value="{{ $product->meta_keyword }}" name="meta_keyword"
                                                    class="form-control">
                                                <p class="text-danger d-none" id="errText"></p>

                                            </div>
                                            <div class="col-sm-12 col-md-8">
                                                <label class="col-form-label">Meta Description</label>
                                                <textarea class="form-control" id="meta_description" name="meta_description" style="height: 100px !important">{{ $product->meta_description }}</textarea>
                                                <p class="text-danger d-none" id="errText"></p>

                                            </div>
                                        </div>
                                        <div class="form-group row mt-4 ml-4">
                                            <button class="btn btn-primary" type="submit">Update Product</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </div>
@endsection

@section('customJs')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

    <!-- JS Libraies -->
    <script src="/dashboard/assets/bundles/jquery-selectric/jquery.selectric.min.js"></script>
    <script src="/dashboard/assets/bundles/upload-preview/assets/js/jquery.uploadPreview.min.js"></script>
    <script src="/dashboard/assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <!-- Page Specific JS File -->
    <script src="/dashboard/assets/js/page/create-post.js"></script>
    <script src="https://cdn.tiny.cloud/1/h2axwpnzfh7k1agff20oqbrdvqd0hpov0jv1oc3q8gb14mqi/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>

    <script>
        tinymce.init({
            selector: '#descriptions',
            plugins: 'lists link image',
            toolbar: "undo redo | blocks | bold italic | alignleft aligncenter alignright alignjustify | outdent indent",
            height: 500
        });


        function updatesubcategory() {

            var category_id = $('#categories').val();
            $.ajax({
                url: "{{ route('products.subcategory') }}",
                type: 'get',
                data: {
                    id: category_id
                },
                success: function(response) {
                    var subcategorySelect = $('#subcategory_id');
                    subcategorySelect.html('<option value="" >Select a Subcategory</option>');

                    if (response.status == true) {
                        var subcategories = response.subcategory;
                        if (subcategories.length > 0) {
                            $.each(subcategories, function(index, subcategory) {
                                var isSelected = subcategory.id == "{{ $product->subcategory_id }}" ?
                                    'selected' : '';
                                subcategorySelect.append(
                                    `<option value="${subcategory.id}" ${isSelected}>${subcategory.name}</option>`
                                );
                            });

                            subcategorySelect.selectric('refresh');
                        } else {
                            subcategorySelect.html(`<option value="">No Subcategory found</option>`);
                        }
                    } else {
                        subcategorySelect.html(`<option value="">No Subcategory found</option>`);
                        // Swal.fire({
                        //     icon: 'warning',
                        //     title: 'warning',
                        //     text: 'Something went wrong or Category deleted',
                        //     showCancelButton: false,
                        // });
                    }
                    subcategorySelect.selectric('refresh');
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            })
        }

        $(document).ready(function() {
            updatesubcategory();

            $('#categories').on('change', updatesubcategory);
        });
    </script>

    <script>
        function deleteProductImage(id) {

            $.ajax({
                url: "{{ route('products.deleteProductImage') }}",
                type: 'post',
                data: {
                    id: id
                },
                success: function(response) {
                    if (response.status == true) {
                        $('#image-' + id).removeClass('d-flex');
                        $('#image-' + id).addClass('d-none');
                    } else {
                        $('#image-' + id).removeClass('d-flex');
                        $('#image-' + id).addClass('d-none');

                        Swal.fire({
                            icon: 'error',
                            title: 'An error occurd',
                            text: response.errors,
                            showCancelButton: false,
                        });
                    }
                }
            })
        }

        Dropzone.autoDiscover = false;
        var dropzonee = $("#mydropzone").dropzone({

            url: "{{ route('products.tempImage') }}",
            maxFiles: 4,
            paramName: 'image',
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(file, response) {

                if (response.status == true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'success',
                        text: response.message,
                        showCancelButton: false,
                        timer: 800
                    });

                    var image = `<div  class="d-flex flex-column px-2" id="image-row-${response.imageId}">
                                    <input type="text" name="image_array[]" value="${response.imageId}" hidden>
                                    <img src="${response.imagePath}" alt="" class="rounded" style="width: 140px; max-height: 100px: ">
                                    <button type="button" onclick="deleteImage(${response.imageId})" class="btn btn-danger px-2 py-1 mt-2">Delete</button>
                                </div>`;

                    $('#productImages').append(image);
                }

                if (response.status == false) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'warning',
                        text: response.errors,
                        showCancelButton: false,
                    });
                }
            },
            complete: function(file) {
                this.removeFile(file);
            },
            error: function(error) {
                Swal.fire({
                    icon: 'error',
                    title: 'An error occurd',
                    text: 'Something went wrong, try again',
                    showCancelButton: false,
                });
            }
        });


        function deleteImage(id) {
            $('#image-row-' + id).removeClass('d-flex');
            $('#image-row-' + id).addClass('d-none');
        }
    </script>

    <script>
        $('document').ready(function() {
            $('#ProductForm').submit(function(e) {
                e.preventDefault();
                tinymce.triggerSave();
                var formArray = $(this).serializeArray();
                $('button[type=submit]').prop('disabled', true);

                $.ajax({
                    url: "{{ route('products.update', $product->id) }}",
                    type: 'put',
                    data: formArray,
                    success: function(response) {
                        $('button[type=submit]').prop('disabled', false);

                        var errText = $('#errText');
                        if (!errText.hasClass('d-none')) {
                            errText.addClass('d-none');
                        }

                        if (response.status == false) {
                            var errors = response.errors;
                            $.each(errors, function(key, value) {
                                $(`#${key}`).siblings('p')
                                    .removeClass('d-none')
                                    .html(value);
                            });

                            Swal.fire({
                                icon: 'warning',
                                title: 'warning',
                                text: 'Please fill all the required fields',
                                showCancelButton: false,
                            });
                        } else if (response.status == true) {
                            Swal.fire({
                                icon: 'success',
                                title: 'success',
                                text: 'Product updated successfully 🎉',
                                showCancelButton: false,
                                preConfirm: () => {
                                    window.location.href =
                                        "{{ route('products.index') }}";
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'An error occurd',
                                text: 'Something went wrong , try again later',
                                showCancelButton: false,
                            });
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
        });
    </script>
@endsection
