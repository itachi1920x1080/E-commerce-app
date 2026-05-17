@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <h1 class="text-3xl font-black text-gray-900 mb-8">Shopping Cart</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    @if(session('cart') && count(session('cart')) > 0)
                        <ul class="divide-y divide-gray-100">
                            @php $totalPrice = 0; @endphp
                            
                            @foreach(session('cart') as $id => $details)
                                @php $totalPrice += $details['price'] * $details['quantity']; @endphp
                                <li class="p-6 flex flex-col sm:flex-row items-center gap-6 hover:bg-gray-50 transition">
                                    
                                    <div class="w-24 h-24 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0">
                                        @if($details['image'])
                                            <img src="{{ asset('storage/' . $details['image']) }}" alt="{{ $details['name'] }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-3xl">📦</div>
                                        @endif
                                    </div>

                                    <div class="flex-grow text-center sm:text-left">
                                        <h3 class="text-lg font-bold text-gray-900">
                                            <a href="{{ route('product.show', $details['slug']) }}" class="hover:text-emerald-600 transition">{{ $details['name'] }}</a>
                                        </h3>
                                        <p class="text-emerald-600 font-black mt-1">${{ number_format($details['price'], 2) }}</p>
                                    </div>

                                    <div class="flex items-center gap-4">
                                        <div class="flex items-center border border-gray-200 rounded-lg bg-white px-3 py-1">
                                            <span class="text-sm font-bold text-gray-600">Qty: {{ $details['quantity'] }}</span>
                                        </div>

                                        <form action="{{ route('cart.remove', $id) }}" method="POST" class="m-0">
                                            @csrf
                                            <button type="submit" class="w-10 h-10 flex items-center justify-center bg-red-50 text-red-500 rounded-lg hover:bg-red-500 hover:text-white transition">
                                                🗑️
                                            </button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="p-12 text-center">
                            <div class="text-6xl mb-4">🛒</div>
                            <h2 class="text-xl font-bold text-gray-900 mb-2">កន្ត្រករបស់អ្នកទទេស្អាត!</h2>
                            <p class="text-gray-500 mb-6">សូមត្រឡប់ទៅហាងដើម្បីស្វែងរកទំនិញដែលអ្នកពេញចិត្ត។</p>
                            <a href="{{ route('shop.index') }}" class="inline-block bg-emerald-600 text-white font-bold px-6 py-3 rounded-full hover:bg-emerald-700 transition">
                                ទៅកាន់ហាងទំនិញ
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-28">
                    <h2 class="text-lg font-black text-gray-900 mb-6">Order Summary</h2>
                    
                    @if(session('cart') && count(session('cart')) > 0)
                        <div class="space-y-3 text-sm text-gray-600 border-b border-gray-100 pb-4 mb-4">
                            <div class="flex justify-between">
                                <span>Subtotal</span>
                                <span class="font-bold text-gray-900">${{ number_format($totalPrice ?? 0, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Shipping</span>
                                <span class="text-emerald-600 font-bold">Free</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Tax</span>
                                <span class="font-bold text-gray-900">$0.00</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mb-6">
                            <span class="text-lg font-black text-gray-900">Total</span>
                            <span class="text-2xl font-black text-emerald-600">${{ number_format($totalPrice ?? 0, 2) }}</span>
                        </div>

                        <button class="w-full bg-gray-900 text-white font-bold px-6 py-4 rounded-xl hover:bg-emerald-600 transition shadow-lg transform hover:-translate-y-1">
                            Proceed to Checkout ➡️
                        </button>
                    @else
                        <div class="text-center text-gray-400 py-4">
                            គ្មានទំនិញសម្រាប់គិតលុយទេ
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection