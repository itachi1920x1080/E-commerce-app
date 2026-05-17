<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * បង្ហាញទំព័រ Dashboard សម្រាប់ Customer
     */
    public function index()
    {
        // 🔒 ការពារសុវត្ថិភាព៖ ទាល់តែគណនីមានសិទ្ធិជា customer ទើបអាចចូលបាន
        if (!auth()->check() || !auth()->user()->hasRole('customer')) {
            abort(403, 'Unauthorized action.');
        }

        return view('customer.dashboard');
    }
    public function edit(User $user)
    {
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $roles = \App\Models\Role::all();
        
        // 🎯 FIXED: ដូរកូដត្រង់បន្ទាត់ទី ៩៨ មកជាបែបនេះវិញ ដើម្បីកាត់ផ្តាច់ Error សិន
        $address = DB::table('user_addresses')->where('user_id', $user->id)->first(); 

        return view('admin.users.edit', compact('user', 'roles', 'address'));
    }
}