@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        
        <div class="bg-indigo-900 rounded-2xl p-6 md:p-8 text-white shadow-lg mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <span class="bg-indigo-700 text-indigo-200 text-xs px-3 py-1 rounded-full font-semibold uppercase tracking-wider">Customer Portal</span>
                <h1 class="text-3xl font-bold mt-2">សួស្តី, {{ Auth::user()->first_name }}!</h1>
                <p class="text-indigo-200 text-sm mt-1">រីករាយក្នុងការទិញទំនិញ និងគ្រប់គ្រងរាល់ការបញ្ជាទិញរបស់អ្នកនៅទីនេះ។</p>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="w-full md:w-auto">
                @csrf
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-xl font-medium shadow-sm transition">
                    Log Out
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase">My Orders</span>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">0 Orders</h3>
                </div>
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl text-xl">🛍️</div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase">Digital Downloads</span>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">0 Files</h3>
                </div>
                <div class="p-3 bg-purple-50 text-purple-600 rounded-xl text-xl">💾</div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase">Shipping Country</span>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">Cambodia (KH)</h3>
                </div>
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl text-xl">📍</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="font-bold text-gray-800">Recent Paid Purchases</h3>
                    <a href="#" class="text-xs font-semibold text-indigo-600 hover:underline">View All</a>
                </div>
                <div class="p-8 text-center">
                    <p class="text-gray-400 text-sm italic">អ្នកមិនទាន់មានប្រវត្តិកាលបញ្ជាទិញទំនិញនៅឡើយទេ។</p>
                    <a href="/" class="mt-4 inline-block bg-indigo-600 text-white text-xs px-4 py-2 rounded-lg font-medium hover:bg-indigo-700 transition">Go Shopping</a>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="font-bold text-gray-800 border-b pb-3 mb-4">Account Information</h3>
                <div class="space-y-4 text-sm">
                    <div>
                        <span class="text-gray-400 block text-xs font-medium uppercase">Full Name</span>
                        <span class="text-gray-700 font-semibold">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
                    </div>
                    <div>
                        <span class="text-gray-400 block text-xs font-medium uppercase">Email Address</span>
                        <span class="text-gray-700 font-semibold">{{ Auth::user()->email }}</span>
                    </div>
                    <div>
                        <span class="text-gray-400 block text-xs font-medium uppercase">Primary Address</span>
                        <span class="text-gray-700 font-semibold">{{ Auth::user()->address ?? 'មិនទាន់កំណត់' }}</span>
                    </div>
                </div>
                <div class="mt-6 pt-4 border-t">
                    <a href="#" class="w-full text-center block bg-gray-50 border hover:bg-gray-100 text-gray-700 text-xs font-semibold py-2.5 rounded-xl transition">
                        ✏️ Edit Profile Address
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection