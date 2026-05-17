@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <nav class="flex text-sm text-gray-500 font-medium mb-8">
            <a href="/" class="hover:text-emerald-600 transition">Home</a>
            <span class="mx-2">/</span>
            <a href="{{ route('shop.index') }}" class="hover:text-emerald-600 transition">Shop</a>
            <span class="mx-2">/</span>
            <a href="#" class="hover:text-emerald-600 transition">{{ $product->categories->first()?->name ?? 'General' }}</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900 truncate">{{ $product->name }}</span>
        </nav>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-0">
                
                <div class="p-8 md:p-12 bg-gray-50/50 flex items-center justify-center relative">
                    @if($product->discount_price > 0 && $product->discount_price < $product->regular_price)
                        <span class="absolute top-8 left-8 bg-red-500 text-white text-xs font-black uppercase tracking-wider px-3 py-1.5 rounded-full shadow-md z-10">
                            Sale
                        </span>
                    @endif

                    <div class="aspect-square w-full max-w-md rounded-2xl overflow-hidden shadow-lg border border-gray-200/50 bg-white">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover hover:scale-110 transition duration-700 cursor-zoom-in">
                        @else
                            <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover opacity-50">
                        @endif
                    </div>
                </div>

                <div class="p-8 md:p-12 flex flex-col justify-center">
                    
                    <span class="text-xs font-black tracking-widest text-emerald-600 uppercase mb-2">
                        {{ $product->categories->first()?->name ?? 'Uncategorized' }}
                    </span>
                    
                    <h1 class="text-3xl md:text-4xl font-black text-gray-900 mb-4 leading-tight">
                        {{ $product->name }}
                    </h1>
                    
                    <div class="flex items-center gap-4 mb-6">
                        @if($product->discount_price > 0 && $product->discount_price < $product->regular_price)
                            <span class="text-3xl font-black text-gray-900">
                                {{ $product->currency == 'USD' ? '$' : '៛' }}{{ number_format($product->discount_price, 2) }}
                            </span>
                            <span class="text-xl text-gray-400 line-through font-medium">
                                {{ $product->currency == 'USD' ? '$' : '៛' }}{{ number_format($product->regular_price, 2) }}
                            </span>
                        @else
                            <span class="text-3xl font-black text-gray-900">
                                {{ $product->currency == 'USD' ? '$' : '៛' }}{{ number_format($product->regular_price, 2) }}
                            </span>
                        @endif
                    </div>

                    <div class="prose prose-sm text-gray-500 mb-8 leading-relaxed">
                        {{ $product->description ?? 'No description available for this product at the moment.' }}
                    </div>

                    <div class="mb-8 space-y-2 text-sm text-gray-500">
                        <p><span class="font-bold text-gray-700">SKU:</span> {{ $product->sku }}</p>
                    </div>

                    <hr class="border-gray-100 mb-8">

                    <div class="flex items-center gap-4">
                        <div class="flex items-center border border-gray-200 rounded-full bg-white h-12 w-32 px-2 shadow-sm">
                            <button type="button" onclick="changeQty(-1)" class="w-8 h-8 flex items-center justify-center text-gray-500 hover:bg-gray-100 rounded-full font-bold transition">-</button>
                            <input type="number" id="productQty" value="1" min="1" class="w-full text-center border-none bg-transparent font-bold text-gray-900 focus:ring-0 p-0">
                            <button type="button" onclick="changeQty(1)" class="w-8 h-8 flex items-center justify-center text-gray-500 hover:bg-gray-100 rounded-full font-bold transition">+</button>
                        </div>
                        
                        <button onclick="addDetailToCart('{{ $product->id }}')" class="flex-1 bg-emerald-600 text-white h-12 rounded-full font-bold hover:bg-emerald-700 hover:shadow-lg hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                            🛒 Add to Cart
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // មុខងារបូកដកចំនួនទំនិញ
    function changeQty(amount) {
        const qtyInput = document.getElementById('productQty');
        let currentVal = parseInt(qtyInput.value);
        if (currentVal + amount >= 1) {
            qtyInput.value = currentVal + amount;
        }
    }

    // មុខងារបញ្ជូនទិន្នន័យ (ID + ចំនួន) ទៅកន្ត្រក
    function addDetailToCart(productId) {
        const quantity = document.getElementById('productQty').value;

        fetch(`/cart/add/${productId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ quantity: quantity }) // បាញ់ទិន្នន័យចំនួនទៅតាមហ្នឹងដែរ
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                // លោតដូរលេខនៅលើកន្ត្រក Navbar ខាងលើ
                const cartBadge = document.getElementById('cart-count');
                if(cartBadge) cartBadge.innerText = data.totalItems;
                
                alert(data.message); 
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>
@endsection