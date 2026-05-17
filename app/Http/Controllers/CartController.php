<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * បន្ថែមទំនិញចូលទៅក្នុង Session Cart
     */
    public function add(Request $request, $id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $cart = session()->get('cart', []);

        $price = ($product->discount_price > 0 && $product->discount_price < $product->regular_price) 
                    ? $product->discount_price : $product->regular_price;

        // 🎯 ចាប់យកចំនួន (Quantity) ពី JavaScript បើអត់មានគឺយក ១ ជាស្វ័យប្រវត្តិ
        $qty = $request->input('quantity', 1);

        if (isset($cart[$id])) {
            // បូកបញ្ចូលចំនួនថ្មី ទៅលើចំនួនចាស់ដែលមានស្រាប់
            $cart[$id]['quantity'] += $qty;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => $qty, // ដាក់ចំនួនដែលទើបចាប់បានចូលទីនេះ
                "price" => $price,
                "image" => $product->image,
                "slug" => $product->slug
            ];
        }

        session()->put('cart', $cart);

        $totalItems = count(session('cart'));

        return response()->json([
            'success' => true,
            'totalItems' => $totalItems,
            'message' => 'បានបន្ថែម ' . $product->name . ' ចំនួន ' . $qty . ' ចូលកន្ត្រកដោយជោគជ័យ! 🛒'
        ]);
    }
    public function index()
    {
        // ទាញយកទិន្នន័យកន្ត្រកពី Session
        $cart = session()->get('cart', []);
        
        return view('cart', compact('cart'));
    }

    /**
     * លុបទំនិញចេញពីកន្ត្រក
     */
    public function remove(Request $request, $id)
    {
        $cart = session()->get('cart');

        // បើមានទំនិញនោះក្នុងកន្ត្រក គឺលុបវាចេញ
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'បានលុបទំនិញចេញពីកន្ត្រកដោយជោគជ័យ!');
    }
}