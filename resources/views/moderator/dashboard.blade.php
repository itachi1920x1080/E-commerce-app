@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        
        <div class="bg-emerald-900 rounded-2xl p-6 md:p-8 text-white shadow-lg mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <span class="bg-emerald-700 text-emerald-200 text-xs px-3 py-1 rounded-full font-semibold uppercase tracking-wider">Moderator Panel</span>
                <h1 class="text-3xl font-bold mt-2">សួស្តីលោក, {{ Auth::user()->first_name }}</h1>
                <p class="text-emerald-200 text-sm mt-1">អ្នកមានសិទ្ធិគ្រប់គ្រងខ្លឹមសារផលិតផល ពិនិត្យ Review និងរក្សាសណ្តាប់ធ្នាប់ប្រព័ន្ធលក់ទំនិញ។</p>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="w-full md:w-auto">
                @csrf
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-xl font-medium shadow-sm transition">
                    Log Out
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between border-b pb-4 mb-4">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">📦 Product Reviewing</h2>
                        <span class="px-2.5 py-0.5 bg-amber-50 border border-amber-200 text-amber-700 text-xs font-semibold rounded-full">Draft Mode</span>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed mb-4">
                        ពិនិត្យមើលរាល់ទំនិញដែលបានបង្ហោះ និងកែប្រែស្ថានភាពផលិតផលចន្លោះពី **Draft**, **Active** ឬ **Archived** ដើម្បីអនុញ្ញាតឱ្យបង្ហាញនៅលើទំព័រមុខ (Frontend)។
                    </p>
                </div>
                <button class="w-full bg-emerald-600 hover:bg-emerald-700 text-white text-sm py-2.5 rounded-xl font-semibold shadow-sm transition">
                    Verify Store Catalog
                </button>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between border-b pb-4 mb-4">
                        <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">⭐ Review Moderation</h2>
                        <span class="px-2.5 py-0.5 bg-blue-50 border border-blue-200 text-blue-700 text-xs font-semibold rounded-full">Publish Control</span>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed mb-4">
                        គ្រប់គ្រងការបញ្ចេញមតិ (Comments) និងការវាយតម្លៃពិន្ទុផ្កាយរបស់អតិថិជន។ អ្នកអាចចុច **Publish** ដើម្បីបង្ហាញមតិ ឬលុបមតិដែលមិនសមរម្យចោល។
                    </p>
                </div>
                <button class="w-full bg-gray-800 hover:bg-gray-900 text-white text-sm py-2.5 rounded-xl font-semibold shadow-sm transition">
                    Moderate User Reviews
                </button>
            </div>

        </div>

    </div>
</div>
@endsection