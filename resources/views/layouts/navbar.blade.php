<div class="bg-emerald-900 text-white text-xs py-2 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
    <div class="flex items-center gap-2">
        <span>📞 +001234567890</span>
    </div>
    <div class="hidden md:block font-medium">
        Get 50% Off on Selected Items | <a href="#" class="underline hover:text-emerald-200">Shop Now</a>
    </div>
    <div class="flex items-center gap-4">
        <select class="bg-transparent border-none outline-none cursor-pointer text-emerald-900 bg-white rounded px-1"><option>Eng</option></select>
        <select class="bg-transparent border-none outline-none cursor-pointer text-emerald-900 bg-white rounded px-1"><option>Location</option></select>
    </div>
</div>

<nav class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            
            <div class="flex items-center gap-8">
                <a href="/" class="flex items-center gap-2 text-2xl font-black text-emerald-800 tracking-tighter">
                    🛒 Shopcart
                </a>
                
                <div class="hidden lg:flex space-x-6">
                    <a href="/" class="text-gray-900 hover:text-emerald-600 text-sm font-semibold transition">Home</a>
                    <a href="{{ route('shop.index') }}" class="text-gray-500 hover:text-emerald-600 text-sm font-semibold transition">Shop</a>
                </div>
            </div>

            <div class="relative w-full max-w-md hidden md:block mx-4">
                <div class="relative flex items-center">
                    <input type="text" id="searchInput" placeholder="Search Product..." class="w-full bg-gray-100/80 text-sm rounded-full py-2.5 px-5 outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                    <button class="absolute right-4 text-gray-500 hover:text-emerald-600">🔍</button>
                </div>

                <div id="searchDropdown" class="hidden absolute top-12 left-0 w-full bg-white rounded-2xl shadow-2xl border border-gray-100 p-2 z-50">
                    </div>
            </div>

            <div class="flex items-center space-x-4">
                
                @php $cartCount = count((array) session('cart')); @endphp
                <a href="{{ route('cart.index') }}" class="text-gray-600 hover:text-emerald-600 text-sm font-semibold transition flex items-center gap-1">
                    🛒 Cart 
                    <span id="cart-count" class="bg-emerald-100 text-emerald-800 text-xs font-bold px-2 py-0.5 rounded-full ml-1">
                        {{ $cartCount }}
                    </span>
                </a>

                <div class="w-px h-6 bg-gray-200 hidden sm:block"></div>

                @guest
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-500 hover:text-emerald-600 transition flex items-center gap-1">👤 Log in</a>
                    <a href="{{ route('register') }}" class="hidden sm:inline-flex items-center px-4 py-2 border border-transparent text-sm font-bold rounded-full text-white bg-emerald-600 hover:bg-emerald-700 transition shadow-sm transform hover:-translate-y-0.5">
                        Register
                    </a>
                @endguest

                @auth
                    @if(auth()->user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}" class="text-xs font-bold text-indigo-700 bg-indigo-50 border border-indigo-200 px-3 py-1.5 rounded-full hover:bg-indigo-100 transition shadow-sm">💻 Admin</a>
                    @elseif(auth()->user()->hasRole('moderator'))
                        <a href="{{ route('moderator.dashboard') }}" class="text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-3 py-1.5 rounded-full hover:bg-emerald-100 transition shadow-sm">🛡️ Mod</a>
                    @else
                        <a href="{{ route('customer.dashboard') }}" class="text-xs font-bold text-blue-700 bg-blue-50 border border-blue-200 px-3 py-1.5 rounded-full hover:bg-blue-100 transition shadow-sm">🛒 Dash</a>
                    @endif

                    <div class="relative group cursor-pointer hidden md:block pl-2">
                        <span class="text-sm font-bold text-gray-700 hover:text-emerald-600 transition flex items-center gap-1">
                            Hi, {{ auth()->user()->first_name }} ⌄
                        </span>
                        <div class="absolute right-0 mt-2 w-32 bg-white rounded-xl shadow-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
                            <form method="POST" action="{{ route('logout') }}" class="m-0 p-1.5">
                                @csrf
                                <button type="submit" class="w-full text-left text-sm font-bold text-red-500 hover:bg-red-50 hover:text-red-600 px-3 py-2 rounded-lg transition">Log Out</button>
                            </form>
                        </div>
                    </div>
                @endauth
                
            </div>
        </div>
    </div>
</nav>