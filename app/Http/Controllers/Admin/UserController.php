<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * បង្ហាញបញ្ជីឈ្មោះ Users ទាំងអស់
     */
    public function index()
    {
        // 🔒 ការពារសុវត្ថិភាព៖ ទាល់តែ Admin ទើបអាចចូលបាន
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        // ទាញយក Users រួមទាំង Roles (Many-to-Many Eager Loading)
        $users = User::with('roles')->get(); 
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * បង្ហាញទំព័រ Form បង្កើត User ថ្មី
     */
    public function create()
    {
        // 🔒 ការពារសុវត្ថិភាព
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $roles = Role::all(); 
        return view('admin.users.create', compact('roles'));
    }

    /**
     * ទទួលទិន្នន័យពី Form ហើយរក្សាទុកចូល Database ទាំងស្រុង
     */
    public function store(Request $request)
    {
        // 🔒 ការពារសុវត្ថិភាព
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        // ឆែកមើលភាពត្រឹមត្រូវនៃទិន្នន័យឱ្យត្រូវតាមលក្ខខណ្ឌតារាង users ថ្មី
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users,email',
            'password'   => 'required|string|min:8|confirmed',
            'role_id'    => 'required|exists:roles,id',
            'address'    => 'nullable|string|max:255',
            'city'       => 'nullable|string|max:100',
            'state'      => 'nullable|string|max:50',
            'zip_code'   => 'nullable|integer',
        ]);

        // ១. បង្កើតគណនី User ថ្មី (ប្រព័ន្ធ HasUuids នឹងបង្កើត id ជា UUID ឱ្យស្វ័យប្រវត្តិ)
        $user = User::create([
            'first_name'    => $validated['first_name'],
            'last_name'     => $validated['last_name'],
            'email'         => $validated['email'],
            'password_hash' => Hash::make($validated['password']), // រក្សាទុកចំ Column password_hash ថ្មី
            'address'       => $validated['address'],
            'city'          => $validated['city'],
            'state'         => $validated['state'],
            'zip_code'      => $validated['zip_code'],
            'active'        => $request->active ?? 1,
        ]);

        // ២. បាញ់ទិន្នន័យចូលតារាងកណ្តាល user_roles (Pivot Table Many-to-Many)
        $user->roles()->attach($validated['role_id']);

        // នៅពេលជោគជ័យ បញ្ជូនត្រឡប់ទៅទំព័រ List វិញ
        return redirect()->route('admin.users.index')->with('success', 'User created successfully!');
    }
    /**
     * បង្ហាញទំព័រ Form កែសម្រួលព័ត៌មាន User
     */
    public function edit(User $user)
    {
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        // ទាញយក Roles ទាំងអស់ដើម្បីបង្ហាញក្នុងប្រអប់ Select Option
        $roles = \App\Models\Role::all();
        
        // ទាញយកទិន្នន័យអាសយដ្ឋានបច្ចុប្បន្នរបស់ User (បើមាន)
        $address = $user->addresses()->first(); 

        return view('admin.users.edit', compact('user', 'roles', 'address'));
    }

    /**
     * ធ្វើបច្ចុប្បន្នភាព (Update) ទិន្នន័យចូល Database
     */
    public function update(Request $request, User $user)
    {
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        // ១. Validation ពិនិត្យទិន្នន័យ
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|max:255|unique:users,email,' . $user->id,
            'role_id'    => 'required|exists:roles,id',
            'active'     => 'required|in:0,1',
            'password'   => 'nullable|string|min:8|confirmed', // Nullable បើភ្ញៀវមិនចង់ដូរលេខសម្ងាត់
            'address'    => 'nullable|string|max:255',
            'city'       => 'nullable|string|max:255',
            'state'      => 'nullable|string|max:255',
            'zip_code'   => 'nullable|string|max:255',
        ]);

        // ២. អាប់ដេតទិន្នន័យតារាង users មេ
        $userData = [
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'email'      => $validated['email'],
            'active'     => $validated['active'],
        ];

        // បើ Admin វាយលេខសម្ងាត់ថ្មី ទើបធ្វើការ Hash រក្សាទុក
        if (!empty($validated['password'])) {
            $userData['password'] = bcrypt($validated['password']);
        }

        $user->update($userData);

        // ៣. អាប់ដេតសិទ្ធិ (Role) នៅក្នុងតារាងបង្កាត់ (Pivot/User_Roles)
        $user->roles()->sync([$validated['role_id']]);

        // ៤. អាប់ដេត ឬបង្កើតអាសយដ្ឋានថ្មីនៅក្នុងតារាង user_addresses
        // ៤. អាប់ដេត ឬបង្កើតអាសយដ្ឋានថ្មីនៅក្នុងតារាង user_addresses
        $user->addresses()->updateOrCreate(
            ['user_id' => $user->id], // លក្ខខណ្ឌស្វែងរក
            [
                // 🎯 FIXED: បន្ថែម full_name ដោយយក First Name និង Last Name មកតភ្ជាប់គ្នា (ដកឃ្លាកណ្តាល)
                'full_name' => $validated['first_name'] . ' ' . $validated['last_name'], 
                
                'address'  => $validated['address'],
                'city'     => $validated['city'],
                'state'    => $validated['state'],
                'zip_code' => $validated['zip_code'],
            ]
        );

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully! 👤');
    }

    /**
     * លុប (Delete) គណនីអ្នកប្រើប្រាស់
     */
    public function destroy(User $user)
    {
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        // ការពារកុំឱ្យ Admin ច្រឡំដៃលុបគណនីខ្លួនឯងកំពុងប្រើប្រាស់
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account!');
        }

        // លុបទំនាក់ទំនង Roles និង អាសយដ្ឋានជាមុនសិន (ទប់ស្កាត់ Foreign Key Error)
        $user->roles()->detach();
        $user->addresses()->delete();
        
        // លុប User ចេញពីតារាងមេ
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully!');
    }
}