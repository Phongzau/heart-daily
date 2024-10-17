<section class="section">
    <div class="section-header">
        <h1>Products</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Create Product</h4>
                    </div>
                </div>
            </div>
        </div>
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
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
                                        href="#product-variants" role="tab" aria-controls="product-variants"
                                        aria-selected="false">Dữ liệu sản
                                        phẩm</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="productTabContent">
                                <div class="tab-pane fade show active" id="product-info" role="tabpanel"
                                    aria-labelledby="product-info-tab">
                                    <!-- Nội dung về thông tin sản phẩm -->
                                    {{-- <div class="form-group">
                                            <div class="control-label">Type Product</div>
                                            <div class="custom-switches-stacked mt-2">
                                                <label class="custom-switch">
                                                    <input type="radio"
                                                        {{ old('type_product') === 'simple' ? 'checked' : '' }}
                                                        name="type_product" value="simple" class="custom-switch-input">
                                                    <span class="custom-switch-indicator"></span>
                                                    <span class="custom-switch-description">Simple</span>
                                                </label>
                                                <label class="custom-switch">
                                                    <input type="radio"
                                                        {{ old('type_product') === 'variant' ? 'checked' : '' }}
                                                        name="type_product" value="variant" class="custom-switch-input">
                                                    <span class="custom-switch-indicator"></span>
                                                    <span class="custom-switch-description">Variants</span>
                                                </label>
                                            </div>
                                        </div> --}}
                                    <div class="form-group">
                                        <label for="">Thumb Image</label>
                                        <input type="file" name="thumb_image" class="form-control">
                                    </div>
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
                                    <div class="form-group">
                                        <label for="">Price</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text" id="discount-unit">
                                                    đ
                                                </div>
                                            </div>
                                            <input type="number" name="price" value="{{ old('price') }}"
                                                class="form-control currency">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Offer Price</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text" id="discount-unit">
                                                    đ
                                                </div>
                                            </div>
                                            <input type="number" name="offer_price" value="{{ old('offer_price') }}"
                                                class="form-control currency">
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
                                                    value="{{ old('offer_end_date') }}" class="form-control datepicker">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="stock-quantity-group" class="form-group">
                                        <label for="">Stock Quantity</label>
                                        <input type="number" min="0" id="stock-quantity" name="qty"
                                            value="{{ old('qty') }}" class="form-control">
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
                                        <select id="inputState" name="status" value="{{ old('status') }}"
                                            class="form-control">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="product-variants" role="tabpanel"
                                    aria-labelledby="product-variants-tab">
                                    <!-- Nội dung về các biến thể của sản phẩm -->
                                    <button class="btn btn-light mt-2 btn-add-product-variant"><i class="fas fa-plus">
                                            Add product variant</i></button>
                                    <hr>
                                    <div class="mb-3 variant-group">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5>Biến thể 1</h5>
                                            <button class="btn btn-danger btn-remove-variant-group">Remove
                                            </button>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Name</label>
                                            <input type="text" name="variant[1][name]" class="form-control">
                                        </div>
                                        <button class="btn btn-light mb-3 btn-add-variant"><i class="fas fa-plus">
                                                Add variant</i></button>
                                        <div class="variant-attributes"></div>
                                        <hr>
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
                                <select id="inputState" name="category_id" class="form-control main-category">
                                    <option value="" hidden>Select</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="inputState">Brand</label>
                                <select id="inputState" name="brand_id" class="form-control">
                                    <option value="" hidden>Select</option>
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
                                    <img id="previewImage" src="{{ asset('admin/assets/img/news/img01.jpg') }}"
                                        class="imagecheck-image" alt="Ảnh đại diện"
                                        style="max-width: 100%; max-height: 100%;" />
                                </div>

                                <!-- Nút Upload và Select -->
                                <div class="d-flex justify-content-around mt-3">
                                    <input type="file" id="imageUpload" name="image_main" class="d-none"
                                        accept="image/*">
                                    <button class="btn btn-dark" id="uploadBtn">Upload file...</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h4>Multiple Upload</h4>
                        </div>
                        <div class="card-body">
                            <div style="border: 2px dashed #6777ef;" class="dropzone" id="my-awesome-dropzone"></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    </div>

    </div>
</section>

















<section class="section">
    <div class="section-header">
        <h1>Products</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Create Product</h4>
                    </div>
                </div>
            </div>
        </div>
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
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
                                        href="#product-variants" role="tab" aria-controls="product-variants"
                                        aria-selected="false">Dữ liệu sản
                                        phẩm</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="productTabContent">
                                <div class="tab-pane fade show active" id="product-info" role="tabpanel"
                                    aria-labelledby="product-info-tab">
                                    <!-- Nội dung về thông tin sản phẩm -->
                                    {{-- <div class="form-group">
                                            <div class="control-label">Type Product</div>
                                            <div class="custom-switches-stacked mt-2">
                                                <label class="custom-switch">
                                                    <input type="radio"
                                                        {{ old('type_product') === 'simple' ? 'checked' : '' }}
                                                        name="type_product" value="simple" class="custom-switch-input">
                                                    <span class="custom-switch-indicator"></span>
                                                    <span class="custom-switch-description">Simple</span>
                                                </label>
                                                <label class="custom-switch">
                                                    <input type="radio"
                                                        {{ old('type_product') === 'variant' ? 'checked' : '' }}
                                                        name="type_product" value="variant" class="custom-switch-input">
                                                    <span class="custom-switch-indicator"></span>
                                                    <span class="custom-switch-description">Variants</span>
                                                </label>
                                            </div>
                                        </div> --}}
                                    <div class="form-group">
                                        <label for="">Thumb Image</label>
                                        <input type="file" name="thumb_image" class="form-control">
                                    </div>
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
                                    <div class="form-group">
                                        <label for="">Price</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text" id="discount-unit">
                                                    đ
                                                </div>
                                            </div>
                                            <input type="number" name="price" value="{{ old('price') }}"
                                                class="form-control currency">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Offer Price</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text" id="discount-unit">
                                                    đ
                                                </div>
                                            </div>
                                            <input type="number" name="offer_price"
                                                value="{{ old('offer_price') }}" class="form-control currency">
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
                                    <div id="stock-quantity-group" class="form-group">
                                        <label for="">Stock Quantity</label>
                                        <input type="number" min="0" id="stock-quantity" name="qty"
                                            value="{{ old('qty') }}" class="form-control">
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
                                        <select id="inputState" name="status" value="{{ old('status') }}"
                                            class="form-control">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="product-variants" role="tabpanel"
                                    aria-labelledby="product-variants-tab">
                                    <!-- Nội dung về các biến thể của sản phẩm -->
                                    <button class="btn btn-light mt-2 btn-add-product-variant"><i class="fas fa-plus">
                                            Add product variant</i></button>
                                    <hr>
                                    <div class="mb-3 variant-group">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5>Biến thể 1</h5>
                                            <button class="btn btn-danger btn-remove-variant-group">Remove
                                            </button>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Name</label>
                                            <input type="text" name="variant[1][name]" class="form-control">
                                        </div>
                                        <button class="btn btn-light mb-3 btn-add-variant"><i class="fas fa-plus">
                                                Add variant</i></button>
                                        <div class="variant-attributes"></div>
                                        <hr>
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
                                <select id="inputState" name="category_id" class="form-control main-category">
                                    <option value="" hidden>Select</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="inputState">Brand</label>
                                <select id="inputState" name="brand_id" class="form-control">
                                    <option value="" hidden>Select</option>
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
                                    <img id="previewImage" src="{{ asset('admin/assets/img/news/img01.jpg') }}"
                                        class="imagecheck-image" alt="Ảnh đại diện"
                                        style="max-width: 100%; max-height: 100%;" />
                                </div>

                                <!-- Nút Upload và Select -->
                                <div class="d-flex justify-content-around mt-3">
                                    <input type="file" id="imageUpload" name="image_main" class="d-none"
                                        accept="image/*">
                                    <button class="btn btn-dark" id="uploadBtn">Upload file...</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h4>Multiple Upload</h4>
                        </div>
                        <div class="card-body">
                            <div style="border: 2px dashed #6777ef;" class="dropzone" id="my-awesome-dropzone"></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    </div>

    </div>
</section>
