@extends('layouts.app')

@section('title', 'Walk-in Checkout')

@section('content')
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{ 
    items: [
        @foreach($inventory as $item)
        { id: {{ $item->id }}, name: '{{ $item->name }}', price: {{ $item->price }}, stock: {{ $item->quantity }}, qty: 0 },
        @endforeach
    ],
    customerName: 'Walk-in Customer',
    paymentMethod: 'Cash',
    notes: '',
    get cart() { return this.items.filter(i => i.qty > 0) },
    get total() { return this.cart.reduce((sum, i) => sum + (i.price * i.qty), 0) },
    get cartCount() { return this.cart.reduce((sum, i) => sum + i.qty, 0) }
}">
    <!-- Teal Header Banner -->
    <div class="bg-[#008996] text-white p-8 rounded-3xl mb-10 flex items-center gap-6 shadow-lg shadow-teal-100/50">
        <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-md">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        </div>
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight">Walk-in Sale</h1>
            <p class="text-teal-50/80 font-medium mt-1">Quick checkout for in-store customers</p>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-10">
        <!-- Products Selection Column -->
        <div class="lg:col-span-1 flex-1">
            <h2 class="text-xl font-bold text-slate-800 mb-6">Select Products</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <template x-for="item in items" :key="item.id">
                    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm transition-all hover:shadow-md hover:border-teal-100 group">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-cyan-50 rounded-2xl flex items-center justify-center text-cyan-600 group-hover:bg-cyan-600 group-hover:text-white transition-colors duration-300">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                </div>
                                <div>
                                    <p class="font-black text-slate-800 text-lg" x-text="item.name"></p>
                                    <p class="text-xs text-slate-400 font-bold" x-text="item.stock + ' available'"></p>
                                </div>
                            </div>
                            <p class="text-2xl font-black text-teal-600" x-text="'₱' + item.price"></p>
                        </div>
                        
                        <button type="button" 
                            @click="if(item.qty < item.stock) item.qty++"
                            class="w-full py-3 bg-[#e6f6f7] text-teal-700 font-black rounded-xl hover:bg-teal-600 hover:text-white transition-all flex items-center justify-center gap-2">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            Add to Cart
                        </button>
                    </div>
                </template>
            </div>
        </div>

        <!-- Checkout Sidebar Column -->
        <div class="w-full lg:w-[420px]">
            <form action="{{ route('admin.walkin.store') }}" method="POST">
                @csrf
                <div class="bg-white rounded-3xl border border-slate-200 shadow-2xl overflow-hidden sticky top-24">
                    <div class="p-8 space-y-8">
                        <!-- Header -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3 text-[#006064]">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.56-7.43H5.12"/></svg>
                                <h2 class="text-xl font-black uppercase tracking-tight">Checkout</h2>
                            </div>
                            <span class="w-8 h-8 bg-[#006064] text-white rounded-full flex items-center justify-center text-xs font-black" x-text="cartCount"></span>
                        </div>

                        <!-- Customer Name Input -->
                        <div class="space-y-3">
                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Customer Name</label>
                            <div class="relative">
                                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-300">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                </div>
                                <input type="text" name="customer_name" x-model="customerName" class="w-full pl-12 pr-4 py-4 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none transition font-semibold text-slate-700">
                            </div>
                        </div>

                        <!-- Cart Items / Empty State -->
                        <div class="min-h-[160px]">
                            <template x-if="cart.length === 0">
                                <div class="py-12 flex flex-col items-center justify-center border-2 border-dashed border-slate-100 rounded-3xl bg-slate-50/50">
                                    <svg class="text-slate-200 mb-3" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                                    <p class="text-slate-400 font-bold text-sm">No items added yet</p>
                                    <p class="text-[10px] text-slate-300 font-bold uppercase mt-1">Click "+ Add to Cart" on a product</p>
                                </div>
                            </template>

                            <div class="space-y-4">
                                <template x-for="(item, index) in cart" :key="item.id">
                                    <div class="bg-[#f8fcfd] p-5 rounded-3xl flex items-center justify-between border border-teal-50">
                                        <div>
                                            <p class="font-black text-slate-800" x-text="item.name"></p>
                                            <p class="text-[11px] text-slate-400 font-bold" x-text="item.qty + ' × ₱' + item.price"></p>
                                            <div class="flex items-center gap-4 mt-2">
                                                <button type="button" @click="item.qty--" class="text-rose-400 font-black hover:text-rose-600 transition">Remove</button>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-xl font-black text-slate-900" x-text="'₱' + (item.qty * item.price)"></p>
                                        </div>
                                        
                                        <input type="hidden" :name="'items['+index+'][id]'" :value="item.id">
                                        <input type="hidden" :name="'items['+index+'][quantity]'" :value="item.qty">
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Final Summary Area -->
                        <div x-show="cart.length > 0" x-transition.opacity class="space-y-6 pt-4 animate-in fade-in zoom-in-95">
                            <div class="flex justify-between items-center">
                                <span class="text-2xl font-black text-slate-800">Total</span>
                                <span class="text-4xl font-black text-[#006064]" x-text="'₱' + total"></span>
                            </div>

                            <div class="space-y-3">
                                <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Payment</label>
                                <input type="hidden" name="payment_method" :value="paymentMethod">
                                <div class="grid grid-cols-2 gap-4">
                                    <button type="button" @click="paymentMethod = 'Cash'" 
                                        :class="paymentMethod === 'Cash' ? 'border-[#008996] bg-[#f0f9fa] ring-1 ring-teal-500' : 'border-slate-100'"
                                        class="flex flex-col items-center gap-2 py-5 border-2 rounded-2xl transition-all">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" :class="paymentMethod === 'Cash' ? 'text-[#008996]' : 'text-slate-300'"><path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1"/><path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"/></svg>
                                        <span class="text-xs font-black uppercase tracking-wider" :class="paymentMethod === 'Cash' ? 'text-[#008996]' : 'text-slate-400'">Cash</span>
                                    </button>
                                    <button type="button" @click="paymentMethod = 'GCash'" 
                                        :class="paymentMethod === 'GCash' ? 'border-[#008996] bg-[#f0f9fa] ring-1 ring-teal-500' : 'border-slate-100'"
                                        class="flex flex-col items-center gap-2 py-5 border-2 rounded-2xl transition-all">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" :class="paymentMethod === 'GCash' ? 'text-[#008996]' : 'text-slate-300'"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
                                        <span class="text-xs font-black uppercase tracking-wider" :class="paymentMethod === 'GCash' ? 'text-[#008996]' : 'text-slate-400'">GCash</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Walk-in GCash QR Display -->
                            <div x-show="paymentMethod === 'GCash'" x-transition.scale.origin.top class="p-6 bg-teal-50 rounded-[32px] border border-teal-100 flex flex-col items-center text-center animate-in zoom-in-95">
                                <p class="text-[10px] font-black text-[#006064] uppercase tracking-widest mb-4">Walk-in GCash Payment</p>
                                @php $qr = \App\Models\Setting::get('gcash_qr_data'); @endphp
                                @if($qr)
                                    <img src="{{ $qr }}" class="w-36 h-36 object-contain rounded-2xl shadow-lg border-4 border-white mb-4">
                                @else
                                    <div class="w-36 h-36 bg-white rounded-2xl flex flex-col items-center justify-center text-slate-300 shadow-inner mb-4">
                                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><rect x="7" y="7" width="3" height="3"/><rect x="14" y="7" width="3" height="3"/><rect x="7" y="14" width="3" height="3"/></svg>
                                        <p class="text-[8px] font-bold mt-2 uppercase">QR Code Required</p>
                                    </div>
                                @endif
                                <p class="text-[10px] text-[#008996] font-bold leading-relaxed px-4">Ask the customer to scan the QR code to complete the sale.</p>
                            </div>

                            <button type="submit"
                                class="w-full py-6 bg-[#008996] text-white font-black rounded-3xl shadow-2xl shadow-teal-200 hover:bg-[#006064] active:scale-[0.98] transition-all flex items-center justify-center gap-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 11"/></svg>
                                <span class="text-lg" x-text="'Complete Sale — ₱' + total"></span>
                            </button>
                            
                            <p class="text-center text-[10px] font-black text-slate-300 uppercase tracking-widest" x-text="'Paid via ' + paymentMethod + ' • Walk-in'"></p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
