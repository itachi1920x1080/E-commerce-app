@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between p-6 bg-white rounded-xl shadow-sm border mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Product Management</h1>
                <p class="text-sm text-gray-500 mt-1">គ្រប់គ្រងបញ្ជីទំនិញ សារពើភណ្ឌ និងតម្លៃផលិតផលនៅក្នុងហាងរបស់អ្នក។</p>
            </div>
            <div>
                <a href="{{ route('admin.products.create') }}" class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition shadow-sm gap-2">
                    📦 Add New Product
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg text-sm font-medium shadow-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="p-4">Product Details</th>
                            <th class="p-4">SKU</th>
                            <th class="p-4">Price</th>
                            <th class="p-4">Stock Qty</th>
                            <th class="p-4">Type</th>
                            <th class="p-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($products as $product)
                            <tr class="hover:bg-gray-50/80 transition">
                                <td class="p-4 flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-lg bg-gray-100 border overflow-hidden flex-shrink-0">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-xl bg-gray-50 text-gray-400">📦</div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900">{{ $product->name }}</div>
                                        <div class="text-xs text-gray-400 mt-0.5 max-w-xs truncate">Slug: {{ $product->slug }}</div>
                                    </div>
                                </td>

                                <td class="p-4 font-mono text-xs text-gray-600">
                                    {{ $product->sku }}
                                </td>

                                <td class="p-4">
                                    @php
                                        $currencySymbol = ($product->currency == 'KHR') ? '៛' : '$';
                                        $isDiscounted = $product->discount_price > 0 && $product->discount_price < $product->regular_price;
                                    @endphp

                                    @if($isDiscounted)
                                        <div class="font-bold text-gray-900">{{ $currencySymbol }}{{ number_format($product->discount_price, 2) }}</div>
                                        <div class="text-xs text-gray-400 line-through">{{ $currencySymbol }}{{ number_format($product->regular_price, 2) }}</div>
                                    @else
                                        <div class="font-bold text-gray-900">{{ $currencySymbol }}{{ number_format($product->regular_price, 2) }}</div>
                                    @endif
                                </td>

                                <td class="p-4">
                                    @if($product->qty == 0)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-200">
                                            Out of Stock
                                        </span>
                                    @elseif($product->qty <= 5)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200">
                                            Low Stock ({{ $product->qty }})
                                        </span>
                                    @else
                                        <span class="font-semibold text-gray-700">{{ number_format($product->qty) }} Units</span>
                                    @endif
                                </td>

                                <td class="p-4">
                                    <span class="px-2.5 py-1 bg-indigo-50 text-indigo-700 text-xs font-semibold rounded-md border border-indigo-100">
                                        E-Commerce Item
                                    </span>
                                </td>

                                <td class="p-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="px-3 py-1.5 bg-white text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg text-xs font-bold transition border border-gray-200 shadow-sm">
                                            ✏️ Edit
                                        </a>
                                        
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('តើបងពិតជាចង់លុបទំនិញនេះមែនទេ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 bg-white text-red-500 hover:bg-red-50 rounded-lg text-xs font-bold transition border border-gray-200 shadow-sm hover:border-red-100">
                                                🗑️ Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-12 text-center text-gray-400">
                                    <div class="text-5xl mb-3">📦</div>
                                    <div class="text-base font-bold text-gray-700 mb-1">មិនទាន់មានផលិតផលនៅឡើយទេ</div>
                                    <div class="text-xs text-gray-400">សូមចុចប៊ូតុង Add New Product ដើម្បីបង្កើតផលិតផលដំបូងរបស់អ្នក។</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($products->hasPages())
                <div class="p-4 border-t bg-gray-50/50">
                    {{ $products->links() }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection