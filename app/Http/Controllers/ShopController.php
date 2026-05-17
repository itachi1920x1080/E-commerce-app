<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    /**
     * បង្ហាញទំព័រហាងទំនិញ (Frontend Shop Panel)
     */
    public function index(Request $request)
    {
        // ១. ទាញយក Categories ទាំងអស់សម្រាប់បង្ហាញនៅលើ Sidebar Filter
        $categories = Category::all();

        // ២. ចាប់ផ្តើម Query ទាញយកផលិតផល រួមទាំងការ Eager Loading តារាង Categories
        $query = Product::with('categories');

        // ⚠️ ខ្ញុំបានបិទលក្ខខណ្ឌ Status សិន ដើម្បីឱ្យប្រព័ន្ធទាញយកទំនិញទាំងអស់មកបង្ហាញ
        /*
        $activeStatus = DB::table('product_statuses')->where('name', 'active')->first();
        if ($activeStatus) {
            $query->where('product_status_id', $activeStatus->id);
        }
        */

        // ៣. លក្ខខណ្ឌបើភ្ញៀវចុច Filter តាមប្រភេទ Category នៅលើ Sidebar
        if ($request->filled('category')) {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // ៤. ទាញយកទិន្នន័យទំនិញទាំងអស់ ដោយតម្រៀបទំនិញដែលទើប Add ថ្មីៗឱ្យនៅលើគេ
        $products = $query->latest('inserted_at')->get();

        // បញ្ជូនទៅកាន់ View 'shop.blade.php'
        return view('shop', compact('products', 'categories'));
    }
    /**
     * បង្ហាញទំព័រលម្អិតនៃផលិតផលនីមួយៗ
     */
    public function show($slug)
    {
        // ស្វែងរកផលិតផលតាមរយៈ slug ដែលបានបោះមក
        $product = Product::with(['categories', 'tags'])->where('slug', $slug)->firstOrFail();

        // (ជម្រើស) ទាញយកផលិតផលដែលស្រដៀងគ្នា ដើម្បីបង្ហាញខាងក្រោម
        $relatedProducts = Product::whereHas('categories', function ($q) use ($product) {
            $categoryId = $product->categories->first()?->id;
            if ($categoryId) {
                $q->where('categories.id', $categoryId);
            }
        })->where('id', '!=', $product->id)->take(4)->get();

        return view('product-detail', compact('product', 'relatedProducts'));
    }
}