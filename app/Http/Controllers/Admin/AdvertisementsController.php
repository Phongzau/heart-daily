<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

class AdvertisementsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use ImageUploadTrait;

    public function index()
    {
        $homepage_section_banner_one = Advertisement::query()->where('key', 'homepage_section_banner_one')->first();
        $homepage_section_banner_one = json_decode($homepage_section_banner_one?->value);

        $homepage_section_banner_two = Advertisement::query()->where('key', 'homepage_section_banner_two')->first();
        $homepage_section_banner_two = json_decode($homepage_section_banner_two?->value);

        $homepage_section_banner_three = Advertisement::query()->where('key', 'homepage_section_banner_three')->first();
        $homepage_section_banner_three = json_decode($homepage_section_banner_three?->value);

        $homepage_section_banner_four = Advertisement::query()->where('key', 'homepage_section_banner_four')->first();
        $homepage_section_banner_four = json_decode($homepage_section_banner_four?->value);

        $product_page_banner_section = Advertisement::query()->where('key', 'product_page_banner_section')->first();
        $product_page_banner_section = json_decode($product_page_banner_section?->value);

        $cart_page_banner_section = Advertisement::query()->where('key', 'cart_page_banner_section')->first();
        $cart_page_banner_section = json_decode($cart_page_banner_section?->value);

        return view('admin.page.advertisement.index', compact(['homepage_section_banner_one', 'homepage_section_banner_two', 'homepage_section_banner_three', 'homepage_section_banner_four', 'product_page_banner_section', 'cart_page_banner_section']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function homePageBannerSectionOne(Request $request)
    {
        $request->validate([
            'banner_one_image' => ['image'],
            'banner_one_url' => ['url'],
            'banner_two_image' => ['image'],
            'banner_two_url' => ['url'],
            'banner_three_image' => ['image'],
            'banner_three_url' => ['url'],

        ]);

        // xử lí upload ảnh 
        $bannerSectionOne = Advertisement::query()->where('key', 'homepage_section_banner_one')->first();
        $sectionOne = json_decode($bannerSectionOne?->value);
        $imagePath = $this->updateImage($request, 'banner_one_image', $sectionOne?->banner_one_image->banner_one ?? '', 'advertisement');
        $imagePathTwo = $this->updateImage($request, 'banner_two_image', $sectionOne?->banner_two_image->banner_two ?? '', 'advertisement');
        $imagePathThree = $this->updateImage($request, 'banner_three_image', $sectionOne?->banner_three_image->banner_three ?? '', 'advertisement');

        $value = [
            'banner_one' => [
                'banner_one_image' => $imagePath,
                'banner_one_url' => $request->banner_one_url,
                'status' => $request->has('banner_one_status') ? 1 : 0,
            ],
            'banner_two' => [
                'banner_two_image' => $imagePathTwo,
                'banner_two_url' => $request->banner_two_url,
                'status' => $request->has('banner_two_status') ? 1 : 0,
            ],
            'banner_three' => [
                'banner_three_image' => $imagePathThree,
                'banner_three_url' => $request->banner_three_url,
                'status' => $request->has('banner_three_status') ? 1 : 0,
            ]
        ];
        $value = json_encode($value);
        Advertisement::updateOrCreate(
            ['key' => 'homepage_section_banner_one'],
            ['value' => $value]
        );

        toastr('Updated Successfully!', 'success');

        return redirect()->back();
    }

    public function homePageBannerSectionTwo(Request $request)
    {
        $request->validate([
            'banner_image_two' => ['image'],
            'banner_url_two' => ['url'],
        ]);

        // xử lí upload ảnh 
        $bannerSectionTwo = Advertisement::query()->where('key', 'homepage_section_banner_two')->first();
        $sectionTwo = json_decode($bannerSectionTwo?->value);
        $imagePath = $this->updateImage($request, 'banner_image_two', $sectionTwo->banner_image_two->banner_image ?? '', 'advertisement');


        $value = [
            'banner_image_two' => [
                'banner_image' => $imagePath,
                'banner_url' => $request->banner_url_two,
                'status' => $request->has('status') ? 1 : 0,
            ]
        ];

        $value = json_encode($value);
        Advertisement::updateOrCreate(
            ['key' => 'homepage_section_banner_two'],
            ['value' => $value]
        );

        toastr('Update Successfully!', 'success');

        return redirect()->back();
    }

    public function homepageBannerSectionThree(Request $request)
    {
        $request->validate([
            'banner_image_three' => ['image'],
            'banner_url_three'=> ['url'],
        ]);

        // xử lí upload ảnh 
        $bannerSectionThree = Advertisement::query()->where('key', 'homepage_section_banner_three')->first();
        $sectionThree = json_decode($bannerSectionThree?->value);
        $imagePath = $this->updateImage($request, 'banner_image_three', $sectionThree->banner_image_three->banner_image ?? '', 'advertisement');


        $value = [
            'banner_image_three' => [
                'banner_image' => $imagePath,
                'banner_url' => $request->banner_url_three,
                'status' => $request->has('status') ? 1 : 0,
            ]
        ];

        $value = json_encode($value);
        Advertisement::updateOrCreate(
            ['key' => 'homepage_section_banner_three'],
            ['value' => $value]
        );

        toastr('Cập nhật thành công!', 'success');

        return redirect()->back();
    }

    public function productPageBanner(Request $request)
    {
        $request->validate([
            'banner_image' => ['image'],
            'banner_url' => ['url'],
        ]);

        // xử lí upload ảnh
        $productPageBanner = Advertisement::query()->where('key', 'product_page_banner_section')->first();
        $productBannerPage = json_decode($productPageBanner?->value);
        $imagePath = $this->updateImage($request, 'banner_image', $productBannerPage?->banner_one->banner_image ?? '', 'advertisement');

        $value = [
            'banner_one' => [
                'banner_image' => $imagePath,
                'banner_url' => $request->banner_url,
                'status' => $request->has('status') ? 1 : 0,
            ]
        ];

        $value = json_encode($value);
        Advertisement::updateOrCreate(
            ['key' => 'product_page_banner_section'],
            ['value' => $value]
        );

        toastr('Cập nhật thành công!', 'success');

        return redirect()->back();
    }
}
