@extends('layouts.admin')

@section('title')
    Heart Daily | Product Edit
@endsection

@section('css')
    <style>
        .dz-image img {
            display: block;
            /* Hoặc thử display: inline-block; */
            max-width: 100%;
            /* Để đảm bảo ảnh không quá lớn */
            height: auto;
            /* Để ảnh tự động điều chỉnh chiều cao */
        }

        /* Thay đổi màu nền cho các tùy chọn disabled */
        select option:disabled {
            background-color: #f0f0f0;
            /* Màu nền xám */
            color: #999;
            /* Màu chữ xám */
        }
    </style>
@endsection

@section('section')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Products</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card bg-light">
                        <div class="card-header bg-white">
                            <h4>Edit Product</h4>
                        </div>
                        <div class="card-body">
                            <form id="add-form-product" action="{{ route('admin.products.update', $product->id) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="card">
                                            <div class="card-body">
                                                <ul class="nav nav-pills" id="productTab" role="tablist">
                                                    <li class="nav-item mr-1">
                                                        <a class="nav-link active" id="product-info-tab" data-toggle="tab"
                                                            href="#product-info" role="tab" aria-controls="product-info"
                                                            aria-selected="true">Thông tin chung</a>
                                                    </li>
                                                    <li class="nav-item mr-1">
                                                        <a class="nav-link" id="product-variants-tab" data-toggle="tab"
                                                            href="#product-variants" role="tab"
                                                            aria-controls="product-variants" aria-selected="false">Dữ liệu
                                                            sản
                                                            phẩm</a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content" id="productTabContent">
                                                    <div class="tab-pane fade show active" id="product-info" role="tabpanel"
                                                        aria-labelledby="product-info-tab">
                                                        <div class="form-group">
                                                            <label for="">Name</label>
                                                            <input type="text" name="name"
                                                                value="{{ $product->name }}" class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Sku</label>
                                                            <input type="text" name="sku" value="{{ $product->sku }}"
                                                                class="form-control">
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Price</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text"
                                                                                id="discount-unit">
                                                                                đ
                                                                            </div>
                                                                        </div>
                                                                        <input type="number" name="price"
                                                                            value="{{ $product->price }}"
                                                                            class="form-control currency">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Offer Price</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text"
                                                                                id="discount-unit">
                                                                                đ
                                                                            </div>
                                                                        </div>
                                                                        <input type="number" name="offer_price"
                                                                            value="{{ $product->offer_price }}"
                                                                            class="form-control currency">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Offer Start Date</label>
                                                                    <input type="text" name="offer_start_date"
                                                                        value="{{ $product->offer_start_date }}"
                                                                        class="form-control datepicker">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Offer End Date</label>
                                                                    <input type="text" name="offer_end_date"
                                                                        value="{{ $product->offer_end_date }}"
                                                                        class="form-control datepicker">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Short Description</label>
                                                            <textarea name="short_description" class="form-control">{{ $product->short_description }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Long Description</label>
                                                            <textarea name="long_description" class="form-control summernote">{{ $product->long_description }}</textarea>
                                                        </div>
                                                        <div class="form-group ">
                                                            <label for="inputState">Status</label>
                                                            <select id="inputState" name="status" class="form-control">
                                                                <option {{ $product->status == 1 ? 'selected' : '' }}
                                                                    value="1">Active</option>
                                                                <option {{ $product->status == 0 ? 'selected' : '' }}
                                                                    value="0">Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="product-variants" role="tabpanel"
                                                        aria-labelledby="product-variants-tab">
                                                        <!-- Nội dung về các biến thể của sản phẩm -->
                                                        <div id="check_type">
                                                            <div class="form-group ">
                                                                <label for="inputState">Type Product</label>
                                                                <select id="select_type" name="type_product"
                                                                    class="form-control">
                                                                    <option value="" hidden>--Select--</option>
                                                                    <option
                                                                        {{ $product->type_product === 'product_simple' ? 'selected' : '' }}
                                                                        value="product_simple">Sản phẩm đơn giản
                                                                    </option>
                                                                    <option
                                                                        {{ $product->type_product === 'product_variant' ? 'selected' : '' }}
                                                                        value="product_variant">Sản phẩm biến thể
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div id="div-simple" style="display: none">
                                                            <div id="stock-quantity-group" class="form-group">
                                                                <label for="">Stock Quantity</label>
                                                                <input type="number" min="0" id="stock-quantity"
                                                                    name="qty" value="{{ $product->qty }}"
                                                                    class="form-control">
                                                            </div>
                                                        </div>

                                                        <div id="div-variant" style="display: none">
                                                            <button class="btn btn-light mt-2 btn-add-product-variant"><i
                                                                    class="fas fa-plus">
                                                                    Add product variant</i></button>
                                                            <hr>
                                                            @foreach ($product->ProductVariants as $key => $variant)
                                                                @php
                                                                    $attributes = json_decode(
                                                                        $variant->id_variant,
                                                                        true,
                                                                    );

                                                                    $categoryAttributeCount = \App\Models\CategoryAttribute::query()->count();
                                                                @endphp
                                                                <div class="mb-3 variant-group"
                                                                    data-variant-index="{{ $key + 1 }}">
                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center">
                                                                        <h5>Biến thể {{ $key + 1 }}</h5>
                                                                        <a class="btn btn-danger btn-remove-variant-group"
                                                                            href="{{ route('admin.products.destroy-variant', $variant->id) }}">Remove</a>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="">Quantity</label>
                                                                        <input type="number" value="{{ $variant->qty }}"
                                                                            name="variant[{{ $key + 1 }}][qty]"
                                                                            class="form-control">
                                                                        <input type="text" hidden
                                                                            value="{{ $variant->id }}"
                                                                            name="variant[{{ $key + 1 }}][id_product_variant]">
                                                                    </div>

                                                                    @if (count($attributes) < $categoryAttributeCount)
                                                                        <button
                                                                            class="btn btn-light mb-3 btn-add-variant"><i
                                                                                class="fas fa-plus"> Add
                                                                                variant</i></button>
                                                                    @else
                                                                        <button class="btn btn-light mb-3 btn-add-variant"
                                                                            style="display: none;"><i class="fas fa-plus">
                                                                                Add
                                                                                variant</i></button>
                                                                    @endif

                                                                    <div class="variant-attributes">
                                                                        @foreach ($attributes as $attribute)
                                                                            @php
                                                                                $categoryAttributeId = \App\Models\Attribute::query()
                                                                                    ->where('id', $attribute)
                                                                                    ->pluck('category_attribute_id')
                                                                                    ->first();
                                                                                $attributes = \App\Models\Attribute::query()
                                                                                    ->where(
                                                                                        'category_attribute_id',
                                                                                        $categoryAttributeId,
                                                                                    )
                                                                                    ->get();
                                                                            @endphp
                                                                            <div class="row variant-row">
                                                                                <div class="form-group col-5">
                                                                                    <label for="inputState">Variant</label>
                                                                                    <select
                                                                                        class="form-control variant-select"
                                                                                        name="variant[{{ $key + 1 }}][variant_id][]">
                                                                                        <option value="" hidden>
                                                                                            --Chọn
                                                                                            Variant--
                                                                                        </option>
                                                                                        @foreach ($categoryAttributes as $categoryAttribute)
                                                                                            <option
                                                                                                {{ $categoryAttributeId == $categoryAttribute->id ? 'selected' : '' }}
                                                                                                value="{{ $categoryAttribute->id }}">
                                                                                                {{ $categoryAttribute->title }}
                                                                                            </option>
                                                                                        @endforeach

                                                                                    </select>
                                                                                </div>

                                                                                <div class="form-group col-5">
                                                                                    <label for="inputState">Value
                                                                                        Variant</label>
                                                                                    <select
                                                                                        class="form-control value-select"
                                                                                        name="variant[{{ $key + 1 }}][value_id][]">
                                                                                        <option value="" hidden>
                                                                                            --Chọn
                                                                                            Value--
                                                                                        </option>
                                                                                        @foreach ($attributes as $item)
                                                                                            <option
                                                                                                {{ $attribute == $item->id ? 'selected' : '' }}
                                                                                                value="{{ $item->id }}">
                                                                                                {{ $item->title }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <div
                                                                                    class="form-group col-2 d-flex align-items-end">
                                                                                    <button
                                                                                        class="btn btn-danger btn-remove-variant"
                                                                                        style="height:42px"><i
                                                                                            class="fas fa-trash"></i></button>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                    <hr>
                                                                </div>
                                                            @endforeach

                                                        </div>

                                                    </div>
                                                </div>
                                                <button class="btn btn-primary" type="submit">Create</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="inputState">Category</label>
                                                    <select id="inputState" name="category_id"
                                                        class="form-control main-category">
                                                        <option value="" hidden>Select</option>
                                                        @foreach ($categories as $category)
                                                            <option
                                                                {{ $product->category_id === $category->id ? 'selected' : '' }}
                                                                value="{{ $category->id }}">{{ $category->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="inputState">Brand</label>
                                                    <select id="inputState" name="brand_id" class="form-control">
                                                        <option value="" hidden>Select</option>
                                                        @foreach ($brands as $brand)
                                                            <option
                                                                {{ $product->brand_id === $brand->id ? 'selected' : '' }}
                                                                value="{{ $brand->id }}">{{ $brand->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Box tách riêng cho Custom Field -->
                                        <div class="card mt-3"> <!-- Dùng lớp mt-3 để tạo khoảng cách phía trên -->
                                            <div class="card-body">
                                                <!-- Custom Field -->
                                                <div class="form-group">
                                                    <label for="customField">Image Main</label>
                                                    <!-- Hình ảnh đại diện -->
                                                    <div class="image-placeholder"
                                                        style="width: 100%; height: 300px; background-color: #e9ecef; display: flex; justify-content: center; align-items: center;">
                                                        <img id="previewImage"
                                                            src="{{ $product->image ? Storage::url($product->image) : asset('admin/assets/img/news/img01.jpg') }}"
                                                            alt="Ảnh đại diện"
                                                            style="max-width: 100%; max-height: 100%;" />
                                                    </div>

                                                    <!-- Nút Upload và Select -->
                                                    <div class="d-flex justify-content-around mt-3">
                                                        <input type="file" id="imageUpload" name="image_main"
                                                            class="d-none" accept="image/*">
                                                        <button class="btn btn-dark" id="uploadBtn">Upload
                                                            file...</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card mt-3">
                                            <div class="card-header">
                                                <h4>Multiple Upload <code>(Max 5 Picture)</code></h4>
                                            </div>
                                            <div class="card-body">
                                                <div style="border: 2px dashed #6777ef;" class="dropzone"
                                                    id="my-awesome-dropzone"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@push('scripts')
    <script>
        const existingImages = @json($product->ProductImageGalleries);
        console.log(existingImages);

        $(document).ready(function() {
            let maxVariants = 0;

            function getCategoryAttributeCount() {
                $.ajax({
                    url: "{{ route('admin.category_attributes.get-category-attributes') }}",
                    method: 'GET',
                    success: function(data) {
                        maxVariants = data.length;
                    },
                    error: function(error) {
                        console.log('Có lỗi khi lấy Category Attribute:', error);
                    }
                })

            }
            getCategoryAttributeCount();

            function checkAddVariantButton(group) {
                const currentGroup = $(group).closest('.variant-group');
                let currentVariants = currentGroup.find('.variant-row').length;
                console.log(currentVariants);

                if (currentVariants >= maxVariants) {
                    currentGroup.find('.btn-add-variant').hide();
                } else {
                    currentGroup.find('.btn-add-variant').show();
                }
            }

            function updateVariantIndices() {
                // Cập nhật lại chỉ số biến thể và các thuộc tính bên trong
                $('.variant-group').each(function(groupIndex) {
                    $(this).attr('data-variant-index', groupIndex + 1);
                    $(this).find('h5').text('Biến thể ' + (groupIndex +
                        1)); // Cập nhật lại tên nhóm biến thể

                    // Cập nhật lại các chỉ số cho variant attributes
                    $(this).find('.variant-row').each(function(attrIndex) {
                        $(this).find('.variant-select').attr('name', 'variant[' + (groupIndex + 1) +
                            '][variant_id][]');
                        $(this).find('.value-select').attr('name', 'variant[' + (groupIndex + 1) +
                            '][value_id][]');
                    });

                    // Cập nhật lại chỉ số của input quantity
                    $(this).find('input[type="number"]').attr('name', 'variant[' + (groupIndex + 1) +
                        '][qty]');
                });
            }


            function checkProductType() {
                var selectedType = $('#select_type').val();
                if (selectedType === 'product_simple') {
                    $('#div-simple').show();
                    $('#div-variant').hide();
                    $('#stock-quantity').removeAttr('disabled', true);
                    $('#div-variant').find('input, select').prop('disabled', true);
                } else if (selectedType === 'product_variant') {
                    if ($('.variant-group').length == 0) {
                        $('.btn-add-product-variant').click();
                        setTimeout(function() {
                            for (let i = 0; i < 2; i++) {
                                $('.btn-add-variant').click();
                            }
                        }, 500)
                    }
                    $('#div-simple').hide();
                    $('#div-variant').show();
                    $('#stock-quantity').attr('disabled', true);
                    $('#div-variant').find('input, select').prop('disabled', false);

                }
            }

            // On page load
            checkProductType();

            // On change of the select dropdown
            $('#select_type').change(function() {
                checkProductType();
            });

            let deletedImageIds = [];
            let currentFileCount = 0; // Biến đếm số lượng tệp đã thêm
            $("div#my-awesome-dropzone").dropzone({
                paramName: "album",
                url: "{{ route('admin.products.upload') }}",
                uploadMultiple: true,
                maxFilesize: 12,
                maxFiles: 10,
                acceptedFiles: 'image/*',
                parallelUploads: 10,
                autoProcessQueue: false,
                addRemoveLinks: true,
                headers: {
                    // Lấy giá trị CSRF token từ thẻ meta và gán vào header của yêu cầu
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                init: function() {
                    const dropzoneInstance = this;

                    // Hiển thị ảnh đã tồn tại
                    const existingImages = @json($product->ProductImageGalleries);
                    currentFileCount = existingImages.length;

                    existingImages.forEach(image => {
                        const mockFile = {
                            name: image.image.split('/').pop(), // Lấy tên file từ đường dẫn
                            size: 1234 // Bạn có thể đặt kích thước tạm thời (đơn vị byte)
                        };
                        dropzoneInstance.emit("addedfile", mockFile);
                        const imageUrl = "{{ Storage::url('') }}" + image.image;
                        dropzoneInstance.emit("thumbnail", mockFile, imageUrl);
                        dropzoneInstance.emit("complete", mockFile);
                        // Thêm thuộc tính data-image-id cho phần tử xóa để có thể lấy lại khi xóa
                        mockFile.previewElement.querySelector(".dz-remove").setAttribute(
                            "data-image-id", image.id);
                    });

                    this.on("removedfile", function(file) {
                        const imageId = file.previewElement.querySelector(".dz-remove")
                            .getAttribute("data-image-id");

                        if (imageId) {
                            deletedImageIds.push(imageId);
                            console.log("Đã xóa ảnh với ID: " + imageId);
                        }

                        if ($('.dz-preview').length === 0) {
                            $('.dz-default.dz-message').show();
                        } else {
                            $('.dz-default.dz-message').hide();
                        }
                    });

                    this.on("addedfile", file => {
                        const totalFiles = currentFileCount + dropzoneInstance.files.length;

                        if (totalFiles > 10) {
                            dropzoneInstance.removeFile(file);
                            toastr.error(
                                "Bạn chỉ được phép tải lên tối đa 10 tệp ảnh cho sản phẩm."
                            );
                        } else {
                            console.log("A file has been added: " + file.name);
                            $('.dz-default.dz-message').hide();
                        }
                        console.log("Total Files Count: " + totalFiles);
                    });

                    this.on("error", function(file, message) {
                        console.error("Error uploading file: " + file.name + ". Error: " +
                            message);
                    });

                    this.on("successmultiple", function(files, response) {
                        toastr.success("Upload ảnh thành công!");

                        // Chuyển hướng về trang danh sách sản phẩm sau khi upload ảnh thành công
                        setTimeout(function() {
                                window.location.href =
                                    "{{ route('admin.products.index') }}";
                            },
                            3000
                        ); // Đợi 1.5 giây trước khi chuyển hướng, bạn có thể thay đổi thời gian nếu muốn
                    });

                    dropzoneInstance.on("sending", function(file, xhr, formData) {
                        formData.append("product_id",
                            {{ $product->id }}); // Gửi product_id cùng với ảnh
                    });

                    // Sự kiện submit form
                    $('#add-form-product').on('submit', function(event) {
                        event.preventDefault(); // Ngăn submit mặc định

                        // Lấy dữ liệu từ form
                        var formData = new FormData(this);
                        formData.append('deletedImageIds', JSON.stringify(deletedImageIds));

                        // Gửi AJAX request để thêm sản phẩm
                        $.ajax({
                            url: "{{ route('admin.products.update', $product->id) }}",
                            method: 'POST',
                            data: formData,
                            contentType: false, // Không đặt contentType, để mặc định là false
                            processData: false, // Không xử lý dữ liệu, để dạng FormData
                            success: function(response) {
                                if (response.status == 'success') {
                                    toastr.success(response.message);

                                    if (dropzoneInstance.getQueuedFiles().length >
                                        0) {
                                        dropzoneInstance.processQueue();
                                    } else {
                                        setTimeout(function() {
                                            window.location.href =
                                                "{{ route('admin.products.index') }}";
                                        }, 1500);
                                    }

                                } else {
                                    toastr.error('Thêm sản phẩm thất bại!');
                                }
                            },
                            error: function(data) {
                                let errors = data.responseJSON.errors;
                                if (errors) {
                                    $.each(errors, function(key, value) {
                                        toastr.error(value);
                                    })
                                }
                            }
                        });
                    });
                }
            });

            $('#uploadBtn').on('click', function(event) {
                event.preventDefault(); // Ngăn việc submit form
                $('#imageUpload').click();
            });

            // Khi người dùng chọn file, hiển thị ảnh lên img Preview
            $('#imageUpload').on('change', function() {
                const files = $(this)[0].files;
                if (files.length > 0) {
                    const file = files[0];
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        $('#previewImage').attr('src', event.target.result);
                    }
                    reader.readAsDataURL(file);
                } else {
                    console.log("No file selected.");
                }
            })

            // Hàm để load danh sách variant từ server
            function loadCategoryAttribute(selectElement) {
                $.ajax({
                    url: "{{ route('admin.category_attributes.get-category-attributes') }}",
                    method: 'GET',
                    success: function(data) {
                        selectElement.empty();
                        selectElement.append('<option value="" hidden>Chọn Variant</option>');
                        $.each(data, function(key, value) {
                            selectElement.append('<option value="' + value.id +
                                '">' + value.title + '</option>')
                        });

                        // Sau khi load xong, cập nhật lại các dropdown trong nhóm hiện tại
                        var parentVariantGroup = selectElement.closest('.variant-group');
                        updateDisabledVariants(parentVariantGroup);
                    },
                })
            }

            // Xử lý khi nhấn nút "Add product variant"
            $('.btn-add-product-variant').click(function(e) {
                e.preventDefault();

                var variantIndex = $('.variant-group').length +
                    1; // Lấy số lượng hiện tại và tăng lên // Tăng biến đếm
                var newVariant = `
                <div class="mb-3 variant-group" data-variant-index="` + variantIndex + `">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Biến thể ` + variantIndex + `</h5>
                        <button class="btn btn-danger btn-remove-variant-group">Remove</button>
                    </div>
                    <div class="form-group">
                        <label for="">Quantity</label>
                        <input type="number" name="variant[` + variantIndex + `][qty]" class="form-control">
                    </div>
                    <button class="btn btn-light mb-3 btn-add-variant"><i class="fas fa-plus"> Add variant</i></button>
                <div class="variant-attributes"></div>
                <hr>
                </div>

                `;

                // Thêm nội dung biến thể mới vào tab "div-variant"
                $('#div-variant').append(newVariant);
            });

            // Xử lý khi nhấn nút "Add variant" để thêm thuộc tính cho biến thể
            $('#div-variant').on('click', '.btn-add-variant', function(e) {
                e.preventDefault();

                // Lấy chỉ số variant hiện tại từ thuộc tính data-variant-index
                var parentVariantGroup = $(this).closest('.variant-group');
                var currentVariantIndex = parentVariantGroup.data('variant-index');

                var variantAttributes = `
                    <div class="row variant-row">
                        <div class="form-group col-5">
                            <label for="inputState">Variant</label>
                            <select class="form-control variant-select" name="variant[` + currentVariantIndex + `][variant_id][]">
                                <option value="">Chọn Variant</option>
                            </select>
                        </div>
                        <div class="form-group col-5">
                            <label for="inputState">Value Variant</label>
                            <select class="form-control value-select" name="variant[` + currentVariantIndex + `][value_id][]">
                                <option value="">Chọn Value</option>
                            </select>
                        </div>
                        <div class="form-group col-2 d-flex align-items-end">
                            <button class="btn btn-danger btn-remove-variant" style="height:42px"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                `;

                // Thêm thuộc tính mới vào biến thể hiện tại
                var newVariantRow = $(variantAttributes).appendTo($(this).siblings('.variant-attributes'));

                // Load variants cho dropdown chỉ cho dòng vừa thêm
                var selectElement = newVariantRow.find('.variant-select');
                loadCategoryAttribute(selectElement);
                // Kiểm tra và ẩn nút "Add variant" nếu đạt giới hạn
                checkAddVariantButton(this);
            });

            // Khi trang được load, cập nhật các dropdown trong từng nhóm biến thể
            $('.variant-group').each(function() {
                checkDisabledVariants($(this));
            });

            function checkDisabledVariants(variantGroup) {
                let selectedValues = [];

                // Lấy tất cả các giá trị đã được chọn trong nhóm hiện tại
                variantGroup.find('.variant-select').each(function() {
                    let selectedOption = $(this).val();
                    if (selectedOption) {
                        selectedValues.push(selectedOption);
                    }
                });

                // Ẩn các option đã chọn trong các select còn lại
                variantGroup.find('.variant-select').each(function() {
                    $(this).find('option').each(function() {
                        if (selectedValues.includes($(this).val()) && !$(this).is(':selected')) {
                            $(this).attr('disabled', true); // Ẩn option nếu nó đã được chọn
                        } else {
                            $(this).attr('disabled',
                                false); // Hiển thị lại option nếu nó không được chọn
                        }
                    });
                });
            }

            // Hàm để disable các variants đã được chọn trước đó, chỉ trong nhóm hiện tại
            function updateDisabledVariants(variantGroup) {
                // Lưu trữ các variant đã chọn trong nhóm hiện tại
                var selectedVariants = [];

                // Chỉ tìm các `variant-select` trong nhóm hiện tại
                variantGroup.find('.variant-select').each(function() {
                    var selectedValue = $(this).val();
                    if (selectedValue) {
                        selectedVariants.push(selectedValue);
                    }
                });

                // Duyệt lại qua các `variant-select` trong nhóm hiện tại
                variantGroup.find('.variant-select').each(function() {
                    var currentSelect = $(this);
                    var currentValue = currentSelect.val();

                    currentSelect.find('option').each(function() {
                        var optionValue = $(this).val();

                        // Disable nếu option đã được chọn và không phải là option đang được chọn trong dropdown hiện tại
                        if (optionValue !== '' && selectedVariants.includes(optionValue) &&
                            optionValue !== currentValue) {
                            $(this).attr('disabled', true); // Disable option
                        } else {
                            $(this).attr('disabled', false); // Enable lại option chưa được chọn
                        }
                    });
                });
            }


            // Hàm update các tùy chọn không trùng lặp cho một dòng cụ thể
            function updateVariantAttributes(currentRow) {
                // Lấy nhóm `variant-attributes` chứa dòng hiện tại
                var currentAttributeGroup = currentRow.closest('.variant-attributes');

                // Lưu trữ tất cả các giá trị đã được chọn trong nhóm này (màu sắc, kích thước, ...)
                var selectedVariants = [];

                // Duyệt qua từng nhóm biến thể (variant-select) trong cùng nhóm variant-attributes
                currentAttributeGroup.find('.variant-select').each(function() {
                    var selectedValue = $(this).val();
                    if (selectedValue) {
                        selectedVariants.push(selectedValue);
                    }
                });

                // Duyệt lại qua tất cả các `variant-select` trong nhóm và vô hiệu hóa các tùy chọn đã chọn ở dòng khác
                currentAttributeGroup.find('.variant-select').each(function() {
                    var currentSelect = $(this);
                    var currentValue = currentSelect.val();

                    currentSelect.find('option').each(function() {
                        var optionValue = $(this).val();

                        // Kiểm tra xem giá trị này có đang được chọn ở dòng khác hay không
                        if (optionValue !== '' && selectedVariants.includes(optionValue) &&
                            optionValue !== currentValue) {
                            $(this).attr('disabled',
                                true); // Disable nếu đã được chọn ở select khác
                        } else {
                            $(this).attr('disabled', false); // Enable lại nếu không bị chọn
                        }
                    });
                });
            }

            // Xử lý khi chọn một variant từ dropdown
            $('#div-variant').on('change', '.variant-select', function() {
                var variantId = $(this).val();
                var variantContainer = $(this).closest('.variant-row');
                var valueSelect = variantContainer.find('.value-select');
                // Sau khi chọn một variant, gọi hàm update để kiểm tra và disable các giá trị trùng lặp
                updateVariantAttributes(variantContainer);
                if (variantId) {
                    $.ajax({
                        url: "{{ route('admin.attributes.get-attributes', ':variantId') }}"
                            .replace(':variantId', variantId),
                        type: 'GET',
                        success: function(data) {
                            // Xử lý đổ dữ liệu vào valueSelect
                            valueSelect.empty(); // Xóa các phần tử trong valueSelect
                            valueSelect.append('<option value="" hidden>Chọn Value</option>');
                            $.each(data, function(index, value) {
                                valueSelect.append('<option value="' + value.id + '">' +
                                    value.title + '</option>');
                            });

                            // Sau khi cập nhật options, chỉ cập nhật biến thể hiện tại
                            updateVariantAttributes(variantContainer);
                        },
                    })
                }
            })

            // Xử lý khi nhấn nút "Remove" để xóa thuộc tính variant
            $('#div-variant').on('click', '.btn-remove-variant', function(e) {
                e.preventDefault();
                let currentGroup = $(this).closest('.variant-group');
                let currentVariants = currentGroup.find('.variant-row').length;
                if (currentVariants == maxVariants) {
                    currentGroup.find('.btn-add-variant').show();
                }
                $(this).closest('.variant-row').remove(); // Xóa dòng thuộc tính chứa nút remove
            });

            // Xử lý khi nhấn nút "Remove Variant" để xóa toàn bộ biến thể
            $('#div-variant').on('click', '.btn-remove-variant-group', function(e) {
                e.preventDefault();
                const href = $(this).attr('href');
                const button = $(this);
                if (href) {
                    Swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: 'DELETE',
                                url: href,
                                success: function(data) {
                                    if (data.status == 'success') {
                                        Swal.fire({
                                            title: "Deleted!",
                                            text: data
                                                .message,
                                            icon: "success"
                                        });
                                        button.closest('.variant-group').remove();
                                        checkProductType();
                                        updateVariantIndices();
                                    } else if (data.status == 'error') {
                                        Swal.fire({
                                            title: "Can't Delete",
                                            text: data
                                                .message,
                                            icon: "error",
                                        });
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.log(
                                        error);
                                }
                            });
                        }
                    });

                } else {
                    $(this).closest('.variant-group').remove(); // Xóa toàn bộ nhóm biến thể
                    checkProductType();
                    updateVariantIndices();
                }

            });
        })
    </script>
@endpush