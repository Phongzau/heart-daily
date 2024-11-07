@extends('layouts.admin')

@section('title')
    Heart Daily | Product Create
@endsection

@section('css')
    <style>
        /* Thay đổi màu nền cho các tùy chọn disabled */
        select option:disabled {
            background-color: #f0f0f0;
            /* Màu nền xám */
            color: #999;
            /* Màu chữ xám */
        }

        .modal-backdrop {
            z-index: auto;
            /* Hoặc có thể thử với z-index: -1; */
        }

        .modal-backdrop.show {
            opacity: 0;
            /* Hoặc để 0.1 nếu bạn muốn vẫn thấy một lớp nền rất mờ */
        }

        .variant-item {
            display: flex;
            /* Sử dụng Flexbox để định dạng */
            justify-content: space-between;
            /* Đặt khoảng cách đều giữa các phần tử con */
            padding: 10px;
            /* Khoảng cách bên trong */
            border-bottom: 1px solid #ccc;
            /* Đường viền dưới để phân cách các biến thể */
        }

        .action-variant {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }

        .variant-name {
            flex: 1;
            /* Chiếm không gian còn lại */
            text-align: left;
            /* Căn trái cho tên biến thể */
            color: #6777ef;
            font-weight: 700;
        }

        .variant-price {
            text-align: right;
            /* Căn phải cho giá tiền */
            font-weight: 700;
            /* Đậm chữ cho giá tiền */
            color: #6777ef;
            /* Màu chữ cho giá tiền (màu đỏ) */
        }

        .variant-quantity {
            text-align: right;
            /* Căn phải cho giá tiền */
            font-weight: 700;
            /* Đậm chữ cho giá tiền */
            color: #6777ef;
            /* Màu chữ cho giá tiền (màu đỏ) */
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
                            <h4>Create Product</h4>
                        </div>
                        <div class="card-body">
                            <form id="add-form-product" action="{{ route('admin.products.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
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
                                                            <input type="text" name="name" value="{{ old('name') }}"
                                                                class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Sku</label>
                                                            <input type="text" name="sku" value="{{ old('sku') }}"
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
                                                                            value="{{ old('price') }}"
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
                                                                                id="discount-unit">đ

                                                                            </div>
                                                                        </div>
                                                                        <input type="number" name="offer_price"
                                                                            value="{{ old('offer_price') }}"
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
                                                                        value="{{ old('offer_start_date') }}"
                                                                        class="form-control datepicker">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="">Offer End Date</label>
                                                                    <input type="text" name="offer_end_date"
                                                                        value="{{ old('offer_end_date') }}"
                                                                        class="form-control datepicker">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        


                                                        <div class="form-group">
                                                            <label for="">Short Description</label>
                                                            <textarea name="short_description" class="form-control"></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Long Description</label>
                                                            <textarea name="long_description" class="form-control summernote"></textarea>
                                                        </div>
                                                        <div class="form-group ">
                                                            <label for="inputState">Status</label>
                                                            <select id="inputState" name="status"
                                                                value="{{ old('status') }}" class="form-control">
                                                                <option value="1">Active</option>
                                                                <option value="0">Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="product-variants" role="tabpanel"
                                                        aria-labelledby="product-variants-tab">
                                                        <!-- Nội dung về các biến thể của sản phẩm -->
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div id="check_type">
                                                                    <div class="form-group ">
                                                                        <label for="inputState">Type Product</label>
                                                                        <select id="select_type" name="type_product"
                                                                            class="form-control">
                                                                            <option value="" hidden>--Select--
                                                                            </option>
                                                                            <option value="product_simple">Sản phẩm đơn
                                                                                giản
                                                                            </option>
                                                                            <option value="product_variant">Sản phẩm biến
                                                                                thể
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                    <hr>
                                                                </div>

                                                                <div id="div-simple" style="display: none">
                                                                    <div id="stock-quantity-group" class="form-group">
                                                                        <label for="">Stock Quantity</label>
                                                                        <input type="number" min="0"
                                                                            id="stock-quantity" name="qty"
                                                                            value="{{ old('qty') }}"
                                                                            class="form-control">
                                                                    </div>
                                                                </div>

                                                                <div id="div-variant" style="display: none">
                                                                    <button class="btn btn-light mt-2 btn-add-attribute"><i
                                                                            class="fas fa-plus mr-1">
                                                                        </i>Thêm thuộc tính</button>
                                                                    <div class="attribute-container mt-3">
                                                                        <h6 style="margin-bottom: 14px">Thuộc tính</h6>
                                                                    </div>
                                                                    <hr>
                                                                    <button class="btn btn-primary btn-add-variant">Thêm
                                                                        biến thể</button>
                                                                    <div style="display: none;" id="variantList">
                                                                        <div class="action-variant"
                                                                            style="padding: 25px 0px 25px 10px">
                                                                            <div style="margin-top: 8px;">
                                                                                <input type="checkbox"
                                                                                    class="checkbox-all mr-2">
                                                                                <span class="variant-name"
                                                                                    id="count-variant">0 Biển
                                                                                    thể</span>
                                                                            </div>

                                                                            <button style="display: none"
                                                                                class="btn btn-primary btn-action-variant btn-lg dropdown-toggle"
                                                                                type="button" data-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false">
                                                                                Chỉnh sửa biến thể
                                                                            </button>
                                                                            <div class="dropdown-menu">
                                                                                <a class="dropdown-item edit-price">Chỉnh
                                                                                    giá</a>
                                                                                <a class="dropdown-item edit-qty">Chỉnh
                                                                                    số lượng</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Phần hiển thị biến thể -->

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card mt-3" id="imageUploadCard">
                                            <div class="card-header">
                                                <h4>Multiple Upload <code>(Max 10 Picture)</code></h4>
                                            </div>
                                            <div class="card-body">
                                                <div style="border: 2px dashed #6777ef;" class="dropzone"
                                                    id="my-awesome-dropzone"></div>
                                            </div>
                                        </div>
                                        <div class="card mt-3">
                                            <div class="card-body">
                                                <button class="btn btn-primary" style="float: right;"
                                                    type="submit">Create</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="tags">Tags:</label>
                                                    <select class="form-control tags-select select2" name="tags[]"
                                                        multiple="multiple">
                                                        @foreach ($tags as $tag)
                                                            <option value="{{ $tag->id }}"> {{ $tag->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputState">Category</label>
                                                    <select id="inputState" name="category_id"
                                                        class="form-control main-category">
                                                        <option value="" hidden>Select</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="inputState">Brand</label>
                                                    <select id="inputState" name="brand_id" class="form-control">
                                                        <option value="" hidden>Select</option>
                                                        @foreach ($brands as $brand)
                                                            <option value="{{ $brand->id }}">{{ $brand->name }}
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
                                                            src="{{ asset('admin/assets/img/news/img01.jpg') }}"
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
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Modal thêm biến thể -->
        <div id="attributeModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Thêm biến thể</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Đây sẽ là nơi để load các input động -->
                        <form id="variantForm">
                            <!-- Nội dung sẽ được thêm động vào đây -->
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-save-variant">Lưu biến thể</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal chỉnh sửa biến thể -->
        <div id="editVariantModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Chỉnh sửa biến thể</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editVariantForm">
                            <!-- Nội dung sẽ được thêm động vào đây -->
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-save-edit-variant">Lưu thay đổi</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal chỉnh sửa giá -->
        <div id="editPriceModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Chỉnh sửa giá biến thể</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editPriceForm">
                            <div class="form-group">
                                <label for="variantPrice">Giá mới</label>
                                <input type="number" value="0" class="form-control" id="variantPrice" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-save-price">Lưu thay đổi</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal chỉnh sửa số lượng -->
        <div id="editQtyModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Chỉnh sửa số lượng biến thể</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editQtyForm">
                            <div class="form-group">
                                <label for="variantQty">Số lượng mới</label>
                                <input type="number" value="0" class="form-control" id="variantQty" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-save-qty">Lưu thay đổi</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // product_tag

            $('.tags-select').select2({
                tags: true, // Cho phép thêm tag mới
                placeholder: "Chọn hoặc thêm tag mới",
                allowClear: true,
                tokenSeparators: [',']
            });

            // Biến lưu trữ thuộc tính và giá trị đã chọn
            let attributeData = [];

            $('#attributeModal').on('hidden.bs.modal', function() {
                $('.modal-backdrop').remove(); // Loại bỏ lớp phủ modal
                $('body').removeClass('modal-open'); // Đảm bảo body không bị khóa
                $('body').css('padding-right', ''); // Đặt lại padding nếu cần
            });

            $('#product-variants-tab').click(function() {
                $('#imageUploadCard').hide();
            });

            $('#product-info-tab').click(function() {
                setTimeout(() => {
                    $('#imageUploadCard').show();
                }, 300);
            });

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
                const btnAddAttribute = $(group).closest('#div-variant')
                const currentGroup = $(group).closest('.attribute-container');
                let currentVariants = currentGroup.find('.variant-row').length;

                if (currentVariants >= maxVariants) {
                    btnAddAttribute.find('.btn-add-attribute').hide();
                } else {
                    btnAddAttribute.find('.btn-add-attribute').show();
                }
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
                        // $('.btn-add-product-variant').click();

                        // setTimeout(function() {
                        //     for (let i = 0; i < maxVariants; i++) {
                        //         $('.btn-add-variant').click();
                        //     }
                        // }, 500)
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

            // Xử lý khi nhấn nút "Add product variant"
            $('.btn-add-attribute').click(function(e) {
                e.preventDefault();

                var newVariant = `
                    <div class="variant-row">
                        <div class="form-group row mb-2">
                            <div class="col-md-5">
                                <select name="attribute[]" class="form-control variant-select select2">
                                    <option value="" hidden>--Chọn thuộc tính--</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                    <select name="attribute_value[]" class="form-control attribute-select select2" disabled multiple>
                                    <option value="" hidden>--Chọn giá trị--</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button type="button" style="height: 45px;" class="btn btn-danger btn-remove-attribute"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </div>
                    </div>
                `;

                // Thêm nội dung biến thể mới vào tab "div-variant"
                let newAttributeRow = $(newVariant).appendTo($(this).siblings('.attribute-container'));
                var elementSelect = newAttributeRow.find('.variant-select');
                loadCategoryAttribute(elementSelect);
                checkAddVariantButton(elementSelect);
                // Chỉ khởi tạo Select2 cho các phần tử mới
                newAttributeRow.find('.select2').select2();
            });

            // Xử lý khi nhấn nút "Remove" để xóa thuộc tính variant
            $('#div-variant').on('click', '.btn-remove-attribute', function(e) {
                e.preventDefault();
                const btnAddAttribute = $(this).closest('#div-variant')
                const currentGroup = $(this).closest('.attribute-container');
                let currentVariants = currentGroup.find('.variant-row').length - 1;

                if (currentVariants >= maxVariants) {
                    btnAddAttribute.find('.btn-add-attribute').hide();
                } else {
                    btnAddAttribute.find('.btn-add-attribute').show();
                }

                // Tìm xem thuộc tính đã tồn tại trong mảng chưa, nếu có thì cập nhật
                let variantRowElement = $(this).closest('.variant-row');
                let variantId = variantRowElement.find('.variant-select').val();

                let existingAttributeIndex = attributeData.findIndex(item => item.id === variantId);
                if (existingAttributeIndex !== -1) {
                    attributeData.splice(existingAttributeIndex, 1); // Xóa phần tử khỏi attributeData
                }
                checkAttributeData(); // Xóa dòng thuộc tính chứa nút remove
                $(this).closest('.variant-row').remove();
            });

            // Hàm kiểm tra nếu có ít nhất một thuộc tính và giá trị
            function checkAttributeData() {
                // alert('heheh');
                // Kiểm tra nếu attributeData không rỗng và có ít nhất một thuộc tính có giá trị
                if (attributeData.length > 0 && attributeData.some(attr => Object.keys(attr.values).length > 0)) {
                    // Hiển thị nút "Thêm biến thể"
                    // alert('hehehe');
                    $('.btn-add-variant').show();
                    $('#variantList').show();
                } else {
                    $('.btn-add-variant').hide();
                    $('#variantList').hide();
                }
            }

            // Khởi tạo mảng lưu các biến thể
            let variants = {};

            // Khi nhấn nút "Thêm biến thể", hiển thị popup và load các thuộc tính đã chọn
            $('.btn-add-variant').click(function(e) {
                e.preventDefault();

                // Xóa nội dung cũ của form trong popup
                $('#variantForm').empty();

                // Kiểm tra nếu có dữ liệu thuộc tính đã lưu
                if (attributeData.length > 0) {
                    // Lặp qua từng thuộc tính và đổ dữ liệu ra form trong popup
                    attributeData.forEach(function(attr) {
                        // Tạo danh sách các giá trị với tên tương ứng
                        let optionsHtml = Object.entries(attr.values).map(([id, name]) =>
                            `<option value="${id}">${name}</option>`
                        ).join('');

                        // Tạo trường select cho thuộc tính
                        let fieldHtml = `
                                    <div class="form-group">
                                        <label>${attr.name}</label>
                                        <select name="${attr.name}" class="form-control">
                                            ${optionsHtml}
                                        </select>
                                    </div>
                                `;
                        // Thêm trường mới vào form
                        $('#variantForm').append(fieldHtml);
                    });

                    // Thêm một trường nhập giá cho toàn bộ biến thể
                    let moreFieldHtml = `
                            <div class="form-group">
                                <label>Giá biến thể:</label>
                                <input type="number" value="0" name="price" class="form-control" placeholder="Nhập giá biến thể" required>
                            </div>
                            <div class="form-group">
                                <label>Số lượng biến thể:</label>
                                <input type="number" value="0" name="quantity" class="form-control" placeholder="Nhập số lượng biến thể" required>
                            </div>
                        `;

                    // Thêm trường nhập giá vào form
                    $('#variantForm').append(moreFieldHtml);

                    // Hiển thị popup
                    $('#attributeModal').modal('show');
                } else {
                    alert('Không có thuộc tính nào được chọn!');
                }
            });

            // Khi người dùng nhấn "Lưu biến thể"
            $('.btn-save-variant').click(function() {
                // Thu thập dữ liệu từ form biến thể
                let variantData = $('#variantForm').serializeArray();
                console.log(variantData);

                // Biến để lưu trữ tên biến thể
                let variantNameArray = []; // Sử dụng mảng để lưu tên biến thể
                let variantIdArray = [];
                // Biến để lưu trữ số tiền của biến thể
                let variantPrice = 0; // Bạn có thể thay đổi giá trị này theo logic của bạn

                // Lặp qua variantData để xây dựng tên biến thể
                variantData.forEach(item => {
                    // Nếu item là giá, lưu vào biến variantPrice
                    if (item.name === 'price') {
                        variantPrice = parseFloat(item.value); // Chuyển đổi giá trị sang số
                    } else if (item.name === 'quantity') {
                        variantQty = parseInt(item.value);
                    } else {
                        const selectedValue = $(
                            `#variantForm select[name="${item.name}"] option:selected`);

                        variantNameArray.push(selectedValue.text());
                        variantIdArray.push(selectedValue.val());
                    }
                });
                // Kết hợp các giá trị trong mảng thành chuỗi với dấu gạch chéo
                let variantName = variantNameArray.join(' / ');
                // Tạo khóa duy nhất cho biến thể
                let variantIdKey = variantIdArray.join('_');

                // Kiểm tra xem biến thể đã tồn tại chưa
                if (variants[variantIdKey]) {
                    toastr.error(`Biến thể ${variantName} đã tồn tại. Vui lòng kiểm tra lại! 😢`);
                    return; // Không làm gì thêm, chỉ thoát hàm
                } else {
                    toastr.success(`Biến thể ${variantName} đã được tạo thành công 😊`)
                    // Nếu chưa tồn tại, thêm mới vào variants
                    variants[variantIdKey] = {
                        value_variant: variantIdArray,
                        title_variant: variantNameArray,
                        price_variant: variantPrice,
                        qty_variant: variantQty
                    };

                    // Hiển thị dữ liệu vừa lưu để kiểm tra
                    console.log('Danh sách các biến thể:', variants);

                    // Tạo phần tử mới để hiển thị biến thể
                    let newVariantHtml = `
                        <div class="variant-item" style="padding: 10px" data-id="${variantIdKey}">
                            <input type="checkbox" class="checkbox-variant mr-2" data-id="${variantIdKey}">
                            <span class="variant-name" style="margin: 16px 0px 15px 5px;">${variantName}</span>
                            <div style="padding: 0px 20px 0px 20px;">
                            <span class="variant-price" style="float: right;">${variantPrice.toLocaleString('vi-VN')} VNĐ</span>
                            <br>
                            <span class="variant-quantity" style="float: right;">Số lượng: ${variantQty}</span>
                            </div>
                            <button class="btn btn-primary edit-variant" style="margin: 8px 5px 12px 0px;" data-id="${variantIdKey}"><i class="fas fa-pencil-alt"></i></button>
                            <button class="btn btn-danger delete-variant" style="margin: 8px 5px 12px 0px;" data-id="${variantIdKey}"><i class="fas fa-trash-alt"></i></button>
                        </div>
                    `;

                    // Thêm phần tử mới vào phần hiển thị biến thể
                    $('#variantList').append(
                        newVariantHtml); // Thay #variantList bằng selector của phần hiển thị biến thể

                    // Đóng modal sau khi lưu
                    $('#attributeModal').modal('hide');
                    checkCountVariant();
                    // Reset các mảng sau khi thêm thành công
                    variantNameArray = [];
                    variantIdArray = [];
                }
            });

            // Thêm sự kiện click vào nút .delete-variant với document
            $(document).on('click', '.delete-variant', function(e) {
                e.preventDefault();
                let variantIdKey = $(this).data('id');

                $(this).closest('.variant-item[data-id="' + variantIdKey + '"]').remove();
                var arrNameVariant = variants[variantIdKey].title_variant;
                let nameVariant = arrNameVariant.join(" / ");
                toastr.success(`Biến thể ${nameVariant} đã được xóa thành công`)
                delete variants[variantIdKey];
                checkCountVariant();
            });

            $(document).on('click', '.edit-variant', function(event) {
                event.preventDefault();
                const variantIdKey = $(this).data('id');
                const variant = variants[variantIdKey];
                var arrNameVariant = variants[variantIdKey].title_variant;
                let nameVariant = arrNameVariant.join(" / ");
                // Xóa nội dung cũ của form trong popup
                $('#editVariantForm').empty();
                $('#editVariantModal .modal-title').text(`Chỉnh sửa ${nameVariant}`);
                // Lặp qua từng thuộc tính và đổ dữ liệu ra form trong popup
                attributeData.forEach(function(attr, index) {
                    let optionsHtml = Object.entries(attr.values).map(([id, name]) =>
                        `<option value="${id}" ${variant.value_variant.includes(id) ? 'selected' : ''}>${name}</option>`
                    ).join('');

                    // Tạo trường select cho thuộc tính
                    let fieldHtml = `
                            <div class="form-group">
                                <select hidden name="${attr.name}" class="form-control">
                                    ${optionsHtml}
                                </select>
                            </div>
                        `;
                    $('#editVariantForm').append(fieldHtml);
                });

                // Thêm trường nhập giá và số lượng
                let moreFieldHtml = `
                        <div class="form-group">
                            <label>Giá biến thể:</label>
                            <input type="number" name="price" class="form-control" value="${variant.price_variant}" required>
                        </div>
                        <div class="form-group">
                            <label>Số lượng biến thể:</label>
                            <input type="number" name="quantity" class="form-control" value="${variant.qty_variant}" required>
                        </div>
                    `;
                $('#editVariantForm').append(moreFieldHtml);

                // Hiển thị popup
                $('#editVariantModal').modal('show');
            });

            $('.btn-save-edit-variant').click(function(event) {
                event.preventDefault(); // Ngăn chặn sự kiện submit

                let editedVariantData = $('#editVariantForm').serializeArray();
                console.log(editedVariantData);

                let editedVariantNameArray = [];
                let editedVariantIdArray = [];
                let editedVariantPrice = 0;
                let editedVariantQty = 0;

                editedVariantData.forEach(item => {
                    if (item.name === 'price') {
                        editedVariantPrice = parseFloat(item.value);
                    } else if (item.name === 'quantity') {
                        editedVariantQty = parseInt(item.value);
                    } else {
                        const selectedValue = $(
                            `#editVariantForm select[name="${item.name}"] option:selected`);
                        editedVariantNameArray.push(selectedValue.text());
                        editedVariantIdArray.push(selectedValue.val());
                    }
                });

                let editedVariantName = editedVariantNameArray.join(' / ');
                let editedVariantIdKey = editedVariantIdArray.join('_');
                // Cập nhật biến thể
                if (variants[editedVariantIdKey]) {
                    variants[editedVariantIdKey] = {
                        value_variant: editedVariantIdArray,
                        title_variant: editedVariantNameArray,
                        price_variant: editedVariantPrice,
                        qty_variant: editedVariantQty
                    };

                    toastr.success(`Biến thể ${editedVariantName} đã được cập nhật thành công 😊`);

                    // Cập nhật hiển thị cho biến thể trong danh sách
                    let $variantItem = $(`.variant-item[data-id="${editedVariantIdKey}"]`);
                    if ($variantItem.length) {
                        $variantItem.find('.variant-name').text(editedVariantName);
                        $variantItem.find('.variant-price').text(editedVariantPrice.toLocaleString(
                            'vi-VN') + ' VNĐ');
                        $variantItem.find('.variant-quantity').text('Số lượng: ' + editedVariantQty);
                    }
                    editedVariantNameArray = [];
                    editedVariantIdArray = [];
                    // Đóng modal sau khi lưu
                    $('#editVariantModal').modal('hide');
                } else {
                    toastr.error(`Biến thể ${editedVariantName} không tồn tại! 😢`);
                }
            });

            $('.checkbox-all').click(function() {
                let isChecked = $(this).is(':checked');
                console.log(isChecked);
                $('.variant-item').find('.checkbox-variant').prop('checked', isChecked);
                if (isChecked && $('.checkbox-variant:checked').length > 0) {
                    $('.btn-action-variant').show();
                } else {
                    $('.btn-action-variant').hide();
                }
            })

            $(document).on('click', '.edit-price', function() {
                // currentVariantId = $(this).closest('.variant-item').data('id');
                $('#editPriceModal').modal('show');

                // Tạo mảng để lưu ID các biến thể đã chọn
                let selectedVariantIds = [];

                // Tìm tất cả .variant-item có checkbox đã được chọn
                $('.variant-item').has('.checkbox-variant:checked').each(function() {
                    let variantId = $(this).data('id');
                    selectedVariantIds.push(variantId);
                });

                // Log ra mảng các ID đã chọn để kiểm tra
                console.log("Selected Variants:", selectedVariantIds);

                // Lưu mảng ID vào một biến toàn cục để sử dụng khi lưu
                window.selectedVariantIds = selectedVariantIds;
            });

            $(document).on('click', '.btn-save-price', function() {
                let newPrice = parseFloat($('#variantPrice').val());

                if (window.selectedVariantIds && window.selectedVariantIds.length > 0) {
                    window.selectedVariantIds.forEach(function(variantId) {
                        // Lấy ra biến thể theo variantId
                        let variantItem = $(`.variant-item[data-id="${variantId}"]`);
                        variantItem.find('.variant-price').text(newPrice.toLocaleString('vi-VN') +
                            ' VNĐ');
                        variants[variantId].price_variant = newPrice;
                    })

                    // Thông báo và ẩn popup
                    toastr.success('Giá các biến thể đã được cập nhật! 😊');
                    $('#editPriceModal').modal('hide');
                } else {
                    toastr.error('Không có biến thể nào được chọn! 😢');
                }
            });

            $(document).on('click', '.edit-qty', function() {
                // currentVariantId = $(this).closest('.variant-item').data('id');
                $('#editQtyModal').modal('show');

                // Tạo mảng để lưu ID các biến thể đã chọn
                let selectedVariantIds = [];

                // Tìm tất cả .variant-item có checkbox đã được chọn
                $('.variant-item').has('.checkbox-variant:checked').each(function() {
                    let variantId = $(this).data('id');
                    selectedVariantIds.push(variantId);
                });

                // Log ra mảng các ID đã chọn để kiểm tra
                console.log("Selected Variants:", selectedVariantIds);

                // Lưu mảng ID vào một biến toàn cục để sử dụng khi lưu
                window.selectedVariantIds = selectedVariantIds;
            });

            $(document).on('click', '.btn-save-qty', function() {
                let newQty = parseInt($('#variantQty').val());

                if (window.selectedVariantIds && window.selectedVariantIds.length > 0) {
                    window.selectedVariantIds.forEach(function(variantId) {
                        // Lấy ra biến thể theo variantId
                        let variantItem = $(`.variant-item[data-id="${variantId}"]`);
                        variantItem.find('.variant-quantity').text(`Số lượng: ${newQty}`);
                        variants[variantId].qty_variant = newQty;
                    })

                    // Thông báo và ẩn popup
                    toastr.success('Số lượng các biến thể đã được cập nhật! 😊');
                    $('#editQtyModal').modal('hide');
                } else {
                    toastr.error('Không có biến thể nào được chọn! 😢');
                }
            });

            $(document).on('change', '.checkbox-variant', function() {
                if ($('.checkbox-variant:checked').length > 0) {
                    $('.btn-action-variant').show(); // Hiển thị button .btn-action-variant
                } else {
                    $('.btn-action-variant').hide(); // Ẩn button .btn-action-variant
                }
            });

            // Khi người dùng chọn thuộc tính
            $('#div-variant').on('change', '.variant-select', function() {
                let variantId = $(this).val();
                let attributeContainer = $(this).closest('.variant-row');
                let valueSelect = attributeContainer.find('.attribute-select');

                // Lấy tên thuộc tính từ option được chọn
                let attributeName = $(this).find('option:selected').text(); // Lấy tên thuộc tính

                // Lưu thuộc tính và giá trị đã chọn vào mảng
                let attribute = {
                    id: variantId,
                    name: attributeName, // Lưu tên thuộc tính
                    values: valueSelect.val() // Lấy tất cả các giá trị đã chọn
                };

                // Tìm xem thuộc tính đã tồn tại trong mảng chưa, nếu có thì cập nhật
                let existingAttributeIndex = attributeData.findIndex(item => item.id === variantId);
                if (existingAttributeIndex !== -1) {
                    attributeData[existingAttributeIndex] = attribute;
                } else {
                    attributeData.push(attribute);
                }

                console.log('Thuộc tính đã chọn:', attributeData);
            });

            // Khi người dùng chọn giá trị thuộc tính
            $('#div-variant').on('change', '.attribute-select', function() {
                let selectedValues = $(this).val(); // Lấy tất cả các giá trị đã chọn (ID)
                let attributeContainer = $(this).closest('.variant-row');
                let variantId = attributeContainer.find('.variant-select').val();

                // Lấy tên của tất cả các giá trị thuộc tính đã chọn
                let valuesWithNames = {};
                selectedValues.forEach(value => {
                    let attributeName = $(this).find(`option[value="${value}"]`)
                        .text(); // Lấy tên giá trị thuộc tính theo ID
                    valuesWithNames[value] = attributeName; // Lưu ID và tên vào đối tượng
                });

                // Tìm xem thuộc tính đã tồn tại trong mảng chưa
                let existingAttributeIndex = attributeData.findIndex(item => item.id === variantId);
                if (existingAttributeIndex !== -1) {
                    // Cập nhật hoặc xóa giá trị không còn trong danh sách đã chọn
                    let existingValues = attributeData[existingAttributeIndex].values;

                    // Xóa các giá trị không còn trong selectedValues
                    for (let key in existingValues) {
                        if (!selectedValues.includes(key)) {
                            delete existingValues[key]; // Xóa giá trị khỏi existingValues
                        }
                    }

                    // Cập nhật lại giá trị đã chọn
                    attributeData[existingAttributeIndex].values = {
                        ...existingValues,
                        ...valuesWithNames // Thêm các giá trị mới
                    };
                } else {
                    // Nếu thuộc tính chưa tồn tại, tạo mới
                    attributeData.push({
                        id: variantId,
                        values: valuesWithNames // Lưu ID và tên thuộc tính
                    });
                }

                console.log('Giá trị thuộc tính đã chọn:', attributeData);
                checkAttributeData();
            });

            // Ẩn nút "Thêm biến thể" ban đầu
            $('.btn-add-variant').hide();

            // Xử lý khi chọn một variant từ dropdown
            $('#div-variant').on('change', '.variant-select', function() {
                var variantId = $(this).val();
                var attributeContainer = $(this).closest('.variant-row');
                var valueSelect = attributeContainer.find('.attribute-select');
                valueSelect.removeAttr('disabled');
                valueSelect.select2({
                    placeholder: "Nhập từ bạn muốn tìm kiếm",
                    allowClear: true,
                });
                // Sau khi chọn một variant, gọi hàm update để kiểm tra và disable các giá trị trùng lặp
                updateVariantAttributes(attributeContainer);
                if (variantId) {
                    $.ajax({
                        url: "{{ route('admin.attributes.get-attributes', ':variantId') }}"
                            .replace(':variantId', variantId),
                        type: 'GET',
                        success: function(data) {
                            // Xử lý đổ dữ liệu vào valueSelect
                            valueSelect.empty(); // Xóa các phần tử trong valueSelect
                            valueSelect.append(
                                '<option value="" hidden>--Chọn giá trị--</option>');
                            $.each(data, function(index, value) {
                                valueSelect.append('<option value="' + value.id + '">' +
                                    value.title + '</option>');
                            });

                            // Sau khi cập nhật options, chỉ cập nhật biến thể hiện tại
                            updateVariantAttributes(attributeContainer);
                        },
                    })
                }
            })

            // Đếm số lượng biến thể
            function checkCountVariant() {
                console.log($('.variant-item').length);
                let countVariant = $('.variant-item').length;
                $('#count-variant').text(`${countVariant} biến thể`);
            }

            // Hàm update các tùy chọn không trùng lặp cho một dòng cụ thể
            function updateVariantAttributes(currentRow) {
                // Lấy nhóm `variant-attributes` chứa dòng hiện tại
                var currentAttributeGroup = currentRow.closest('.attribute-container');

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

            // Hàm để load danh sách variant từ server
            function loadCategoryAttribute(selectElement) {
                $.ajax({
                    url: "{{ route('admin.category_attributes.get-category-attributes') }}",
                    method: 'GET',
                    success: function(data) {
                        selectElement.empty();
                        selectElement.append('<option value="" hidden>--Chọn thuộc tính--</option>');
                        $.each(data, function(key, value) {
                            selectElement.append('<option value="' + value.id +
                                '">' + value.title + '</option>')
                        });

                        // // Sau khi load xong, cập nhật lại các dropdown trong nhóm hiện tại
                        updateVariantAttributes(selectElement);
                    },
                })
            }

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

                    this.on("addedfile", file => {
                        console.log("A file has been added: " + file.name);
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

                    // Sự kiện submit form
                    $('#add-form-product').on('submit', function(event) {
                        event.preventDefault(); // Ngăn submit mặc định

                        // Lấy dữ liệu từ form
                        var formData = new FormData(this);
                        formData.append('variants', JSON.stringify(variants));
                        formData.append('attributeData', JSON.stringify(attributeData));
                        // Gửi AJAX request để thêm sản phẩm
                        $.ajax({
                            url: "{{ route('admin.products.store') }}",
                            method: 'POST',
                            data: formData,
                            contentType: false, // Không đặt contentType, để mặc định là false
                            processData: false, // Không xử lý dữ liệu, để dạng FormData
                            success: function(response) {
                                if (response.status == 'success') {
                                    productId = response.data.id;
                                    toastr.success("Thêm sản phẩm thành công!");

                                    if (dropzoneInstance.getQueuedFiles().length >
                                        0) {
                                        dropzoneInstance.on("sending", function(
                                            file,
                                            xhr, formData) {
                                            formData.append("product_id",
                                                productId);
                                        });
                                        dropzoneInstance.processQueue();
                                    } else {
                                        setTimeout(function() {
                                            window.location.href =
                                                "{{ route('admin.products.index') }}";
                                        }, 1500);
                                    }
                                } else if (response.status == 'error') {
                                    toastr.error(response.message);
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
        })
    </script>
@endpush
