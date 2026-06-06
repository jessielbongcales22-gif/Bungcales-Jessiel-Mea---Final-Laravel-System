@extends('layouts.app')

@section('title', 'Add Inventory Item')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <a href="{{ route('inventory.index') }}" class="text-blue-600 hover:underline flex items-center gap-2 mb-4">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Back to Inventory
        </a>
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Add New Item</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
        <form action="{{ route('inventory.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Item Name</label>
                    <input type="text" name="name" id="name" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all" placeholder="e.g. Purified Water">
                </div>
                <div>
                    <label for="category" class="block text-sm font-bold text-slate-700 mb-2">Category</label>
                    <input type="text" name="category" id="category" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all" placeholder="e.g. Water, Container">
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-bold text-slate-700 mb-2">Description</label>
                <textarea name="description" id="description" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all h-24" placeholder="Brief description of the product..."></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="quantity" class="block text-sm font-bold text-slate-700 mb-2">Initial Quantity</label>
                    <input type="number" name="quantity" id="quantity" required min="0" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all" placeholder="0">
                </div>
                <div>
                    <label for="unit" class="block text-sm font-bold text-slate-700 mb-2">Unit</label>
                    <input type="text" name="unit" id="unit" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all" placeholder="e.g. containers, pcs">
                </div>
            </div>

            <div>
                <label for="price" class="block text-sm font-bold text-slate-700 mb-2">Unit Price (₱)</label>
                <input type="number" name="price" id="price" required min="0" step="0.01" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all" placeholder="0.00">
            </div>

            <button type="submit" class="w-full py-4 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                Save Item
            </button>
        </form>
    </div>
</div>
@endsection
