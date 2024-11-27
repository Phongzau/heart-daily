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
            background-color: #007bff;
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
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h4>Bộ lọc</h4>
                        </div>
                        <div class="card-body">
                            <!-- Tìm theo tên -->
                            <div class="form-group">
                                <label for="filter-name">Tìm theo tên</label>
                                <input type="text" class="form-control" id="filter-name" placeholder="Nhập tên sản phẩm">
                            </div>

                            <div class="form-group">
                                <label>Thương hiệu</label>
                                <button class="btn btn-link p-0  float-right text-primary" id="toggle-brand">-</button>
                                <ul class="list-group" id="filter-brand">
                                    <li class="list-group-item">
                                        <input type="checkbox" value="brand1" id="brand1">
                                        <label for="brand1">Thương hiệu 1</label>
                                    </li>
                                    <li class="list-group-item">
                                        <input type="checkbox" value="brand2" id="brand2">
                                        <label for="brand2">Thương hiệu 2</label>
                                    </li>
                                    <li class="list-group-item">
                                        <input type="checkbox" value="brand3" id="brand3">
                                        <label for="brand3">Thương hiệu 3</label>
                                    </li>
                                </ul>
                            </div>

                            <!-- Tìm theo giá -->
                            <div class="form-group">
                                <label>Giá tiền</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="filter-price-min"
                                        placeholder="Tối thiểu">
                                    <input type="number" class="form-control" id="filter-price-max" placeholder="Tối đa">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Danh mục sản phẩm</label>
                                <button class="btn btn-link p-0  float-right text-primary" id="toggle-category">-</button>
                                <ul class="list-group" id="filter-category">
                                    <li class="list-group-item">
                                        <input type="checkbox" value="cat1" id="cat1">
                                        <label for="cat1">Danh mục 1</label>
                                    </li>
                                    <li class="list-group-item">
                                        <input type="checkbox" value="cat2" id="cat2">
                                        <label for="cat2">Danh mục 2</label>
                                    </li>
                                    <li class="list-group-item">
                                        <input type="checkbox" value="cat3" id="cat3">
                                        <label for="cat3">Danh mục 3</label>
                                    </li>
                                </ul>
                            </div>

                            <div class="form-group">
                                <label>MÀU</label>
                                <button class="btn btn-link p-0 float-right text-primary" id="toggle-color">-</button>
                                <div class="color-box-container" id="filter-color">
                                    <div class="color-box" style="background-color: black;" data-value="black"></div>
                                    <div class="color-box" style="background-color: brown;" data-value="brown"></div>
                                    <div class="color-box" style="background-color: red;" data-value="red"></div>
                                    <div class="color-box" style="background-color: green;" data-value="green"></div>
                                    <div class="color-box" style="background-color: yellow;" data-value="yellow"></div>
                                    <div class="color-box" style="background-color: blue;" data-value="blue"></div>
                                    <div class="color-box" style="background-color: gray;" data-value="gray"></div>
                                    <div class="color-box" style="background-color: pink;" data-value="pink"></div>
                                    <!-- Thêm màu khác tương tự -->
                                </div>
                            </div>

                            <!-- Kích thước -->
                            <div class="form-group">
                                <label>KÍCH CỠ</label>
                                <button class="btn btn-link p-0 float-right text-primary" id="toggle-size">-</button>
                                <div class="size-box-container" id="filter-size">
                                    <div class="size-box" data-value="S">S</div>
                                    <div class="size-box" data-value="M">M</div>
                                    <div class="size-box" data-value="L">L</div>
                                    <div class="size-box" data-value="XL">XL</div>
                                    <div class="size-box" data-value="40">40</div>
                                    <div class="size-box" data-value="41">41</div>
                                    <div class="size-box" data-value="42">42</div>
                                    <div class="size-box" data-value="43">43</div>
                                    <!-- Thêm kích thước khác tương tự -->
                                </div>
                            </div>

                            <!-- Nút Tìm kiếm và Clear All -->
                            <div class="form-group text-center">
                                <button class="btn btn-primary btn-block" id="filter-apply">Tìm kiếm</button>
                                <button class="btn btn-secondary btn-block" id="filter-clear">Clear All</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h4>Danh sách sản phẩm</h4>
                        
                        <div class="card-header-action">
                            <a href="{{ route('admin.inventory.export') }}" class="btn btn-outline-success"><i class="fa-light fa-file-excel fa-lg"></i> Excel</a>
                        </div></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Hình ảnh</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Giá nhập</th>
                                            <th>Tồn kho(số lượng)</th>
                                            <th>Loại SP</th>
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
                                                    <td>
                                                        <span
                                                            class="product-name float-left">{{ limitText($product->name, 35) }}</span>
                                                        <br>
                                                        <span class="product-category float-left">
                                                            {{ $product->category->title }}
                                                            - {{ $product->brand->name }} </span>
                                                    </td>
                                                    <td>
                                                        {{-- @if ($product->type_product === 'product_simple')
                                                            {{ checkDiscount($product) ? number_format($product->offer_price) . ' VND' : number_format($product->price) . ' VND' }}
                                                        @else
                                                            @php
                                                                $totalPrice = 0;
                                                                foreach ($product->ProductVariants as $productVariant) {
                                                                    if ($productVariant->offer_price_variant > 0) {
                                                                        $totalPrice +=
                                                                            $productVariant->offer_price_variant;
                                                                    } else {
                                                                        $totalPrice += $productVariant->price_variant;
                                                                    }
                                                                }
                                                            @endphp
                                                            {{ number_format($totalPrice) . ' VND' }}
                                                        @endif --}}
                                                        {{ number_format($product->price_import) . ' VND' }}
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
                                                    <td> <button class="btn btn-outline-primary view-detail-btn"
                                                            data-id="{{ $product->id }}" title="Chi tiết"><i
                                                                class="fa-solid fa-info"></i></button>
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
    <script>
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
                                                <td>${product.priceProduct}</td>
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
                                                <td>${variant.priceVariant}</td>
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
            $('#toggle-brand').click(function() {
                var brandList = $('#filter-brand');
                if (brandList.hasClass('d-none')) {
                    brandList.removeClass('d-none'); // Hiện danh sách
                    brandList.slideDown(300); // Thêm hiệu ứng mượt mà
                    $(this).text('-'); // Thay đổi chữ trên nút
                } else {
                    brandList.slideUp(300, function() {
                        brandList.addClass('d-none'); // Ẩn danh sách sau khi hiệu ứng xong
                    });
                    $(this).text('+'); // Thay đổi chữ trên nút
                }
            });

            // Xử lý sự kiện cho nút danh mục
            $('#toggle-category').click(function() {
                var categoryList = $('#filter-category');
                if (categoryList.hasClass('d-none')) {
                    categoryList.removeClass('d-none'); // Hiện danh sách
                    categoryList.slideDown(300); // Thêm hiệu ứng mượt mà
                    $(this).text('-'); // Thay đổi chữ trên nút
                } else {
                    categoryList.slideUp(300, function() {
                        categoryList.addClass('d-none'); // Ẩn danh sách sau khi hiệu ứng xong
                    });
                    $(this).text('+'); // Thay đổi chữ trên nút
                }
            });

            // Xử lý sự kiện cho nút màu sắc
            $('#toggle-color').click(function() {
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
            $('#toggle-size').click(function() {
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
