<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ModeratorController extends Controller
{
    /**
     * បង្ហាញទំព័រ Dashboard សម្រាប់ Moderator
     */
    public function index()
    {
        // 🔒 ការពារសុវត្ថិភាព៖ ទាល់តែគណនីមានសិទ្ធិជា moderator ទើបអាចចូលបាន
        if (!auth()->check() || !auth()->user()->hasRole('moderator')) {
            abort(403, 'Unauthorized action.');
        }

        return view('moderator.dashboard');
    }
}