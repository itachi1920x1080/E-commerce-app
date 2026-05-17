@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
        
        <div class="p-6 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Edit Product: {{ $product->name }}</h2>
            <a href="{{ route('admin.products.index') }}" class="text-indigo-600 hover:text-indigo-900 font-medium">&larr; Back to List</a>
        </div>

        <div class="p-6">
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg text-sm font-medium shadow-sm">
                    <strong class="block font-bold text-red-900 mb-1.5">⚠️ មិនអាចរក្សាទុកបានទេ ព្រោះមានបញ្ហា៖</strong>
                    <ul class="list-disc pl-5 space-y-1 text-xs text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Product SKU *</label>
                        <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" required class="mt-1 w-full p-2.5 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none transition-all border-gray-300">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700">Product Name *</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="mt-1 w-full p-2.5 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none transition-all border-gray-300">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Regular Price *</label>
                        <input type="number" name="regular_price" step="0.01" value="{{ old('regular_price', $product->regular_price) }}" required class="mt-1 w-full p-2.5 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none transition-all border-gray-300">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Discount Price *</label>
                        <input type="number" name="discount_price" step="0.01" value="{{ old('discount_price', $product->discount_price) }}" required class="mt-1 w-full p-2.5 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none transition-all border-gray-300">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Stock Qty *</label>
                        <input type="number" name="qty" value="{{ old('qty', $product->qty) }}" min="0" required class="mt-1 w-full p-2.5 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none transition-all border-gray-300">
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Currency</label>
                            <select name="currency" class="mt-1 w-full p-2.5 border bg-white rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none border-gray-300">
                                <option value="USD" {{ old('currency', $product->currency) == 'USD' ? 'selected' : '' }}>USD ($)</option>
                                <option value="KHR" {{ old('currency', $product->currency) == 'KHR' ? 'selected' : '' }}>KHR (៛)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Status *</label>
                            <select name="product_status_id" required class="mt-1 w-full p-2.5 border bg-white rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none border-gray-300">
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}" {{ old('product_status_id', $product->product_status_id) == $status->id ? 'selected' : '' }}>
                                        {{ ucfirst($status->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex gap-6 mb-6 p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <label class="flex items-center text-sm font-medium text-gray-700 cursor-pointer">
                        <input type="checkbox" name="is_free" value="1" {{ old('is_free', $product->is_free) ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 rounded mr-2 focus:ring-indigo-500"> Is Free Product
                    </label>
                    <label class="flex items-center text-sm font-medium text-gray-700 cursor-pointer">
                        <input type="checkbox" name="taxable" value="1" {{ old('taxable', $product->taxable) ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 rounded mr-2 focus:ring-indigo-500"> Charge Taxable
                    </label>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Select Categories *</label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 p-4 border rounded-lg max-h-40 overflow-y-auto bg-white shadow-inner border-gray-300">
                        @foreach($categories as $category)
                            <label class="flex items-center text-sm text-gray-600 cursor-pointer hover:text-gray-900">
                                <input type="checkbox" name="categories[]" value="{{ $category->id }}" 
                                    {{ in_array($category->id, old('categories', $productCategoryIds)) ? 'checked' : '' }}
                                    class="rounded text-indigo-600 mr-2 focus:ring-indigo-500 border-gray-300"> {{ $category->name }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Product Image (Leave blank to keep current image)</label>
                    
                    @if($product->image)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="Current Image" class="h-24 w-24 object-cover rounded-lg border shadow-sm">
                        </div>
                    @endif

                    <input name="image" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700">Product Description</label>
                    <textarea name="description" rows="4" class="mt-1 w-full p-2.5 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none placeholder-gray-400 border-gray-300">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="flex justify-end pt-4 border-t gap-3 border-gray-200">
                    <a href="{{ route('admin.products.index') }}" class="px-5 py-2.5 border rounded-lg font-medium bg-white text-gray-700 hover:bg-gray-50 transition border-gray-300">Cancel</a>
                    <button type="submit" class="px-5 py-2.5 rounded-lg font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition shadow-sm">Update Product</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection