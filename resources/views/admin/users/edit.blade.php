@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
        
        <div class="p-6 bg-white border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Edit User: {{ $user->first_name }} {{ $user->last_name }}</h2>
            <a href="{{ route('admin.users.index') }}" class="text-indigo-600 hover:text-indigo-900 font-medium">&larr; Back to List</a>
        </div>

        <div class="p-6 bg-white">

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg text-sm font-medium shadow-sm">
                    <strong class="block font-bold text-red-900 mb-1.5">⚠️ មានបញ្ហាខុសឆ្គង៖</strong>
                    <ul class="list-disc pl-5 space-y-1 text-xs text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT') <div class="mb-8 border-b pb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Personal Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700">First Name <span class="text-red-500">*</span></label>
                            <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $user->first_name) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-3 py-2 border outline-none">
                        </div>

                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name <span class="text-red-500">*</span></label>
                            <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $user->last_name) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-3 py-2 border outline-none">
                        </div>

                        <div class="md:col-span-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email Address <span class="text-red-500">*</span></label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-3 py-2 border outline-none">
                        </div>
                    </div>
                </div>

                <div class="mb-8 border-b pb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Address Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700">Street Address</label>
                            <input type="text" name="address" id="address" value="{{ old('address', $address?->address) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-3 py-2 border outline-none">
                        </div>

                        <div class="md:col-span-2">
                            <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                            <input type="text" name="city" id="city" value="{{ old('city', $address?->city) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-3 py-2 border outline-none">
                        </div>

                        <div class="md:col-span-2">
                            <label for="state" class="block text-sm font-medium text-gray-700">State / Province</label>
                            <input type="text" name="state" id="state" value="{{ old('state', $address?->state) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-3 py-2 border outline-none">
                        </div>

                        <div class="md:col-span-2">
                            <label for="zip_code" class="block text-sm font-medium text-gray-700">Zip Code</label>
                            <input type="text" name="zip_code" id="zip_code" value="{{ old('zip_code', $address?->zip_code) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-3 py-2 border outline-none">
                        </div>
                    </div>
                </div>

                <div class="mb-8 border-b pb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Security <span class="text-xs font-normal text-gray-400">(Leave blank if you do not want to change password)</span></h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                            <input type="password" name="password" id="password" placeholder="••••••••"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-3 py-2 border outline-none">
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-3 py-2 border outline-none">
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Account Settings</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="role_id" class="block text-sm font-medium text-gray-700">Assign Role *</label>
                            <select id="role_id" name="role_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-3 py-2 border bg-white outline-none">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id', $user->roles->first()?->id) == $role->id ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option> 
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Account Status</label>
                            <div class="flex items-center space-x-4 mt-2">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="active" value="1" class="text-indigo-600 focus:ring-indigo-500" {{ old('active', $user->active) == '1' ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-700">Active</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name="active" value="0" class="text-indigo-600 focus:ring-indigo-500" {{ old('active', $user->active) == '0' ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-700">Inactive</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.users.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500 transition-colors">
                        Update User
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection