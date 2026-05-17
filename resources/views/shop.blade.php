@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="bg-gradient-to-r Framework from-indigo-900 to-slate-800 rounded-2xl p-8 md:p-12 text-white shadow-lg mb-10">
            <h1 class="text-3xl md:text-4xl font-black tracking-tight">Our Product Catalog</h1>
            <p class="text-indigo-200 text-sm md:text-base mt-2 max-w-xl">ស្វែងរកទំនិញទំនើបៗ គុណភាពខ្ពស់ ព្រមទាំងមានការបញ្ចុះតម្លៃពិសេសប្រចាំថ្ងៃសម្រាប់អ្នក។</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <div class="lg:col-span-1 bg-white p-6 rounded-2xl border border-gray-200/80 shadow-sm h-fit sticky top-20">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    📁 Product Categories
                </h3>
                <div class="space-y-2">
                    <a href="{{ url('/shop') }}" class="block px-3 py-2 rounded-xl text-sm font-semibold {{ !request('category') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition">
                        All Categories
                    </a>
                    @foreach($categories as $cat)
                        <a href="?category={{ $cat->slug }}" class="block px-3 py-2 rounded-xl text-sm font-medium {{ request('category') == $cat->slug ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>

                <div class="mt-8 pt-6 border-t border-gray-100">
                    <h4 class="text-sm font-bold text-gray-900 mb-3">Filter by Price</h4>
                    <div class="space-y-2">
                        <label class="flex items-center text-sm text-gray-600 cursor-pointer">
                            <input type="radio" name="price_filter" class="rounded text-indigo-600 mr-2"> Under $50
                        </label>
                        <label class="flex items-center text-sm text-gray-600 cursor-pointer">
                            <input type="radio" name="price_filter" class="rounded text-indigo-600 mr-2"> $50 to $200
                        </label>
                        <label class="flex items-center text-sm text-gray-600 cursor-pointer">
                            <input type="radio" name="price_filter" class="rounded text-indigo-600 mr-2"> Above $200
                        </label>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-3">
                
                <div class="bg-white p-4 rounded-xl border border-gray-200/80 shadow-sm mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <p class="text-sm text-gray-500 font-medium">Showing <span class="text-gray-800 font-bold">{{ $products->count() }}</span> products available</p>
                    <div class="flex items-center gap-2">
                        <label class="text-xs font-semibold text-gray-400 uppercase">Sort by:</label>
                        <select class="text-sm border-gray-200 rounded-lg p-1.5 bg-gray-50 text-gray-700 outline-none font-medium focus:ring-1 focus:ring-indigo-500">
                            <option>Latest Arrivals</option>
                            <option>Price: Low to High</option>
                            <option>Price: High to Low</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @forelse($products as $product)
                        <div class="group bg-white rounded-2xl border border-gray-200/70 shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-md hover:border-gray-300 transition duration-300">
                            
                            <div class="relative aspect-square w-full overflow-hidden bg-gray-100">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="h-full w-full object-cover object-center group-hover:scale-105 transition duration-500">
                                @else
                                    <img src="https://images.unsplash.com/photo-1531403009284-440f080d1e12?q=80&w=600&auto=format&fit=crop" 
                                         alt="Placeholder Image" 
                                         class="h-full w-full object-cover object-center opacity-60">
                                @endif

                                @if($product->discount_price > 0 && $product->discount_price < $product->regular_price)
                                    <span class="absolute top-3 left-3 bg-red-500 text-white text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-full shadow-sm">
                                        Sale
                                    </span>
                                @endif
                            </div>
                            
                            <div class="p-5 flex-grow flex flex-col justify-between">
                                <div>
                                    <span class="text-[11px] font-bold text-indigo-600 tracking-wide uppercase">
                                        {{ $product->categories->first()->name ?? 'General' }}
                                    </span>
                                    <h3 class="text-sm font-bold text-gray-800 mt-1 line-clamp-2 hover:text-indigo-600 transition">
                                        <a href="#">{{ $product->name }}</a>
                                    </h3>
                                    <p class="text-xs text-gray-400 font-mono mt-0.5">SKU: {{ $product->sku }}</p>
                                </div>
                                
                                <div class="flex items-center justify-between mt-5 pt-3 border-t border-gray-50">
                                    <div class="flex flex-col">
                                        @if($product->discount_price > 0 && $product->discount_price < $product->regular_price)
                                            <span class="text-lg font-black text-gray-900">
                                                {{ $product->currency == 'USD' ? '$' : '៛' }}{{ number_format($product->discount_price, 2) }}
                                            </span>
                                            <span class="text-xs text-gray-400 line-through">
                                                {{ $product->currency == 'USD' ? '$' : '៛' }}{{ number_format($product->regular_price, 2) }}
                                            </span>
                                        @else
                                            <span class="text-lg font-black text-gray-900">
                                                {{ $product->currency == 'USD' ? '$' : '៛' }}{{ number_format($product->regular_price, 2) }}
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <button onclick="addToCart('{{ $product->id }}')" class="bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white p-2.5 rounded-xl text-sm font-bold transition shadow-sm active:scale-95">
                                        🛒
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full bg-white rounded-2xl border p-12 text-center shadow-sm">
                            <span class="text-4xl block mb-3">📦</span>
                            <p class="text-gray-500 font-medium">មិនទាន់មានផលិតផលបង្ហោះលក់នៅក្នុងប្រភេទនេះនៅឡើយទេ។</p>
                        </div>
                    @endforelse
                </div>

            </div>

        </div>

    </div>
</div>
@endsection