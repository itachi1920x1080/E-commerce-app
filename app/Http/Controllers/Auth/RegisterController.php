<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }
    
    public function store(Request $request)
    {
        // ១. Validation
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users,email',
            'password'   => 'required|string|min:8|confirmed',
        ]);

        // ២. បង្កើតគណនីថ្មី
        $user = User::create([
            'first_name'    => $validated['first_name'],
            'last_name'     => $validated['last_name'],
            'email'         => $validated['email'],
            // 🎯 ចំណុចសំខាន់៖ ត្រូវប្រើឈ្មោះ column 'password_hash' ឱ្យត្រូវនឹង Database របស់បង
            'password_hash' => Hash::make($validated['password']),
            'active'        => 1, // 🎯 ដាក់ Active ស្វ័យប្រវត្តិ
        ]);

        // ៣. (Optional) ភ្ជាប់ Role ជា Customer ស្វ័យប្រវត្តិ
        // ប្រសិនបើបងមានតារាង roles អាចទាញយក Role Customer មកភ្ជាប់បាន៖
        // $customerRole = \App\Models\Role::where('name', 'customer')->first();
        // if($customerRole) {
        //     $user->roles()->attach($customerRole->id);
        // }

        // ៤. ធ្វើការ Login ចូលគណនីភ្លាមៗបន្ទាប់ពីចុះឈ្មោះរួច
        Auth::login($user);

        // ៥. បញ្ជូនអតិថិជនទៅកាន់ទំព័រដើម (ឬ Shop)
        return redirect()->route('home')->with('success', 'Account created successfully! Welcome to our store.');
    }
}