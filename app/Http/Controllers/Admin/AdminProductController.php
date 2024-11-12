<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ProductDataTable;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\CategoryAttribute;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductImageGallery;
use App\Models\ProductVariant;
use App\Models\Tag;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(ProductDataTable $dataTable)
    {
        return $dataTable->render('admin.page.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::query()->where('status', 1)->get();
        $tags = Tag::all();
        $categories = CategoryProduct::query()->where(['parent_id' => 0, 'status' => '1'])->get();
        return view('admin.page.product.create', compact('categories', 'brands', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // dd($request->all());
        // Tạo mảng chứa các quy tắc chung
        $rules = [
            'tags' => 'array',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:products,sku',
            'price' => 'required|numeric|min:0',
            'offer_price' => 'nullable|numeric|min:0|lt:price',
            'offer_start_date' => 'nullable|date|before_or_equal:offer_end_date',
            'offer_end_date' => 'nullable|date|after_or_equal:offer_start_date',
            'short_description' => 'required|string|max:500',
            'long_description' => 'required|string',
            'status' => 'required|boolean',
            'type_product' => 'required',
            'category_id' => 'required|integer|exists:category_products,id',
            'brand_id' => 'required|integer|exists:brands,id',
            'image_main' => 'required',
        ];



        // Nếu là sản phẩm đơn giản
        if ($request->type_product === 'product_simple') {
            $rules['qty'] = 'required|numeric|min:0';
        }

        // Xác định các thông báo lỗi
        $messages = [
            // tag



            'tags.array' => 'Tags phải là một mảng hợp lệ.',

            // Tên sản phẩm
            'name.required' => 'Tên sản phẩm là bắt buộc.',
            'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',

            // SKU
            'sku.required' => 'SKU là bắt buộc.',
            'sku.max' => 'SKU không được vượt quá 255 ký tự.',
            'sku.unique' => 'SKU này đã tồn tại.',

            // Giá và khuyến mãi
            'price.required' => 'Giá sản phẩm là bắt buộc.',
            'price.numeric' => 'Giá sản phẩm phải là một số.',
            'price.min' => 'Giá sản phẩm phải lớn hơn hoặc bằng 0.',
            'offer_price.numeric' => 'Giá khuyến mãi phải là một số.',
            'offer_price.min' => 'Giá khuyến mãi phải lớn hơn hoặc bằng 0.',
            'offer_price.lt' => 'Giá khuyến mãi phải nhỏ hơn giá gốc.',

            // Ngày khuyến mãi
            'offer_start_date.date' => 'Ngày bắt đầu khuyến mãi phải là ngày hợp lệ.',
            'offer_start_date.before_or_equal' => 'Ngày bắt đầu khuyến mãi phải trước hoặc bằng ngày kết thúc khuyến mãi.',
            'offer_end_date.date' => 'Ngày kết thúc khuyến mãi phải là ngày hợp lệ.',
            'offer_end_date.after_or_equal' => 'Ngày kết thúc khuyến mãi phải sau hoặc bằng ngày bắt đầu khuyến mãi.',

            // Mô tả
            'short_description.required' => 'Mô tả ngắn là bắt buộc.',
            'short_description.max' => 'Mô tả ngắn không được vượt quá 500 ký tự.',
            'long_description.required' => 'Mô tả dài là bắt buộc.',

            // Trạng thái
            'status.required' => 'Trạng thái sản phẩm là bắt buộc.',
            'status.boolean' => 'Trạng thái sản phẩm phải là giá trị đúng hoặc sai.',

            // Loại sản phẩm
            'type_product.required' => 'Loại sản phẩm là bắt buộc.',
            'type_product.in' => 'Loại sản phẩm không hợp lệ.',

            // Danh mục và thương hiệu
            'category_id.required' => 'Danh mục sản phẩm là bắt buộc.',
            'category_id.integer' => 'Danh mục sản phẩm không hợp lệ.',
            'category_id.exists' => 'Danh mục sản phẩm không tồn tại.',
            'brand_id.required' => 'Thương hiệu sản phẩm là bắt buộc.',
            'brand_id.integer' => 'Thương hiệu sản phẩm không hợp lệ.',
            'brand_id.exists' => 'Thương hiệu sản phẩm không tồn tại.',

            // Hình ảnh chính
            'image_main.required' => 'Ảnh chính là bắt buộc.',
            'image_main.image' => 'File phải là ảnh.',
            // 'variant.*.qty.required' => 'Số lượng là bắt buộc.',
            // 'variant.*.qty.numeric' => 'Số lượng phải là một số.',
            // 'variant.*.qty.min' => 'Số lượng phải lớn hơn 0.',
            // 'variant.*.variant_id.required' => 'Thuộc tính biến thể không được bỏ trống.',
            // 'variant.*.variant_id.array' => 'variant_id phải là một mảng.',
            // 'variant.*.variant_id.min' => 'Ít nhất một variant_id là bắt buộc.',
            // 'variant.*.variant_id.*.required' => 'Tất cả thuộc tính biến thể không được bỏ trống.',
            // 'variant.*.variant_id.*.exists' => 'Thuộc tính không tồn tại không tồn tại.',
            // 'variant.*.value_id.required' => 'Giá trị thuộc tính không được để trống.',
            // 'variant.*.value_id.array' => 'value_id phải là một mảng.',
            // 'variant.*.value_id.min' => 'Ít nhất một value_id là bắt buộc.',
            // 'variant.*.value_id.*.required' => 'Tất cả giá trị thuộc tính không được để trống.',
            // 'variant.*.value_id.*.exists' => 'Giá trị thuộc tính không tồn tại.',
        ];
        $request->validate($rules, $messages);
        // Bắt đầu transaction
        DB::beginTransaction();
        try {
            $imagePath = $this->uploadImage($request, 'image_main', 'products');
            if ($request->type_product === 'product_variant') {
                // Thực hiện validate với toàn bộ các quy tắc
                $product = new Product();
                $product->type_product = $request->type_product;
                $product->name = $request->name;
                $product->slug = Str::slug($request->name);
                $product->sku = $request->sku;
                $product->price = $request->price;
                $product->offer_price = $request->offer_price;
                $product->image = $imagePath;
                if (is_array($request->tags)) {
                    // Chuyển tất cả các giá trị trong mảng tags thành số nguyên
                    $product->id_tags = json_encode(array_map('intval', $request->tags));
                } else {
                    // Nếu không phải mảng, gán id_tags là null
                    $product->id_tags = null;
                }
                $product->offer_start_date = $request->offer_start_date;
                $product->offer_end_date = $request->offer_end_date;
                $product->short_description = $request->short_description;
                $product->long_description = $request->long_description;
                $product->status = $request->status;
                $product->category_id = $request->category_id;
                $product->brand_id = $request->brand_id;
                $product->userid_created = Auth::user()->id;
                $product->save();




                // Chuyển đổi từ JSON string thành mảng
                $attributeData = json_decode($request->input('attributeData'), true);

                if (is_array($attributeData) && !empty($attributeData)) {
                    foreach ($attributeData as $attribute) {
                        if (isset($attribute['id'], $attribute['values']) && is_array($attribute['values'])) {
                            $categoryAttributeId = $attribute['id'];
                            $values = $attribute['values'];

                            $productAttribute = new ProductAttribute();
                            $productAttribute->product_id = $product->id;
                            $productAttribute->category_attribute_id = $categoryAttributeId;
                            $productAttribute->name_category_attribute = $attribute['name'];
                            $productAttribute->id_attributes = json_encode($values);
                            $productAttribute->save();
                        } else {
                            return response()->json([
                                'status' => 'error',
                                'message' => 'Thuộc tính hoặc giá trị thuộc tính bị thiếu.'
                            ]);
                        }
                    }
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Dữ liệu thuộc tính bị thiếu',
                    ]);
                }

                // Xử lý variant data
                $variantsArray = json_decode($request->input('variants'), true);

                if (is_array($variantsArray) && !empty($variantsArray)) {
                    foreach ($variantsArray as $variant) {
                        if (
                            isset($variant['value_variant'], $variant['price_variant'], $variant['qty_variant']) &&
                            is_array($variant['title_variant']) &&
                            is_numeric($variant['price_variant']) &&
                            is_numeric($variant['qty_variant'])
                        ) {
                            $productVariant = new ProductVariant();
                            $productVariant->product_id = $product->id;
                            $productVariant->id_variant = json_encode(array_map('intval', $variant['value_variant']));
                            $productVariant->title_variant = json_encode($variant['title_variant']);
                            $productVariant->price_variant = $variant['price_variant'];
                            $productVariant->qty = $variant['qty_variant'];
                            $productVariant->save();
                        } else {
                            return response()->json([
                                'status' => 'error',
                                'message' => 'Dữ liệu biến thể không hợp lệ.',
                            ]);
                        }
                    }
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Dữ liệu biến thể bị thiếu',
                    ]);
                }
            } else if ($request->type_product === 'product_simple') {
                $product = new Product();
                $product->type_product = $request->type_product;
                $product->name = $request->name;
                $product->slug = Str::slug($request->name);
                $product->sku = $request->sku;
                $product->price = $request->price;
                $product->offer_price = $request->offer_price;
                $product->image = $imagePath;
                if (is_array($request->tags)) {
                    $product->id_tags = json_encode(array_map('intval', $request->tags));
                } else {
                    $product->id_tags = json_encode([]); // Hoặc bạn có thể gán null hoặc một giá trị mặc định khác
                }
                $product->offer_start_date = $request->offer_start_date;
                $product->offer_end_date = $request->offer_end_date;
                $product->short_description = $request->short_description;
                $product->long_description = $request->long_description;
                $product->status = $request->status;
                $product->category_id = $request->category_id;
                $product->brand_id = $request->brand_id;
                $product->qty = $request->qty;
                $product->userid_created = Auth::user()->id;
                $product->save();
            }
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Thêm sản phẩm thành công',
                'data' => $product,
            ]);
        } catch (\Exception $e) {
            // Nếu có lỗi, rollback transaction
            DB::rollBack();

            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function uploadImageGalleries(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'album' => ['required', 'array'],
            // 'album.*' => ['image'],
        ], [
            'product_id.required' => 'ProductId không có',
            'product_id.exists' => 'Sản phẩm không tồn tại',
            'album.required' => 'Phải có ít nhất một ảnh để tải lên',
            // 'album.*.image' => 'File phải là hình ảnh',
        ]);
        $productId = $request->product_id;

        $imagePaths = $this->uploadMultipleImage($request, 'album', 'products');

        if (empty($imagePaths)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tải lên được ảnh nào',
            ], 400);
        }

        foreach ($imagePaths as $path) {
            $image = new ProductImageGallery();
            $image->product_id = $productId;
            $image->image = $path;
            $image->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Thêm ảnh thành công',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::query()->with(['ProductVariants', 'ProductImageGalleries', 'ProductAttributes'])->findOrFail($id);
        $categoryAttributes = CategoryAttribute::query()->get();
        $brands = Brand::query()->where('status', 1)->get();
        $categories = CategoryProduct::query()->where(['parent_id' => 0, 'status' => '1'])->get();
        $tags = Tag::all();
        $selectedTags = json_decode($product->id_tags, true) ?? [];
        // Chuyển đổi dữ liệu sang định dạng JavaScript
        $convertedData = [];
        $formattedVariants = [];
        if ($product->type_product == 'product_variant') {
            foreach ($product->ProductAttributes as $attribute) {
                $idAttributes = json_decode($attribute['id_attributes'], true); // Chuyển đổi chuỗi JSON thành mảng

                $values = [];
                foreach ($idAttributes as $key => $value) {
                    $values[$key] = $value; // Tạo mảng giá trị
                }

                $convertedData[] = [
                    'id' => strval($attribute['category_attribute_id']),
                    'name' => $attribute['name_category_attribute'], // Sử dụng tên thuộc tính
                    'values' => $values,
                ];
            }
            foreach ($product->ProductVariants as $variant) {
                $idKey = implode('_', json_decode($variant['id_variant'], true));
                $formattedVariants[$idKey] = [
                    'value_variant' => array_map('strval', json_decode($variant['id_variant'], true)),
                    'title_variant' => json_decode($variant['title_variant'], true),
                    'price_variant' => $variant['price_variant'],
                    'qty_variant' => $variant['qty'],
                ];
            }
        }
        return view('admin.page.product.edit', compact('product', 'brands', 'categories', 'categoryAttributes', 'convertedData', 'formattedVariants', 'tags', 'selectedTags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        // Tạo mảng chứa các quy tắc chung
        $rules = [
            'tags' => 'nullable|array',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:products,sku,' . $id,
            'price' => 'required|numeric|min:0',
            'offer_price' => 'nullable|numeric|min:0|lt:price',
            'offer_start_date' => 'nullable|date|before_or_equal:offer_end_date',
            'offer_end_date' => 'nullable|date|after_or_equal:offer_start_date',
            'short_description' => 'required|string|max:500',
            'long_description' => 'required|string',
            'status' => 'required|boolean',
            'type_product' => 'required',
            'category_id' => 'required|integer|exists:category_products,id',
            'brand_id' => 'required|integer|exists:brands,id',
            'image_main' => 'nullable', //image
        ];

        // Nếu là sản phẩm đơn giản
        if ($request->type_product === 'product_simple') {
            $rules['qty'] = 'required|numeric|min:0';
        }

        // Xác định các thông báo lỗi
        $messages = [
            // Tên sản phẩm
            'name.required' => 'Tên sản phẩm là bắt buộc.',
            'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',

            // SKU
            'sku.required' => 'SKU là bắt buộc.',
            'sku.max' => 'SKU không được vượt quá 255 ký tự.',
            'sku.unique' => 'SKU này đã tồn tại.',

            // Giá và khuyến mãi
            'price.required' => 'Giá sản phẩm là bắt buộc.',
            'price.numeric' => 'Giá sản phẩm phải là một số.',
            'price.min' => 'Giá sản phẩm phải lớn hơn hoặc bằng 0.',
            'offer_price.numeric' => 'Giá khuyến mãi phải là một số.',
            'offer_price.min' => 'Giá khuyến mãi phải lớn hơn hoặc bằng 0.',
            'offer_price.lt' => 'Giá khuyến mãi phải nhỏ hơn giá gốc.',

            // Ngày khuyến mãi
            'offer_start_date.date' => 'Ngày bắt đầu khuyến mãi phải là ngày hợp lệ.',
            'offer_start_date.before_or_equal' => 'Ngày bắt đầu khuyến mãi phải trước hoặc bằng ngày kết thúc khuyến mãi.',
            'offer_end_date.date' => 'Ngày kết thúc khuyến mãi phải là ngày hợp lệ.',
            'offer_end_date.after_or_equal' => 'Ngày kết thúc khuyến mãi phải sau hoặc bằng ngày bắt đầu khuyến mãi.',

            // Mô tả
            'short_description.required' => 'Mô tả ngắn là bắt buộc.',
            'short_description.max' => 'Mô tả ngắn không được vượt quá 500 ký tự.',
            'long_description.required' => 'Mô tả dài là bắt buộc.',

            // Trạng thái
            'status.required' => 'Trạng thái sản phẩm là bắt buộc.',
            'status.boolean' => 'Trạng thái sản phẩm phải là giá trị đúng hoặc sai.',

            // Loại sản phẩm
            'type_product.required' => 'Loại sản phẩm là bắt buộc.',
            'type_product.in' => 'Loại sản phẩm không hợp lệ.',

            // Danh mục và thương hiệu
            'category_id.required' => 'Danh mục sản phẩm là bắt buộc.',
            'category_id.integer' => 'Danh mục sản phẩm không hợp lệ.',
            'category_id.exists' => 'Danh mục sản phẩm không tồn tại.',
            'brand_id.required' => 'Thương hiệu sản phẩm là bắt buộc.',
            'brand_id.integer' => 'Thương hiệu sản phẩm không hợp lệ.',
            'brand_id.exists' => 'Thương hiệu sản phẩm không tồn tại.',

            // Hình ảnh chính
            'image_main.image' => 'File phải là ảnh.',
        ];
        $request->validate($rules, $messages);
        // Bắt đầu transaction
        DB::beginTransaction();
        try {
            $product = Product::query()->findOrFail($id);
            $imagePath = $this->updateImage2($request, 'image_main', $product->image, 'products');
            if ($request->type_product === 'product_variant') {
                // Thực hiện validate với toàn bộ các quy tắc
                $product->type_product = $request->type_product;
                $product->name = $request->name;
                $product->slug = Str::slug($request->name);
                $product->sku = $request->sku;
                $product->price = $request->price;
                $product->offer_price = $request->offer_price;
                $product->image = $imagePath;
                $product->offer_start_date = $request->offer_start_date;
                $product->offer_end_date = $request->offer_end_date;
                $product->short_description = $request->short_description;
                $product->long_description = $request->long_description;
                $product->status = $request->status;
                $product->category_id = $request->category_id;
                $product->brand_id = $request->brand_id;
                $product->userid_created = Auth::user()->id;
                $product->qty = null;
                if (is_array($request->tags)) {
                    // Chuyển tất cả các giá trị trong mảng tags thành số nguyên
                    $product->id_tags = json_encode(array_map('intval', $request->tags));
                } else {
                    // Nếu không phải mảng, gán id_tags là null
                    $product->id_tags = null;
                }
                $product->save();

                // Chuyển đổi từ JSON string thành mảng
                $attributeData = json_decode(
                    $request->input('attributeData'),
                    true
                );

                if (is_array($attributeData) && !empty($attributeData)) {
                    foreach ($attributeData as $attribute) {
                        if (isset($attribute['id'], $attribute['values']) && is_array($attribute['values'])) {
                            $categoryAttributeId = $attribute['id'];
                            $values = $attribute['values'];
                            $productAttribute = ProductAttribute::query()
                                ->where([
                                    'product_id' => $product->id,
                                    'category_attribute_id' => $categoryAttributeId
                                ])
                                ->first() ?? new ProductAttribute();

                            $productAttribute->product_id = $product->id;
                            $productAttribute->category_attribute_id = $categoryAttributeId;
                            $productAttribute->name_category_attribute = $attribute['name'];
                            $productAttribute->id_attributes = json_encode($values);

                            $productAttribute->save();
                        } else {
                            return response()->json([
                                'status' => 'error',
                                'message' => 'Thuộc tính hoặc giá trị thuộc tính bị thiếu.'
                            ]);
                        }
                    }
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Dữ liệu thuộc tính bị thiếu',
                    ]);
                }

                // Xử lý variant data
                $variantsArray = json_decode($request->input('variants'), true);

                if (is_array($variantsArray) && !empty($variantsArray)) {
                    foreach ($variantsArray as $variant) {
                        if (
                            isset($variant['value_variant'], $variant['price_variant'], $variant['qty_variant']) &&
                            is_array($variant['title_variant']) &&
                            is_numeric($variant['price_variant']) &&
                            is_numeric($variant['qty_variant'])
                        ) {
                            // Tạo khóa unique cho variant dựa vào 'value_variant'
                            $idVariant = json_encode(array_map('intval', $variant['value_variant']));

                            $productVariant = ProductVariant::where([
                                'product_id' => $product->id,
                                'id_variant' => $idVariant
                            ])->first();

                            // Nếu biến thể tồn tại, cập nhật; nếu không, tạo mới
                            if (!$productVariant) {
                                $productVariant = new ProductVariant();
                                $productVariant->product_id = $product->id;
                                $productVariant->id_variant = $idVariant;
                            }

                            // Cập nhật hoặc thiết lập các giá trị khác
                            $productVariant->title_variant = json_encode($variant['title_variant']);
                            $productVariant->price_variant = $variant['price_variant'];
                            $productVariant->qty = $variant['qty_variant'];
                            $productVariant->save();
                        } else {
                            return response()->json([
                                'status' => 'error',
                                'message' => 'Dữ liệu biến thể không hợp lệ.',
                            ]);
                        }
                    }
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Dữ liệu biến thể bị thiếu',
                    ]);
                }
            } else if ($request->type_product === 'product_simple') {
                $product->type_product = $request->type_product;
                $product->name = $request->name;
                $product->slug = Str::slug($request->name);
                $product->sku = $request->sku;
                $product->price = $request->price;
                $product->offer_price = $request->offer_price;
                $product->image = $imagePath;
                $tags = $request->input('tags', []);
                $product->offer_start_date = $request->offer_start_date;
                $product->offer_end_date = $request->offer_end_date;
                $product->short_description = $request->short_description;
                $product->long_description = $request->long_description;
                $product->status = $request->status;
                $product->category_id = $request->category_id;
                $product->brand_id = $request->brand_id;
                $product->qty = $request->qty;
                $product->userid_created = Auth::user()->id;
                $product->save();

                // Xóa các thuộc tính và biến thể hiện có nếu tồn tại
                $product->ProductAttributes()->delete();
                $product->ProductVariants()->delete();
            }

            // Lấy các ID ảnh đã xóa từ request
            $deletedImageIds = json_decode($request->deletedImageIds, true);

            // Xóa các ảnh cũ
            if (!empty($deletedImageIds)) {
                foreach ($deletedImageIds as $imageId) {
                    $image = ProductImageGallery::find($imageId);
                    if ($image) {
                        // Xóa file khỏi thư mục lưu trữ
                        $this->deleteImage($image->image);

                        // Xóa ảnh khỏi cơ sở dữ liệu
                        $image->delete();
                    }
                }
            }

            if ($imagePath !== $product->getOriginal('image')) {
                $this->deleteImage($product->getOriginal('image'));
            }

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật sản phẩm thành công',
                'data' => $product,
            ]);
        } catch (\Exception $e) {
            // Nếu có lỗi, rollback transaction
            DB::rollBack();

            // Nếu có lỗi và ảnh mới đã được upload, xóa ảnh mới
            $this->deleteImage($imagePath);

            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroyProductAttribute(string $id)
    {
        $productAttribute = ProductAttribute::query()->findOrFail($id);
        $nameAttr = $productAttribute->name_category_attribute;
        $productAttribute->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Xóa thuộc tính ' . $nameAttr .  ' thành công',
        ]);
    }

    public function changeStatus(Request $request)
    {
        $product = Product::query()->findOrFail($request->id);
        $product->status = $request->status == 'true' ? 1 : 0;
        $product->save();

        return response([
            'message' => 'Cập nhật trạng thái thành công',
        ]);
    }

    public function destroyVariant(string $id)
    {
        $productVariant = ProductVariant::query()->findOrFail($id);
        $productVariant->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Xóa biến thể sản phẩm thành công',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::transaction(function () use ($id) {
                // Tìm sản phẩm
                $product = Product::query()->findOrFail($id);

                // Lấy danh sách biến thể và hình ảnh từ mối quan hệ
                $productVariants = $product->ProductVariants; // Sử dụng mối quan hệ
                $productImages = $product->ProductImageGalleries; // Sử dụng mối quan hệ

                // Xóa hình ảnh
                if ($productImages->isNotEmpty()) {
                    foreach ($productImages as $image) {
                        $this->deleteImage($image->image);
                        $image->delete();
                    }
                }

                // Xóa biến thể
                if ($productVariants->isNotEmpty()) {
                    foreach ($productVariants as $variant) {
                        $variant->delete();
                    }
                }

                // Cuối cùng, xóa sản phẩm
                $product->delete();
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Xóa sản phẩm thành công',
            ]);
        } catch (\Exception $e) {
            // Ghi log lỗi
            Log::error("Lỗi khi xóa sản phẩm: {$e->getMessage()}");

            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra khi xóa sản phẩm.',
            ], 500);
        }
    }
}
