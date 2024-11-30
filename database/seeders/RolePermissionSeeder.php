<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $permissions = [
            //Dashboard
            ['name' => 'view-dashboard', 'group' => 'Dashboard', 'display_name' => 'Xem bảng điều khiển'],
            //Categories_Products
            ['name' => 'view-categories-products', 'group' => 'Categories_Products', 'display_name' => 'Xem danh mục sản phẩm'],
            ['name' => 'create-categories-products', 'group' => 'Categories_Products', 'display_name' => 'Thêm danh mục sản phẩm'],
            ['name' => 'edit-categories-products', 'group' => 'Categories_Products', 'display_name' => 'Sửa danh mục sản phẩm'],
            ['name' => 'delete-categories-products', 'group' => 'Categories_Products', 'display_name' => 'Xóa danh mục sản phẩm'],
            //Products
            ['name' => 'view-products', 'group' => 'Products', 'display_name' => 'Xem sản phẩm'],
            ['name' => 'create-products', 'group' => 'Products', 'display_name' => 'Thêm sản phẩm'],
            ['name' => 'edit-products', 'group' => 'Products', 'display_name' => 'Sửa sản phẩm'],
            ['name' => 'delete-products', 'group' => 'Products', 'display_name' => 'Xóa sản phẩm'],
            //Brands
            ['name' => 'view-brands', 'group' => 'Brands', 'display_name' => 'Xem thương hiệu'],
            ['name' => 'create-brands', 'group' => 'Brands', 'display_name' => 'Thêm thương hiệu'],
            ['name' => 'edit-brands', 'group' => 'Brands', 'display_name' => 'Sửa thương hiệu'],
            ['name' => 'delete-brands', 'group' => 'Brands', 'display_name' => 'Xóa thương hiệu'],
            //Categories_Attributes
            ['name' => 'view-categories-attributes', 'group' => 'Categories_Attributes', 'display_name' => 'Xem danh mục thuộc tính'],
            ['name' => 'create-categories-attributes', 'group' => 'Categories_Attributes', 'display_name' => 'Thêm danh mục thuộc tính'],
            ['name' => 'edit-categories-attributes', 'group' => 'Categories_Attributes', 'display_name' => 'Sửa danh mục thuộc tính'],
            ['name' => 'delete-categories-attributes', 'group' => 'Categories_Attributes', 'display_name' => 'Xóa danh mục thuộc tính'],
            //Attributes
            ['name' => 'view-attributes', 'group' => 'Attributes', 'display_name' => 'Xem thuộc tính'],
            ['name' => 'create-attributes', 'group' => 'Attributes', 'display_name' => 'Thêm thuộc tính'],
            ['name' => 'edit-attributes', 'group' => 'Attributes', 'display_name' => 'Sửa thuộc tính'],
            ['name' => 'delete-attributes', 'group' => 'Attributes', 'display_name' => 'Xóa thuộc tính'],
            //Coupons
            ['name' => 'view-coupons', 'group' => 'Coupons', 'display_name' => 'Xem mã giảm giá'],
            ['name' => 'create-coupons', 'group' => 'Coupons', 'display_name' => 'Thêm mã giảm giá'],
            ['name' => 'edit-coupons', 'group' => 'Coupons', 'display_name' => 'Sửa mã giảm giá'],
            ['name' => 'delete-coupons', 'group' => 'Coupons', 'display_name' => 'Xóa mã giảm giá'],
            //Reviews
            ['name' => 'view-reviews', 'group' => 'Reviews', 'display_name' => 'Xem đánh giá'],
            ['name' => 'delete-reviews', 'group' => 'Reviews', 'display_name' => 'Xóa đánh giá'],
            //Advertisements
            ['name' => 'view-advertisements', 'group' => 'Advertisements', 'display_name' => 'Xem quảng cáo'],
            ['name' => 'edit-advertisements', 'group' => 'Advertisements', 'display_name' => 'Sửa quảng cáo'],
            //Popups
            ['name' => 'view-popups', 'group' => 'Popups', 'display_name' => 'Xem popup'],
            ['name' => 'create-popups', 'group' => 'Popups', 'display_name' => 'Thêm popup'],
            ['name' => 'edit-popups', 'group' => 'Popups', 'display_name' => 'Sửa popup'],
            ['name' => 'delete-popups', 'group' => 'Popups', 'display_name' => 'Xóa popup'],
            ['name' => 'delete-subscribers', 'group' => 'Popups', 'display_name' => 'Xóa người đăng ký'],
            //Banners
            ['name' => 'view-banners', 'group' => 'Banners', 'display_name' => 'Xem banner'],
            ['name' => 'create-banners', 'group' => 'Banners', 'display_name' => 'Thêm banner'],
            ['name' => 'edit-banners', 'group' => 'Banners', 'display_name' => 'Sửa banner'],
            ['name' => 'delete-banners', 'group' => 'Banners', 'display_name' => 'Xóa banner'],
            //Blogs
            ['name' => 'view-blogs', 'group' => 'Blogs', 'display_name' => 'Xem blog'],
            ['name' => 'create-blogs', 'group' => 'Blogs', 'display_name' => 'Thêm blog'],
            ['name' => 'edit-blogs', 'group' => 'Blogs', 'display_name' => 'Sửa blog'],
            ['name' => 'delete-blogs', 'group' => 'Blogs', 'display_name' => 'Xóa blog'],
            //Blog_Categories
            ['name' => 'view-blog-categories', 'group' => 'Blog_Categories', 'display_name' => 'Xem danh mục blog'],
            ['name' => 'create-blog-categories', 'group' => 'Blog_Categories', 'display_name' => 'Thêm danh mục blog'],
            ['name' => 'edit-blog-categories', 'group' => 'Blog_Categories', 'display_name' => 'Sửa danh mục blog'],
            ['name' => 'delete-blog-categories', 'group' => 'Blog_Categories', 'display_name' => 'Xóa danh mục blog'],
            //Blog_Comments
            ['name' => 'view-blog-comments', 'group' => 'Blog_Comments', 'display_name' => 'Xem bình luận blog'],
            ['name' => 'delete-blog-comments', 'group' => 'Blog_Comments', 'display_name' => 'Xóa bình luận blog'],
            //Menus
            ['name' => 'view-menus', 'group' => 'Menus', 'display_name' => 'Xem menu'],
            ['name' => 'create-menus', 'group' => 'Menus', 'display_name' => 'Thêm menu'],
            ['name' => 'edit-menus', 'group' => 'Menus', 'display_name' => 'Sửa menu'],
            ['name' => 'delete-menus', 'group' => 'Menus', 'display_name' => 'Xóa menu'],
            //Menu_Items
            ['name' => 'view-menu-items', 'group' => 'Menu_Items', 'display_name' => 'Xem menu item'],
            ['name' => 'create-menu-items', 'group' => 'Menu_Items', 'display_name' => 'Thêm menu item'],
            ['name' => 'edit-menu-items', 'group' => 'Menu_Items', 'display_name' => 'Sửa menu item'],
            ['name' => 'delete-menu-items', 'group' => 'Menu_Items', 'display_name' => 'Xóa menu item'],
            //Orders
            ['name' => 'view-orders', 'group' => 'Orders', 'display_name' => 'Xem đơn hàng'],
            ['name' => 'edit-orders', 'group' => 'Orders', 'display_name' => 'Sửa đơn hàng'],
            ['name' => 'delete-orders', 'group' => 'Orders', 'display_name' => 'Xóa đơn hàng'],
            //Inventory
            ['name' => 'view-inventory', 'group' => 'Inventory', 'display_name' => 'Xem kho hàng'],
            //Suppliers
            ['name' => 'view-suppliers', 'group' => 'Suppliers', 'display_name' => 'Xem nhà cung cấp'],
            ['name' => 'create-suppliers', 'group' => 'Suppliers', 'display_name' => 'Thêm nhà cung cấp'],
            ['name' => 'edit-suppliers', 'group' => 'Suppliers', 'display_name' => 'Sửa nhà cung cấp'],
            ['name' => 'delete-suppliers', 'group' => 'Suppliers', 'display_name' => 'Xóa nhà cung cấp'],
            //Accounts
            ['name' => 'view-accounts', 'group' => 'Accounts', 'display_name' => 'Xem tài khoản'],
            ['name' => 'edit-accounts', 'group' => 'Accounts', 'display_name' => 'Sửa tài khoản'],
            ['name' => 'delete-accounts', 'group' => 'Accounts', 'display_name' => 'Xóa tài khoản'],
            //Socials
            ['name' => 'view-socials', 'group' => 'Socials', 'display_name' => 'Xem mạng xã hội'],
            ['name' => 'create-socials', 'group' => 'Socials', 'display_name' => 'Thêm mạng xã hội'],
            ['name' => 'edit-socials', 'group' => 'Socials', 'display_name' => 'Sửa mạng xã hội'],
            ['name' => 'delete-socials', 'group' => 'Socials', 'display_name' => 'Xóa mạng xã hội'],
            //Settings
            ['name' => 'view-settings', 'group' => 'Settings', 'display_name' => 'Xem cài đặt'],
            ['name' => 'edit-settings', 'group' => 'Settings', 'display_name' => 'Sửa cài đặt'],
            //Tags
            ['name' => 'view-tags', 'group' => 'Tags', 'display_name' => 'Xem thẻ'],
            ['name' => 'create-tags', 'group' => 'Tags', 'display_name' => 'Thêm thẻ'],
            ['name' => 'edit-tags', 'group' => 'Tags', 'display_name' => 'Sửa thẻ'],
            ['name' => 'delete-tags', 'group' => 'Tags', 'display_name' => 'Xóa thẻ'],
            //Abouts
            ['name' => 'view-abouts', 'group' => 'Abouts', 'display_name' => 'Xem thông tin giới thiệu'],
            ['name' => 'edit-abouts', 'group' => 'Abouts', 'display_name' => 'Sửa thông tin giới thiệu'],
            //Payment_Settings
            ['name' => 'view-payment-settings', 'group' => 'Payment_Settings', 'display_name' => 'Xem cài đặt thanh toán'],
            ['name' => 'edit-payment-settings', 'group' => 'Payment_Settings', 'display_name' => 'Sửa cài đặt thanh toán'],
        ];

        // Tạo quyền
        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                [
                    'group' => $permission['group'],
                    'display_name' => $permission['display_name']
                ]
            );
        }

        // Tạo vai trò
        $roles = ['super_admin', 'admin', 'staff', 'user'];

        foreach ($roles as $role) {
            Role::updateOrCreate(['name' => $role]);
        }
        // Gán quyền cho vai trò

        $superAdmin = Role::findByName('super_admin');
        $superAdmin->givePermissionTo(array_column($permissions, 'name'));

        $adminRole = Role::findByName('admin');
        $adminRole->givePermissionTo(array_column($permissions, 'name'));

        $staffRole = Role::findByName('staff');
        $staffRole->givePermissionTo(['view-dashboard']);

        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('12345678'),
                'status' => 1,
                'role_id' => 1,
            ]
        );
        if (!$superAdmin->hasRole('super_admin')) {
            $superAdmin->assignRole('super_admin');
        }
    }
}
