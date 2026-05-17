<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopcart - E-Commerce</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<meta name="csrf-token" content="{{ csrf_token() }}"> </head>
<body class="bg-gray-50 text-gray-900 font-sans antialiased">

    @include('layouts.navbar')

    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 mt-4">
            <div class="bg-emerald-100 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl shadow-sm relative" role="alert">
                <strong class="font-bold">ជោគជ័យ!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    <footer class="bg-white border-t border-gray-100 mt-20 py-8 text-center text-gray-500 text-sm">
        <p>&copy; {{ date('Y') }} Shopcart. All rights reserved.</p>
    </footer>

</body>
<script>
    // មុខងារបាញ់ទិន្នន័យទៅកាន់ Laravel ពេលចុចប៊ូតុង
    function addToCart(productId) {
        fetch(`/cart/add/${productId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                // ១. លោតដូរលេខនៅលើកន្ត្រក Navbar ភ្លាមៗ
                document.getElementById('cart-count').innerText = data.totalItems;
                
                // ២. លោតសារបញ្ជាក់ថាបាន Add ចូលជោគជ័យ
                alert(data.message); 
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>
</html>