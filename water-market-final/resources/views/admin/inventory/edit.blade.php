@extends('layouts.app')

@section('title', 'Edit Inventory Item')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <a href="{{ route('inventory.index') }}" class="text-blue-600 hover:underline flex items-center gap-2 mb-4">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Back to Inventory
        </a>
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Edit Item: {{ $inventory->name }}</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
        <form action="{{ route('inventory.update', $inventory->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Item Name</label>
                    <input type="text" name="name" id="name" required value="{{ $inventory->name }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all">
                </div>
                <div>
                    <label for="category" class="block text-sm font-bold text-slate-700 mb-2">Category</label>
                    <input type="text" name="category" id="category" required value="{{ $inventory->category }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all">
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-bold text-slate-700 mb-2">Description</label>
                <textarea name="description" id="description" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all h-24">{{ $inventory->description }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="quantity" class="block text-sm font-bold text-slate-700 mb-2">Quantity</label>
                    <input type="number" name="quantity" id="quantity" required min="0" value="{{ $inventory->quantity }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all">
                </div>
                <div>
                    <label for="unit" class="block text-sm font-bold text-slate-700 mb-2">Unit</label>
                    <input type="text" name="unit" id="unit" required value="{{ $inventory->unit }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all">
                </div>
            </div>

            <div>
                <label for="price" class="block text-sm font-bold text-slate-700 mb-2">Unit Price (₱)</label>
                <input type="number" name="price" id="price" required min="0" step="0.01" value="{{ $inventory->price }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all">
            </div>

            <button type="submit" class="w-full py-4 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                Update Item
            </button>
        </form>
    </div>
</div>
@endsection
