<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md border border-gray-200">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Create Account</h2>
        
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">First Name</label>
                    <input type="text" name="first_name" value="{{ old('first_name') }}" required class="mt-1 w-full p-2 border rounded-md focus:ring-2 focus:ring-indigo-500 outline-none">
                    @error('first_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Last Name</label>
                    <input type="text" name="last_name" value="{{ old('last_name') }}" required class="mt-1 w-full p-2 border rounded-md focus:ring-2 focus:ring-indigo-500 outline-none">
                    @error('last_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="mt-1 w-full p-2 border rounded-md focus:ring-2 focus:ring-indigo-500 outline-none">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" required class="mt-1 w-full p-2 border rounded-md focus:ring-2 focus:ring-indigo-500 outline-none">
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input type="password" name="password_confirmation" required class="mt-1 w-full p-2 border rounded-md focus:ring-2 focus:ring-indigo-500 outline-none">
            </div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white p-2 rounded-md font-medium transition duration-200">Sign Up</button>
        </form>

        <p class="mt-4 text-sm text-center text-gray-600">Already have an account? <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Log in</a></p>
    </div>
</body>
</html>