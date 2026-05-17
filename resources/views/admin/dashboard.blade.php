@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100">
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-center md:justify-between p-6 bg-white rounded-xl shadow-sm border mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Admin Control Dashboard</h1>
                <p class="text-sm text-gray-500 mt-1">ស្វាគមន៍មកកាន់ប្រព័ន្ធគ្រប់គ្រងហាងអនឡាញ, {{ Auth::user()->first_name }}!</p>
            </div>
            
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.users.create') }}" class="inline-flex items-center bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2.5 rounded-lg text-sm font-medium transition shadow-sm">
                    👤 Add New User
                </a>
                <a href="{{ route('admin.products.create') }}" class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition shadow-sm">
                    📦 Add New Product
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200/60 flex items-center justify-between">
                <div>
                    <span class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Total Products</span>
                    <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($totalProducts ?? 0) }}</h3>
                    <a href="{{ route('admin.products.index') }}" class="text-xs text-indigo-600 hover:underline mt-2 block font-medium">Manage catalog &rarr;</a>
                </div>
                <div class="p-3.5 bg-indigo-50 text-indigo-600 rounded-xl text-2xl">📦</div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200/60 flex items-center justify-between">
                <div>
                    <span class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Paid Orders</span>
                    <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($totalOrders ?? 0) }}</h3>
                    <a href="#" class="text-xs text-emerald-600 hover:underline mt-2 block font-medium">View sales &rarr;</a>
                </div>
                <div class="p-3.5 bg-emerald-50 text-emerald-600 rounded-xl text-2xl">💰</div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200/60 flex items-center justify-between">
                <div>
                    <span class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Total Users</span>
                    <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($totalUsers ?? 0) }}</h3>
                    <a href="{{ route('admin.users.index') }}" class="text-xs text-sky-600 hover:underline mt-2 block font-medium">View all members &rarr;</a>
                </div>
                <div class="p-3.5 bg-sky-50 text-sky-600 rounded-xl text-2xl">👥</div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200/60 flex items-center justify-between">
                <div>
                    <span class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Product Reviews</span>
                    <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($totalReviews ?? 0) }}</h3>
                    <a href="#" class="text-xs text-amber-600 hover:underline mt-2 block font-medium">Moderate reviews &rarr;</a>
                </div>
                <div class="p-3.5 bg-amber-50 text-amber-600 rounded-xl text-2xl">⭐</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-5 border-b bg-gray-50/50 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800 text-lg">System Shortcut Operations</h3>
                    <span class="text-xs font-medium text-gray-400">Quick Tools</span>
                </div>
                
                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-4 border border-dashed border-gray-200 rounded-xl hover:bg-gray-50/50 transition">
                        <div class="font-semibold text-gray-800 text-md mb-1">📦 Catalog Management</div>
                        <p class="text-xs text-gray-500 mb-3">បន្ថែម កែសម្រួល ឬលុបផលិតផល សារពើភណ្ឌ និងតម្លៃទំនិញលក់។</p>
                        <a href="{{ route('admin.products.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">Go to Product List &rarr;</a>
                    </div>
                    
                    <div class="p-4 border border-dashed border-gray-200 rounded-xl hover:bg-gray-50/50 transition">
                        <div class="font-semibold text-gray-800 text-md mb-1">👥 User & Role Access</div>
                        <p class="text-xs text-gray-500 mb-3">គ្រប់គ្រងគណនីអតិថិជន និងកំណត់សិទ្ធិជា Admin ឬ Moderator។</p>
                        <a href="{{ route('admin.users.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">View User List &rarr;</a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <h3 class="font-bold text-gray-800 text-lg mb-4 border-b pb-3">Store Properties</h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500 font-medium">Database Connection:</span>
                        <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 text-xs font-semibold rounded-full border border-emerald-200">MySQL Connected</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500 font-medium">Default Currency:</span>
                        <span class="text-gray-800 font-bold">USD ($)</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500 font-medium">Environment Mode:</span>
                        <span class="text-gray-600 font-mono text-xs bg-gray-100 px-2 py-0.5 rounded">Local Development</span>
                    </div>
                </div>

                <div class="mt-8 pt-5 border-t">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-center bg-red-50 hover:bg-red-100 border border-red-200 text-red-700 font-medium py-2.5 rounded-lg text-sm transition focus:outline-none">
                            🔒 Secure Log Out
                        </button>
                    </form>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection