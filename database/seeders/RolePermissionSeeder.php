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
            ['name' => 'view-dashboard', 'group' => 'Dashboard'],
            //Categories_Products
            ['name' => 'view-categories-products', 'group' => 'Categories_Products'],
            ['name' => 'create-categories-products', 'group' => 'Categories_Products'],
            ['name' => 'edit-categories-products', 'group' => 'Categories_Products'],
            ['name' => 'delete-categories-products', 'group' => 'Categories_Products'],
            //Products
            ['name' => 'view-products', 'group' => 'Products'],
            ['name' => 'create-products', 'group' => 'Products'],
            ['name' => 'edit-products', 'group' => 'Products'],
            ['name' => 'delete-products', 'group' => 'Products'],
            //Brands
            ['name' => 'view-brands', 'group' => 'Brands'],
            ['name' => 'create-brands', 'group' => 'Brands'],
            ['name' => 'edit-brands', 'group' => 'Brands'],
            ['name' => 'delete-brands', 'group' => 'Brands'],
            //Categories_Attributes
            ['name' => 'view-categories-attributes', 'group' => 'Categories_Attributes'],
            ['name' => 'create-categories-attributes', 'group' => 'Categories_Attributes'],
            ['name' => 'edit-categories-attributes', 'group' => 'Categories_Attributes'],
            ['name' => 'delete-categories-attributes', 'group' => 'Categories_Attributes'],
            //Attributes
            ['name' => 'view-attributes', 'group' => 'Attributes'],
            ['name' => 'create-attributes', 'group' => 'Attributes'],
            ['name' => 'edit-attributes', 'group' => 'Attributes'],
            ['name' => 'delete-attributes', 'group' => 'Attributes'],
            //Coupons
            ['name' => 'view-coupons', 'group' => 'Coupons'],
            ['name' => 'create-coupons', 'group' => 'Coupons'],
            ['name' => 'edit-coupons', 'group' => 'Coupons'],
            ['name' => 'delete-coupons', 'group' => 'Coupons'],
            //Reviews
            ['name' => 'view-reviews', 'group' => 'Reviews'],
            // ['name' => 'create-reviews', 'group' => 'Reviews'],
            // ['name' => 'edit-reviews', 'group' => 'Reviews'],
            ['name' => 'delete-reviews', 'group' => 'Reviews'],
            //Advertisements
            ['name' => 'view-advertisements', 'group' => 'Advertisements'],
            // ['name' => 'create-advertisements', 'group' => 'Advertisements'],
            ['name' => 'edit-advertisements', 'group' => 'Advertisements'],
            // ['name' => 'delete-advertisements', 'group' => 'Advertisements'],
            //Popups
            ['name' => 'view-popups', 'group' => 'Popups'],
            ['name' => 'create-popups', 'group' => 'Popups'],
            ['name' => 'edit-popups', 'group' => 'Popups'],
            ['name' => 'delete-popups', 'group' => 'Popups'],
            ['name' => 'delete-subscribers', 'group' => 'Popups'],
            //Banners
            ['name' => 'view-banners', 'group' => 'Banners'],
            ['name' => 'create-banners', 'group' => 'Banners'],
            ['name' => 'edit-banners', 'group' => 'Banners'],
            ['name' => 'delete-banners', 'group' => 'Banners'],
            //Blogs
            ['name' => 'view-blogs', 'group' => 'Blogs'],
            ['name' => 'create-blogs', 'group' => 'Blogs'],
            ['name' => 'edit-blogs', 'group' => 'Blogs'],
            ['name' => 'delete-blogs', 'group' => 'Blogs'],
            //Blog_Categories
            ['name' => 'view-blog-categories', 'group' => 'Blog_Categories'],
            ['name' => 'create-blog-categories', 'group' => 'Blog_Categories'],
            ['name' => 'edit-blog-categories', 'group' => 'Blog_Categories'],
            ['name' => 'delete-blog-categories', 'group' => 'Blog_Categories'],
            //Blog_Comments
            ['name' => 'view-blog-comments', 'group' => 'Blog_Comments'],
            // ['name' => 'create-blog-comments', 'group' => 'Blog_Comments'],
            // ['name' => 'edit-blog-comments', 'group' => 'Blog_Comments'],
            ['name' => 'delete-blog-comments', 'group' => 'Blog_Comments'],
            //Menus
            ['name' => 'view-menus', 'group' => 'Menus'],
            ['name' => 'create-menus', 'group' => 'Menus'],
            ['name' => 'edit-menus', 'group' => 'Menus'],
            ['name' => 'delete-menus', 'group' => 'Menus'],
            //Menu_Items
            ['name' => 'view-menu-items', 'group' => 'Menu_Items'],
            ['name' => 'create-menu-items', 'group' => 'Menu_Items'],
            ['name' => 'edit-menu-items', 'group' => 'Menu_Items'],
            ['name' => 'delete-menu-items', 'group' => 'Menu_Items'],
            //Orders
            ['name' => 'view-orders', 'group' => 'Orders'],
            // ['name' => 'create-orders', 'group' => 'Orders'],
            ['name' => 'edit-orders', 'group' => 'Orders'],
            ['name' => 'delete-orders', 'group' => 'Orders'],
            //Accounts
            ['name' => 'view-accounts', 'group' => 'Accounts'],
            // ['name' => 'create-accounts', 'group' => 'Accounts'],
            ['name' => 'edit-accounts', 'group' => 'Accounts'],
            ['name' => 'delete-accounts', 'group' => 'Accounts'],
            //Roles
            // ['name' => 'view-roles', 'group' => 'Roles'],
            // ['name' => 'create-roles', 'group' => 'Roles'],
            // ['name' => 'edit-roles', 'group' => 'Roles'],
            // ['name' => 'delete-roles', 'group' => 'Roles'],
            //Socials
            ['name' => 'view-socials', 'group' => 'Socials'],
            ['name' => 'create-socials', 'group' => 'Socials'],
            ['name' => 'edit-socials', 'group' => 'Socials'],
            ['name' => 'delete-socials', 'group' => 'Socials'],
            //Settings
            ['name' => 'view-settings', 'group' => 'Settings'],
            // ['name' => 'create-settings', 'group' => 'Settings'],
            ['name' => 'edit-settings', 'group' => 'Settings'],
            // ['name' => 'delete-settings', 'group' => 'Settings'],
            //Tags
            ['name' => 'view-tags', 'group' => 'Tags'],
            ['name' => 'create-tags', 'group' => 'Tags'],
            ['name' => 'edit-tags', 'group' => 'Tags'],
            ['name' => 'delete-tags', 'group' => 'Tags'],
            //Abouts
            ['name' => 'view-abouts', 'group' => 'Abouts'],
            // ['name' => 'create-abouts', 'group' => 'Abouts'],
            ['name' => 'edit-abouts', 'group' => 'Abouts'],
            // ['name' => 'delete-abouts', 'group' => 'Abouts'],
            //Payment_Settings
            ['name' => 'view-payment-settings', 'group' => 'Payment_Settings'],
            // ['name' => 'create-payment-settings', 'group' => 'Payment_Settings'],
            ['name' => 'edit-payment-settings', 'group' => 'Payment_Settings'],
            // ['name' => 'delete-payment-settings', 'group' => 'Payment_Settings'],
        ];

        // Tạo quyền
        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                ['group' => $permission['group']]
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
