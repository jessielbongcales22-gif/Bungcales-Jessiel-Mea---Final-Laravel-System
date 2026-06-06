@extends('layouts.app')

@section('title', 'Inventory Management')

@section('content')
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{ 
    search: '',
    items: [
        @foreach($items as $item)
        { 
            id: {{ $item->id }}, 
            name: '{{ $item->name }}', 
            category: '{{ $item->category }}', 
            description: '{{ $item->description ?? "No description" }}', 
            quantity: {{ $item->quantity }}, 
            unit: '{{ $item->unit }}', 
            price: {{ $item->price }},
            editUrl: '{{ route('inventory.edit', $item->id) }}',
            deleteUrl: '{{ route('inventory.destroy', $item->id) }}'
        },
        @endforeach
    ],
    get filteredItems() {
        return this.items.filter(i => i.name.toLowerCase().includes(this.search.toLowerCase()))
    }
}">
    <!-- Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-900">{{ count($items) }}</p>
                <p class="text-sm font-medium text-slate-500">Total Products</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-rose-50 rounded-xl flex items-center justify-center text-rose-600">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-900">{{ $items->where('quantity', '<', 50)->count() }}</p>
                <p class="text-sm font-medium text-slate-500">Low Stock Items</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-900">₱{{ number_format($items->sum(fn($i) => $i->price * $i->quantity), 2) }}</p>
                <p class="text-sm font-medium text-slate-500">Inventory Value</p>
            </div>
        </div>
    </div>

    <!-- Search and Add Row -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-8">
        <div class="relative w-full md:w-96">
            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            </div>
            <input type="text" x-model="search" placeholder="Search products..." class="w-full pl-12 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition shadow-sm">
        </div>
        <a href="{{ route('inventory.create') }}" class="w-full md:w-auto px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-200 flex items-center justify-center gap-2">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Add Product
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center gap-3">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            <span class="font-bold text-sm">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <template x-for="item in filteredItems" :key="item.id">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-xl transition-all duration-300 group">
                <div class="p-6">
                    <!-- Card Header -->
                    <div class="flex justify-between items-start mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-cyan-50 rounded-2xl flex items-center justify-center text-cyan-600 group-hover:bg-cyan-600 group-hover:text-white transition-colors duration-300">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900" x-text="item.name"></h3>
                                <p class="text-xs text-slate-400 font-medium" x-text="item.category"></p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <a :href="item.editUrl" class="p-2 text-blue-400 hover:bg-blue-50 rounded-lg transition-colors">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                            </a>
                            <form :action="item.deleteUrl" method="POST" onsubmit="return confirm('Delete this product?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-rose-400 hover:bg-rose-50 rounded-lg transition-colors">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Description -->
                    <p class="text-sm text-slate-500 mb-6 line-clamp-2" x-text="item.description"></p>

                    <!-- Price and Stock -->
                    <div class="flex justify-between items-end mb-4">
                        <p class="text-2xl font-black text-blue-600" x-text="'₱' + item.price"></p>
                        <div class="flex items-center gap-2">
                            <span :class="item.quantity < 50 ? 'bg-rose-500' : 'bg-emerald-500'" class="w-2 h-2 rounded-full"></span>
                            <span class="text-sm font-bold" :class="item.quantity < 50 ? 'text-rose-600' : 'text-emerald-600'" x-text="item.quantity + ' ' + item.unit"></span>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                        <div :style="'width: ' + Math.min((item.quantity / 500) * 100, 100) + '%'" 
                             :class="item.quantity < 50 ? 'bg-rose-500' : 'bg-emerald-500'"
                             class="h-full transition-all duration-500"></div>
                    </div>
                </div>
            </div>
        </template>
        
        <template x-if="filteredItems.length === 0">
            <div class="col-span-full py-20 text-center bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200">
                <p class="text-slate-400 font-bold">No products found matching your search.</p>
            </div>
        </template>
    </div>
</div>
@endsection
