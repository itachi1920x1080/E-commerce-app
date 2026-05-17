<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
{
    $credentials = $request->validate([
        'email'    => 'required|string|email',
        'password' => 'required|string',
    ]);

    // ព្យាយាម Login
    if (Auth::attempt(array_merge($credentials, ['active' => true]), $request->boolean('remember'))) {
        $request->session()->regenerate();

        $user = Auth::user();

        // 🎯 ឆែកមើលសិទ្ធិដើម្បី Redirect ទៅកាន់ទំព័រត្រឹមត្រូវ
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
            
        } elseif ($user->hasRole('moderator')) {
            return redirect()->route('moderator.dashboard');
            
        } else {
            // 🛒 បើមិនមែន Admin ឬ Moderator ទេ គឺរុញទៅ Customer Dashboard ទាំងអស់
            return redirect()->route('customer.dashboard');
        }
    }

    throw ValidationException::withMessages([
        'email' => 'អ៊ីមែល ឬលេខសម្ងាត់របស់អ្នកមិនត្រឹមត្រូវ។',
    ]);
}

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
    
}