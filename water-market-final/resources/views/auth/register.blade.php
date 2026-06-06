@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-[80vh]">
    <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-xl">
        <h2 class="text-2xl font-bold text-center mb-6">Create Account</h2>
        
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
            
            <div>
                <label class="block text-sm font-medium">Full Name</label>
                <input type="text" name="name" required class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium">Email Address</label>
                <input type="email" name="email" required class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium">Delivery Address</label>
                <textarea name="address" required class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 h-24"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium">Password</label>
                <input type="password" name="password" required class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium">Confirm Password</label>
                <input type="password" name="password_confirmation" required class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 transition">
                Sign Up
            </button>
        </form>
    </div>
</div>
@endsection
