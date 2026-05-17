@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
        
        <div class="p-6 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Add Advanced Product</h2>
            <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-xs font-semibold rounded-full">E-Commerce Mode</span>
        </div>

        <div class="p-6">
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg text-sm font-medium shadow-sm flex items-center">
                    <span class="mr-2 text-base">✅</span> {{ session('success') }}
                </div>
            @endif

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

            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Product SKU *</label>
                        <input type="text" name="sku" value="{{ old('sku') }}" required class="mt-1 w-full p-2.5 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none transition-all border-gray-300">
                        @error('sku') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700">Product Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="mt-1 w-full p-2.5 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none transition-all border-gray-300">
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Regular Price *</label>
                        <input type="number" name="regular_price" step="0.01" value="{{ old('regular_price', '0.00') }}" required class="mt-1 w-full p-2.5 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none transition-all border-gray-300">
                        @error('regular_price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Discount Price *</label>
                        <input type="number" name="discount_price" step="0.01" value="{{ old('discount_price', '0.00') }}" required class="mt-1 w-full p-2.5 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none transition-all border-gray-300">
                        @error('discount_price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Stock Qty *</label>
                        <input type="number" name="qty" value="{{ old('qty', '0') }}" min="0" required class="mt-1 w-full p-2.5 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none transition-all border-gray-300">
                        @error('qty') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Currency</label>
                            <select name="currency" class="mt-1 w-full p-2.5 border bg-white rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none border-gray-300">
                                <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD ($)</option>
                                <option value="KHR" {{ old('currency') == 'KHR' ? 'selected' : '' }}>KHR (៛)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Status *</label>
                            <select name="product_status_id" required class="mt-1 w-full p-2.5 border bg-white rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none border-gray-300">
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}" {{ old('product_status_id') == $status->id ? 'selected' : '' }}>
                                        {{ ucfirst($status->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex gap-6 mb-6 p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <label class="flex items-center text-sm font-medium text-gray-700 cursor-pointer select-none">
                        <input type="checkbox" name="is_free" value="1" {{ old('is_free') ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 rounded mr-2 border-gray-300 focus:ring-indigo-500"> Is Free Product
                    </label>
                    <label class="flex items-center text-sm font-medium text-gray-700 cursor-pointer select-none">
                        <input type="checkbox" name="taxable" value="1" {{ old('taxable') ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 rounded mr-2 border-gray-300 focus:ring-indigo-500"> Charge Taxable
                    </label>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Select Categories *</label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 p-4 border rounded-lg max-h-40 overflow-y-auto bg-white shadow-inner border-gray-300">
                        @foreach($categories as $category)
                            <label class="flex items-center text-sm text-gray-600 cursor-pointer hover:text-gray-900 select-none">
                                <input type="checkbox" name="categories[]" value="{{ $category->id }}" 
                                    {{ is_array(old('categories')) && in_array($category->id, old('categories')) ? 'checked' : '' }}
                                    class="rounded text-indigo-600 mr-2 focus:ring-indigo-500 border-gray-300"> {{ $category->name }}
                            </label>
                        @endforeach
                    </div>
                    @error('categories') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Product Tags</label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 p-4 border rounded-lg max-h-40 overflow-y-auto bg-gray-50/50 shadow-inner border-gray-300">
                        @foreach($tags as $tag)
                            <label class="flex items-center text-sm text-gray-600 cursor-pointer hover:text-gray-900 select-none">
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}" 
                                    {{ is_array(old('tags')) && in_array($tag->id, old('tags')) ? 'checked' : '' }}
                                    class="rounded text-indigo-600 mr-2 focus:ring-indigo-500 border-gray-300"> #{{ $tag->name }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Product Image</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-indigo-500 transition-colors bg-gray-50/30">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4-4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 justify-center">
                                <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                    <span id="upload-label-text">Upload a file</span>
                                    <input id="image" name="image" type="file" accept="image/*" class="sr-only">
                                </label>
                                <p class="pl-1 text-gray-500">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                        </div>
                    </div>
                    @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700">Product Description</label>
                    <textarea name="description" rows="4" class="mt-1 w-full p-2.5 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none placeholder-gray-400 transition-all border-gray-300" placeholder="Write full specifications of the item...">{{ old('description') }}</textarea>
                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end pt-4 border-t gap-3 border-gray-200">
                    <button type="reset" class="px-5 py-2.5 border rounded-lg font-medium bg-white text-gray-700 hover:bg-gray-50 transition border-gray-300">Reset</button>
                    <button type="submit" class="px-5 py-2.5 rounded-lg font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition shadow-sm">Save Advanced Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('image').addEventListener('change', function(e) {
        let label = document.getElementById('upload-label-text');
        if(e.target.files.length > 0) {
            label.innerText = e.target.files[0].name;
            label.className = "relative cursor-pointer bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded font-bold";
        } else {
            label.innerText = "Upload a file";
            label.className = "relative cursor-pointer bg-white font-medium text-indigo-600";
        }
    });
</script>
@endsection