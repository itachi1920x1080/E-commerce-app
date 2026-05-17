<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md border border-gray-200">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Welcome Back</h2>
        
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="mt-1 w-full p-2 border rounded-md focus:ring-2 focus:ring-indigo-500 outline-none">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" required class="mt-1 w-full p-2 border rounded-md focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>

            <div class="flex items-center justify-between mb-6">
                <label class="flex items-center text-sm text-gray-600">
                    <input type="checkbox" name="remember" class="mr-2 text-indigo-600 rounded"> Remember me
                </label>
            </div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white p-2 rounded-md font-medium transition duration-200">Log In</button>
        </form>

        <p class="mt-4 text-sm text-center text-gray-600">Don't have an account? <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Sign up</a></p>
    </div>
</body>
</html>