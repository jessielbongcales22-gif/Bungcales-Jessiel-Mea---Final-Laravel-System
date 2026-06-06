@extends('layouts.app')

@section('title', 'Order Water Refill')

@section('content')
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 animate-in fade-in duration-700" x-data="{ 
    items: [
        @foreach($inventory as $item)
        { id: {{ $item->id }}, name: '{{ $item->name }}', price: {{ $item->price }}, stock: {{ $item->quantity }}, qty: 0 },
        @endforeach
    ],
    address: '{{ Auth::user()->address }}',
    paymentMethod: 'Cash',
    get cart() { return this.items.filter(i => i.qty > 0) },
    get total() { return this.cart.reduce((sum, i) => sum + (i.price * i.qty), 0) },
    get cartCount() { return this.cart.reduce((sum, i) => sum + i.qty, 0) }
}">
    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-[#1e40af] to-[#3b82f6] text-white p-10 rounded-[40px] mb-10 flex items-center gap-6 shadow-2xl shadow-blue-100 relative overflow-hidden">
        <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-md relative z-10">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>
        </div>
        <div class="relative z-10">
            <h1 class="text-4xl font-black tracking-tight">Order Water Refill</h1>
            <p class="text-blue-100/80 font-medium mt-1">Select your items and confirm your delivery details below.</p>
        </div>
        <!-- Decorative Circle -->
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-white/5 rounded-full"></div>
    </div>

    <div class="flex flex-col lg:flex-row gap-10">
        <!-- Products Selection Column -->
        <div class="lg:col-span-1 flex-1">
            <h2 class="text-xl font-black text-slate-800 mb-6 uppercase tracking-widest text-[11px]">Select Products</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <template x-for="item in items" :key="item.id">
                    <div class="bg-white p-6 rounded-[32px] border border-slate-100 shadow-sm transition-all hover:shadow-xl hover:border-blue-100 group">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                </div>
                                <div>
                                    <p class="font-black text-slate-800 text-lg leading-tight" x-text="item.name"></p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase mt-1" x-text="item.stock + ' in stock'"></p>
                                </div>
                            </div>
                            <p class="text-2xl font-black text-blue-600" x-text="'₱' + item.price"></p>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <button type="button" 
                                @click="if(item.qty < item.stock) item.qty++"
                                class="flex-1 py-4 bg-blue-50 text-blue-700 font-black rounded-2xl hover:bg-blue-600 hover:text-white transition-all flex items-center justify-center gap-2">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                Add to Order
                            </button>
                            <div x-show="item.qty > 0" class="flex items-center bg-slate-50 rounded-2xl px-2 py-1 animate-in zoom-in-90">
                                <button type="button" @click="item.qty--" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-rose-500 font-black">-</button>
                                <span class="w-8 text-center font-black text-blue-600" x-text="item.qty"></span>
                                <button type="button" @click="item.qty++" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-blue-600 font-black">+</button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Checkout Sidebar Column -->
        <div class="w-full lg:w-[420px]">
            <form action="{{ route('orders.store') }}" method="POST">
                @csrf
                <div class="bg-white rounded-[40px] border border-slate-200 shadow-2xl overflow-hidden sticky top-24">
                    <div class="p-8 space-y-8">
                        <!-- Header -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3 text-blue-800">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.56-7.43H5.12"/></svg>
                                <h2 class="text-xl font-black uppercase tracking-tight">Your Cart</h2>
                            </div>
                            <span class="w-8 h-8 bg-blue-800 text-white rounded-full flex items-center justify-center text-xs font-black shadow-lg shadow-blue-100" x-text="cartCount"></span>
                        </div>

                        <!-- Cart Items Area -->
                        <div class="min-h-[160px]">
                            <template x-if="cart.length === 0">
                                <div class="py-12 flex flex-col items-center justify-center border-2 border-dashed border-slate-100 rounded-[32px] bg-slate-50/50">
                                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center text-slate-200 mb-4 shadow-inner">
                                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                                    </div>
                                    <p class="text-slate-400 font-bold text-sm text-center">Cart is empty.<br/><span class="text-[10px] text-slate-300 uppercase tracking-widest">Select products to start.</span></p>
                                </div>
                            </template>

                            <div class="space-y-4">
                                <template x-for="(item, index) in cart" :key="item.id">
                                    <div class="bg-[#f8fafc] p-6 rounded-[32px] flex items-center justify-between border border-blue-50 relative group">
                                        <div>
                                            <p class="font-black text-slate-800" x-text="item.name"></p>
                                            <p class="text-[11px] text-slate-400 font-black uppercase mt-1" x-text="item.qty + ' × ₱' + item.price"></p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-xl font-black text-slate-900" x-text="'₱' + (item.qty * item.price)"></p>
                                        </div>
                                        
                                        <!-- Hidden Inputs for Laravel Submission -->
                                        <input type="hidden" :name="'items['+index+'][id]'" :value="item.id">
                                        <input type="hidden" :name="'items['+index+'][quantity]'" :value="item.qty">
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Delivery Address -->
                        <div class="space-y-3">
                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Delivery Address</label>
                            <div class="relative">
                                <div class="absolute left-4 top-4 text-blue-400">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                </div>
                                <textarea name="address" x-model="address" required 
                                    class="w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-3xl focus:ring-2 focus:ring-blue-500 outline-none transition font-bold text-sm text-slate-700 h-28 resize-none"></textarea>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="space-y-3">
                            <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Payment Method</label>
                            <input type="hidden" name="payment_method" :value="paymentMethod">
                            <div class="grid grid-cols-2 gap-4">
                                <button type="button" @click="paymentMethod = 'Cash'" 
                                    :class="paymentMethod === 'Cash' ? 'border-blue-600 bg-blue-50 ring-1 ring-blue-500' : 'border-slate-100'"
                                    class="flex flex-col items-center gap-2 py-4 border-2 rounded-2xl transition-all">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" :class="paymentMethod === 'Cash' ? 'text-blue-600' : 'text-slate-300'"><path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1"/><path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"/></svg>
                                    <span class="text-[10px] font-black uppercase tracking-wider" :class="paymentMethod === 'Cash' ? 'text-blue-700' : 'text-slate-400'">Cash</span>
                                </button>
                                <button type="button" @click="paymentMethod = 'GCash'" 
                                    :class="paymentMethod === 'GCash' ? 'border-blue-600 bg-blue-50 ring-1 ring-blue-500' : 'border-slate-100'"
                                    class="flex flex-col items-center gap-2 py-4 border-2 rounded-2xl transition-all">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" :class="paymentMethod === 'GCash' ? 'text-blue-600' : 'text-slate-300'"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
                                    <span class="text-[10px] font-black uppercase tracking-wider" :class="paymentMethod === 'GCash' ? 'text-blue-700' : 'text-slate-400'">GCash</span>
                                </button>
                            </div>
                        </div>

                        <!-- GCash QR Display -->
                        <div x-show="paymentMethod === 'GCash'" x-transition.scale.origin.top class="p-6 bg-blue-50 rounded-[32px] border border-blue-100 flex flex-col items-center text-center animate-in zoom-in-95">
                            <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest mb-4 text-center">Scan to Pay via GCash</p>
                            @php $qr = \App\Models\Setting::get('gcash_qr_data'); @endphp
                            @if($qr)
                                <img src="{{ $qr }}" class="w-40 h-40 object-contain rounded-2xl shadow-lg border-4 border-white mb-4">
                            @else
                                <div class="w-40 h-40 bg-white rounded-2xl flex flex-col items-center justify-center text-slate-300 shadow-inner mb-4">
                                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><rect x="7" y="7" width="3" height="3"/><rect x="14" y="7" width="3" height="3"/><rect x="7" y="14" width="3" height="3"/></svg>
                                    <p class="text-[8px] font-bold mt-2">QR NOT SET</p>
                                </div>
                            @endif
                            <p class="text-[10px] text-blue-600 font-bold leading-relaxed px-4">Please save your transaction receipt for verification.</p>
                        </div>

                        <!-- Final Summary Area -->
                        <div x-show="cart.length > 0" x-transition.opacity class="space-y-6 pt-4 animate-in slide-in-from-bottom-4">
                            <div class="flex justify-between items-center px-2">
                                <span class="text-xl font-black text-slate-800">Grand Total</span>
                                <span class="text-4xl font-black text-blue-600" x-text="'₱' + total"></span>
                            </div>

                            <button type="submit"
                                class="w-full py-6 bg-[#0a56f1] text-white font-black rounded-3xl shadow-2xl shadow-blue-200 hover:bg-blue-700 active:scale-[0.98] transition-all flex items-center justify-center gap-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 11"/></svg>
                                <span class="text-lg">Checkout Order</span>
                            </button>
                            
                            <div class="flex items-center justify-center gap-2 text-slate-300">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                <p class="text-[10px] font-black uppercase tracking-widest">Cash on Delivery Secure Payment</p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
