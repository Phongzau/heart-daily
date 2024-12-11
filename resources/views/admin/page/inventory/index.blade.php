@extends('layouts.admin')

@section('title')
    {{ $generalSettings->site_name }} || Hàng tồn kho
@endsection

@section('css')
    <style>
        /* Loại bỏ dấu chấm của ul */
        #filter-brand,
        #filter-category {
            list-style-type: none;
            /* Loại bỏ bullet points */
            padding: 0;
            /* Loại bỏ khoảng cách bên trái */
            margin: 0;
            /* Loại bỏ khoảng cách margin */
        }

        /* Loại bỏ viền cho các mục li */
        #filter-brand .list-group-item,
        #filter-category .list-group-item {
            border: none;
            /* Xóa border */
            padding: 5px 0;
            /* Điều chỉnh khoảng cách giữa các mục */
        }

        /* Tùy chỉnh checkbox và label */
        #filter-brand .list-group-item label,
        #filter-category .list-group-item label {
            margin-left: 8px;
            /* Thêm khoảng cách giữa checkbox và text */
            cursor: pointer;
            /* Thay đổi con trỏ chuột để tạo trải nghiệm tốt hơn */
        }

        /* Ẩn danh sách */
        .d-none {
            display: none;
        }

        /* Tùy chỉnh nút mở rộng */
        #toggle-brand,
        #toggle-category,
        #toggle-color,
        #toggle-size {
            font-size: 1.3rem;
            margin-left: 10px;
            cursor: pointer;
            border: none;
            background: none;
            text-decoration: underline;
            text-decoration: none;
        }

        #toggle-brand:hover,
        #toggle-category:hover {
            color: #0056b3;
            /* Màu khi hover */
            text-decoration: none;
            cursor: pointer;
        }

        .list-group-item {
            transition: all 0.3s ease;
            /* Hiệu ứng mượt mà */
        }

        #filter-brand,
        #filter-category {
            margin-bottom: 15px;
        }

        .input-group {
            display: flex;
            gap: 10px;
        }

        /* Container của màu sắc */
        .color-box-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        /* Ô màu sắc */
        .color-box {
            width: 30px;
            height: 30px;
            border: 1px solid #ddd;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .color-box:hover {
            transform: scale(1.1);
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
        }

        /* Container của kích thước */
        .size-box-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        /* Ô kích thước */
        .size-box {
            width: 40px;
            height: 30px;
            border: 1px solid #ddd;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .size-box:hover {
            background-color: #007bff81;
            color: white;
        }

        /* Tùy chỉnh bảng */
        .table {
            margin-bottom: 0;
            font-size: 14px;
            text-align: center;
            vertical-align: middle;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
            text-transform: uppercase;
            vertical-align: middle;
        }

        .table td {
            vertical-align: middle;
        }

        /* Hình ảnh trong bảng */
        .table img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
        }

        .color-box.active {

            opacity: 0.5;

        }

        .size-box.active {
            background-color: #ddd;
            font-weight: bold;

        }
    </style>
@endsection

@section('section')
    <!-- Main Content -->

    <section class="section">
        <div class="section-header">
            <h1>Hàng tồn kho</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-2">
                    <div class="card">
                        <div class="card-header">
                            <h4>Bộ lọc</h4>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ route('admin.inventory.index') }}">
                                <!-- Tìm theo tên -->
                                <div class="form-group">
                                    <label for="name">Tìm theo tên</label>
                                    <input type="text" name="name" class="form-control" id="name"
                                        value="{{ request('name') }}" placeholder="Nhập tên sản phẩm">
                                </div>

                                <!-- Tìm theo giá -->
                                <div class="form-group">
                                    <label>Giá tiền</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="price_min" id="price_min"
                                            value="{{ request('price_min') }}" placeholder="Tối thiểu">
                                        <input type="number" class="form-control" name="price_max" id="price_max"
                                            value="{{ request('price_max') }}" placeholder="Tối đa">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="category_id">Danh mục</label>
                                    <select name="category_id" id="category_id" class="form-control">
                                        <option value="">Chọn danh mục</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="brand_id">Thương hiệu</label>
                                    <select name="brand_id" id="brand_id" class="form-control">
                                        <option value="">Chọn thương hiệu</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}"
                                                {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="type_product">Loại sản phẩm</label>
                                    <select name="type_product" id="type_product" class="form-control">
                                        <option value="">Chọn loại sản phẩm</option>
                                        <option value="product_simple"
                                            {{ request('type_product') == 'product_simple' ? 'selected' : '' }}>Đơn giản
                                        </option>
                                        <option value="product_variant"
                                            {{ request('type_product') == 'product_variant' ? 'selected' : '' }}>Biến thể
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>MÀU</label>
                                    <button class="btn btn-link p-0 float-right text-dark" id="toggle-color">-</button>
                                    <div class="color-box-container" id="filter-color">
                                        @foreach ($colors as $color)
                                            <div class="color-box"
                                                style="background-color: {{ $color->code }};list-style-type:none; cursor: pointer;"
                                                title="{{ $color->title }}" data-color-id="{{ $color->id }}">
                                                {{-- <a href="#"></a> --}}
                                            </div>
                                        @endforeach
                                    </div>
                                    <input type="hidden" name="color" id="color-input" value="{{ request('color') }}">
                                </div>

                                <!-- Kích thước -->
                                <div class="form-group">
                                    <label>KÍCH CỠ</label>
                                    <button class="btn btn-link p-0 float-right text-dark" id="toggle-size">-</button>
                                    <div class="size-box-container" id="filter-size">
                                        @foreach ($sizes as $size)
                                            <div class="size-box" style="list-style-type:none" title="{{ $size->title }}"
                                                data-size-id="{{ $size->id }}">
                                                {{ $size->title }}
                                            </div>
                                        @endforeach
                                        <!-- Thêm kích thước khác tương tự -->
                                    </div>
                                    <input type="hidden" name="size" id="size-input" value="{{ request('size') }}">
                                </div>

                                <!-- Nút Tìm kiếm và Clear All -->
                                <div class="form-group text-center">
                                    <button class="btn btn-primary btn-block" type="submit">Tìm kiếm</button>
                                    <a href="{{ route('admin.inventory.index') }}" class="btn btn-secondary btn-block">Xóa
                                        bộ lọc</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header">
                            <h4>Danh sách sản phẩm</h4>

                            <div class="card-header-action">
                                <a href="{{ route('admin.inventory.export') }}" class="btn btn-outline-success"><i
                                        class="fa-light fa-file-excel fa-lg"></i> Excel</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="align-top">
                                            <th>#</th>
                                            <th>Hình ảnh</th>
                                            <th class="text-center">Tên sản phẩm<br><small class="text-secondary"
                                                    style="margin-top: -5px;">(brand & danh mục)</small></th>
                                            <th>Nhà cung cấp</th>
                                            <th>Giá nhập</th>
                                            <th>Tồn kho<br><small class="text-secondary" style="margin-top: -5px;">(số
                                                    lượng)</small></th>
                                            <th>Loại SP</th>
                                            <th>Ngày nhập hàng</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody id="product-table-body">
                                        @if (!$products->isEmpty())
                                            @foreach ($products as $index => $product)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td><img src="{{ Storage::url($product->image) }}"
                                                            alt="Hình sản phẩm">
                                                    </td>
                                                    <td class="text-center">
                                                        <span
                                                            class="product-name float-left">{{ limitText($product->name, 20) }}
                                                            /
                                                        </span>
                                                        <br>
                                                        <span class="product-category float-left">
                                                            ({{ $product->category->title }} &
                                                            {{ $product->brand->name }})
                                                        </span>
                                                    </td>
                                                    <td>{{ @$product->supplier->name }}</td>
                                                    <td>

                                                        {{ number_format($product->price_import) }}{{ $generalSettings->currency_icon }}
                                                    </td>

                                                    <td
                                                        class="
                                                    @if ($product->type_product === 'product_simple') @if ($product->qty <= 10)
                                                            text-danger
                                                        @elseif ($product->qty <= 20)
                                                            text-warning @endif
@else
@php
$totalQty = 0;
                                                            foreach ($product->ProductVariants as $productVariant) {
                                                                $totalQty += $productVariant->qty;
                                                            } @endphp
                                                        @if ($totalQty <= 10) text-danger
                                                        @elseif ($totalQty <= 20)
                                                            text-warning @endif
                                                    @endif
                                                ">
                                                        @if ($product->type_product === 'product_simple')
                                                            {{ $product->qty }}
                                                        @else
                                                            {{ $totalQty }}
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @if ($product->type_product === 'product_simple')
                                                            Đơn giản
                                                        @else
                                                            Biến thể
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $product->created_at }}
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-outline-primary view-detail-btn"
                                                            data-id="{{ $product->id }}" title="Chi tiết"><i
                                                                class="fa-solid fa-info fa-lg"></i>
                                                        </button>
                                                        <button class="btn btn-outline-info show-qr-btn"
                                                            data-id="{{ $product->id }}"
                                                            data-name="{{ $product->name }}"
                                                            data-url="{{ route('product.detail', ['slug' => $product->slug]) }}"
                                                            title="Hiển thị QR Code">
                                                            <i class="fa-light fa-qrcode"></i>
                                                        </button>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            @if ($products->isEmpty())
                                <div class="text-center" style="margin: 25px;">
                                    <h3 style="color:rgba(138, 138, 135, 0.878);">Không có sản phẩm nào !!</h3>
                                </div>
                            @else
                                <nav class="mt-4 float-right" aria-label="Page navigation example">
                                    <ul class="pagination">
                                        {{ $products->appends(request()->query())->links() }}
                                    </ul>
                                </nav>
                            @endif

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <div class="modal fade" id="qrCodeModal" tabindex="-1" aria-labelledby="qrCodeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrCodeModalLabel">Mã QR cho <span id="product-name"></span></h5>

                </div>
                <div class="modal-body text-center">
                    <div id="qr-code-container" class="d-flex justify-content-center">

                    </div>
                    <p id="product-url" class="mt-2 text-break"></p>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="productDetailModal" tabindex="-1" aria-labelledby="productDetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productDetailModalLabel">Chi tiết sản phẩm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="productDetailContent">
                    <div class="text-notification text-center">
                        <span>Đang tải chi tiết sản phẩm...</span>
                    </div>
                    <!-- Nội dung chi tiết sản phẩm -->
                    <div class="d-none infomation-product">
                        <div class="d-flex">
                            <!-- Hình ảnh sản phẩm -->
                            <div class="flex-shrink-0 me-4">
                                <img src="" id="productImage" alt="Hình ảnh sản phẩm" class="img-fluid"
                                    style="max-width: 200px;">
                            </div>
                            <!-- Thông tin sản phẩm -->
                            <div style="margin-left: 25px" class="flex-grow-1">
                                <h5 id="productName"></h5>
                                <p><strong>Danh mục:</strong> <span id="productCategory"></span></p>
                                <p><strong>Thương hiệu:</strong> <span id="productBrand"></span></p>
                                <p><strong>Giá:</strong> <span id="productPrice"></span></p>
                            </div>
                        </div>

                        <!-- Bảng thông tin biến thể sản phẩm -->
                        <hr>
                        <h6>Số lượng sản phẩm tồn kho:</h6>
                        <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th id="title-name"></th>
                                        <th>Giá bán</th>
                                        <th>Đã bán</th>
                                        <th>Tồn kho</th>
                                    </tr>
                                </thead>
                                <tbody id="productVariantsTable">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <script>
        document.querySelectorAll('.color-box').forEach(function(box) {
            box.addEventListener('click', function() {
                document.querySelectorAll('.color-box').forEach(function(el) {
                    el.classList.remove('active');
                });
                this.classList.add('active');
                const colorId = this.getAttribute('data-color-id');
                document.getElementById('color-input').value = colorId;
            });
        });
        document.querySelectorAll('.size-box').forEach(function(box) {
            box.addEventListener('click', function() {
                document.querySelectorAll('.size-box').forEach(function(el) {
                    el.classList.remove('active');
                });
                this.classList.add('active');
                const sizeId = this.getAttribute('data-size-id');
                document.getElementById('size-input').value = sizeId;
            });
        });

        document.addEventListener('DOMContentLoaded', function() {

            document.querySelectorAll('.show-qr-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-id');
                    const productName = this.getAttribute('data-name');
                    const productUrl = this.getAttribute('data-url');

                    document.getElementById('product-name').textContent = productName;

                    document.getElementById('product-url').textContent = productUrl;

                    const qrCodeContainer = document.getElementById('qr-code-container');
                    qrCodeContainer.innerHTML = '';
                    const qr = new QRCode(qrCodeContainer, {
                        text: productUrl,
                        width: 300,
                        height: 300
                    });


                    const qrCodeModal = new bootstrap.Modal(document.getElementById('qrCodeModal'));
                    qrCodeModal.show();
                });
            });
        });

        $(document).ready(function() {

            $('.view-detail-btn').click(function() {
                const productId = $(this).data('id'); // Lấy ID sản phẩm
                const modalContent = $('#productDetailContent');

                $.ajax({
                    url: `/admin/inventory/${productId}`,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        if (data.status == 'success') {
                            const product = data.product;
                            $('.text-notification').addClass('d-none');
                            $('.infomation-product').removeClass('d-none');
                            $('#productImage').attr('src', product.image_url); // Ảnh sản phẩm
                            $('#productName').text(product.name);
                            $('#productCategory').text(product.category.title);
                            $('#productBrand').text(product.brand.name);
                            $('#productPrice').text(product.priceProduct);
                            if (product.type_product == 'product_simple') {
                                $('#title-name').text('Tên sản phẩm');
                                // Tạo bảng
                                let variantsTable = '';
                                variantsTable += `
                                            <tr>
                                                <td>1</td>
                                                <td>${product.name}</td>
                                                <td>${product.priceProduct}{{ $generalSettings->currency_icon }}</td>
                                                <td>${data.sold}</td>
                                                <td>${product.qty}</td>
                                            </tr>
                                        `;
                                // Hiển thị bảng biến thể
                                $('#productVariantsTable').html(variantsTable);
                            } else {
                                $('#title-name').text('Tên biến thể');
                                // Tạo bảng biến thể
                                let variantsTable = '';
                                data.variants.forEach((variant, index) => {
                                    variantsTable += `
                                            <tr>
                                                <td>${index + 1}</td>
                                                <td>${variant.name}</td>
                                                <td>${variant.priceVariant}{{ $generalSettings->currency_icon }}</td>
                                                <td>${variant.sold}</td>
                                                <td>${variant.qty}</td>
                                            </tr>
                                        `;
                                });

                                // Hiển thị bảng biến thể
                                $('#productVariantsTable').html(variantsTable);
                            }
                        } else if (data.status == 'error') {
                            modalContent.html(
                                '<div class="text-danger">Không thể tải chi tiết sản phẩm.</div>'
                            );
                        }
                    },
                    error: function(error) {
                        modalContent.html(
                            '<div class="text-danger">Có lỗi xảy ra, vui lòng thử lại.</div>'
                        );
                    },
                })

                // Hiển thị modal
                $('#productDetailModal').modal('show');
            });



            // Xử lý sự kiện cho nút thương hiệu
            // $('#toggle-brand').click(function() {
            //     var brandList = $('#filter-brand');
            //     if (brandList.hasClass('d-none')) {
            //         brandList.removeClass('d-none'); // Hiện danh sách
            //         brandList.slideDown(300); // Thêm hiệu ứng mượt mà
            //         $(this).text('-'); // Thay đổi chữ trên nút
            //     } else {
            //         brandList.slideUp(300, function() {
            //             brandList.addClass('d-none'); // Ẩn danh sách sau khi hiệu ứng xong
            //         });
            //         $(this).text('+'); // Thay đổi chữ trên nút
            //     }
            // });

            // Xử lý sự kiện cho nút danh mục
            // $('#toggle-category').click(function() {
            //     var categoryList = $('#filter-category');
            //     if (categoryList.hasClass('d-none')) {
            //         categoryList.removeClass('d-none'); // Hiện danh sách
            //         categoryList.slideDown(300); // Thêm hiệu ứng mượt mà
            //         $(this).text('-'); // Thay đổi chữ trên nút
            //     } else {
            //         categoryList.slideUp(300, function() {
            //             categoryList.addClass('d-none'); // Ẩn danh sách sau khi hiệu ứng xong
            //         });
            //         $(this).text('+'); // Thay đổi chữ trên nút
            //     }
            // });

            // Xử lý sự kiện cho nút màu sắc
            $('#toggle-color').click(function(e) {
                e.preventDefault();
                var colorContainer = $('#filter-color');
                if (colorContainer.hasClass('d-none')) {
                    colorContainer.removeClass('d-none'); // Hiện danh sách
                    colorContainer.slideDown(300); // Thêm hiệu ứng mượt mà
                    $(this).text('-'); // Thay đổi biểu tượng trên nút
                } else {
                    colorContainer.slideUp(300, function() {
                        colorContainer.addClass('d-none'); // Ẩn danh sách sau khi hiệu ứng xong
                    });
                    $(this).text('+'); // Thay đổi biểu tượng trên nút
                }
            });

            // Xử lý sự kiện cho nút kích thước
            $('#toggle-size').click(function(e) {
                e.preventDefault();
                var sizeContainer = $('#filter-size');
                if (sizeContainer.hasClass('d-none')) {
                    sizeContainer.removeClass('d-none'); // Hiện danh sách
                    sizeContainer.slideDown(300); // Thêm hiệu ứng mượt mà
                    $(this).text('-'); // Thay đổi biểu tượng trên nút
                } else {
                    sizeContainer.slideUp(300, function() {
                        sizeContainer.addClass('d-none'); // Ẩn danh sách sau khi hiệu ứng xong
                    });
                    $(this).text('+'); // Thay đổi biểu tượng trên nút
                }
            });

        });
    </script>
@endpush
