@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8 text-center">
        
        <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight lg:text-6xl">
            Welcome to MyStore!
        </h1>
        
        <p class="max-w-xl mt-5 mx-auto text-xl text-gray-500">
            @auth
                សួស្តី, <span class="font-semibold text-indigo-600">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>! រីករាយការត្រឡប់មកវិញ។
            @else
                This is your new E-Commerce homepage. We will display your amazing products, categories, and promotions right here!
            @endauth
        </p>
        
        <div class="mt-8 flex justify-center items-center gap-4">
            @guest
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm transition">
                    Create an Account
                </a>
                
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-5 py-3 border border-gray-300 text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-gray-50 shadow-sm transition">
                    Sign In
                </a>
            @else
            <a href="{{ route('shop.index') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm transition">
            Go to shop
        </a>

                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-red-600 hover:text-red-800 font-medium cursor-pointer">
                        Log Out
                    </button>
                </form>
            @endguest
        </div>

    </div>
</div>
@endsection