<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // -------------------------------------------------------------
        // ១. បង្កើត Roles (សិទ្ធិប្រព័ន្ធ)
        // -------------------------------------------------------------
        $roles = ['admin', 'moderator', 'customer'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // -------------------------------------------------------------
        // ២. បង្កើតគណនី Admin
        // -------------------------------------------------------------
        if (!User::where('email', 'admin@gmail.com')->exists()) {
            $admin = User::create([
                'first_name'    => 'Itachi',
                'last_name'     => 'Uchiha',
                'email'         => 'admin@gmail.com',
                'password_hash' => Hash::make('password123'),
                'active'        => 1,
            ]);

            $adminRole = Role::where('name', 'admin')->first();
            if ($adminRole) {
                $admin->roles()->attach($adminRole->id);
            }
        }

        // -------------------------------------------------------------
        // ៣. បង្កើតស្ថានភាពផលិតផល (FIXED: ដក updated_at ចេញ)
        // -------------------------------------------------------------
        $statuses = ['active', 'draft', 'archived'];
        foreach ($statuses as $status) {
            DB::table('product_statuses')->updateOrInsert(
                ['name' => $status],
                ['inserted_at' => now()] // រក្សាទុកតែ inserted_at ដែលមានក្នុង Schema ប៉ុណ្ណោះ
            );
        }

        // -------------------------------------------------------------
        // ៤. បង្កើតប្រភេទផលិតផលគំរូ (Categories)
        // -------------------------------------------------------------
        $categories = [
            ['name' => 'Electronics', 'description' => 'Gadgets, phones, smartwatches and laptops'],
            ['name' => 'Clothing & Apparel', 'description' => 'Shirts, hoodies, pants, and modern dresses'],
            ['name' => 'Shoes & Footwear', 'description' => 'Sports sneakers, boots, and casual shoes'],
            ['name' => 'Accessories', 'description' => 'Bags, luxury watches, and jewelry'],
            ['name' => 'Home & Living', 'description' => 'Comfortable furniture and home decor item'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['slug' => Str::slug($cat['name'])],
                [
                    'name'        => $cat['name'],
                    'description' => $cat['description'],
                    'parent_id'   => null
                ]
            );
        }

        // -------------------------------------------------------------
        // ៥. បង្កើតស្លាកផលិតផលគំរូ (Product Tags)
        // -------------------------------------------------------------
        $tags = ['New Arrival', 'Best Seller', 'Hot Items', 'Discount 50%', 'Limited Edition', 'Trending Now'];
        foreach ($tags as $tagName) {
            Tag::firstOrCreate(
                ['slug' => Str::slug($tagName)],
                ['name' => $tagName]
            );
        }
    }
}