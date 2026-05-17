<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Moderator\ModeratorController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ទំព័រដើមលំដាប់លំនាំដើម
Route::get('/', function () {
    return view('welcome');
});

// 🛍️ ទំព័រ Shop និង Product Detail
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/product/{slug}', [ShopController::class, 'show'])->name('product.show');

// 🛒 ប្រព័ន្ធកន្ត្រកទំនិញ (Cart System - ភ្ញៀវក៏អាច Add បាន)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// 🌐 ក្រុមផ្លូវសម្រាប់ Guest (អ្នកដែលមិនទាន់បាន Login)
Route::middleware('guest')->group(function () {
    // Register
    Route::get('register', [RegisterController::class, 'create'])->name('register');
    Route::post('register', [RegisterController::class, 'store']);

    // Login
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store']);
});

// 🔒 ក្រុមផ្លូវដែលត្រូវការពារ (ទាល់តែ Login រួចរាល់ទើបអាចចូលបាន)
Route::middleware('auth')->group(function () {
    
    // ផ្លូវសម្រាប់ Logout
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');

    // 🛒 ១. ផ្លូវសម្រាប់ Customer Dashboard
    Route::get('customer/dashboard', [CustomerController::class, 'index'])->name('customer.dashboard');

    // 🛡️ ២. ផ្លូវសម្រាប់ Moderator Dashboard
    Route::get('moderator/dashboard', [ModeratorController::class, 'index'])->name('moderator.dashboard');

    // 🛠️ ៣. Admin Group Panel (ជាប់ Middleware auth ស្រាប់ពីខាងក្រៅ)
    Route::prefix('admin')->name('admin.')->group(function () {
        
       // ទំព័រ Dashboard មេរបស់ Admin
        Route::get('/dashboard', function() {
            if (!auth()->user()?->hasRole('admin')) { 
                abort(403, 'Unauthorized action.'); 
            }

            // 🎯 ទាញយកចំនួនពិតប្រាកដពីតារាងក្នុង Database
            $totalProducts = \App\Models\Product::count();
            $totalUsers = \App\Models\User::count();
            
            // ⚠️ កំណត់ជា ០ សិន ព្រោះយើងមិនទាន់បានធ្វើប្រព័ន្ធទាំង ២ នេះ
            $totalOrders = 0; 
            $totalReviews = 0; 

            return view('admin.dashboard', compact('totalProducts', 'totalUsers', 'totalOrders', 'totalReviews'));
        })->name('dashboard');
        // --- គ្រប់គ្រង Users ---
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::resource('users', UserController::class);

        // ឬបើបងសរសេរដៃដាច់ដោយឡែក ត្រូវប្រាកដថាមាន ៣ បន្ទាត់នេះបន្ថែម៖
        Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
                
        // --- គ្រប់គ្រង Products ---
         Route::get('products', [ProductController::class, 'index'])->name('products.index'); // 🎯 ថែមបន្ទាត់នេ
        Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('products', [ProductController::class, 'store'])->name('products.store');
        Route::get('products/{product}/edit', [\App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('products.edit');
        Route::put('products/{product}', [\App\Http\Controllers\Admin\ProductController::class, 'update'])->name('products.update');
        Route::delete('products/{product}', [\App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('products.destroy');
    });
});