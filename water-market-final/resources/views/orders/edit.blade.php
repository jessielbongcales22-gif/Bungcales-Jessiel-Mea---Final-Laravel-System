@extends('layouts.app')

@section('title', 'Edit Order')

@section('content')
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 animate-in fade-in duration-700" x-data="{ 
    items: [
        @foreach($inventory as $item)
        { 
            id: {{ $item->id }}, 
            name: '{{ $item->name }}', 
            price: {{ $item->price }}, 
            stock: {{ $item->quantity + ($currentItems[$item->id] ?? 0) }}, 
            qty: {{ $currentItems[$item->id] ?? 0 }} 
        },
        @endforeach
    ],
    address: '{{ $order->address }}',
    paymentMethod: '{{ $order->payment_method }}',
    get cart() { return this.items.filter(i => i.qty > 0) },
    get total() { return this.cart.reduce((sum, i) => sum + (i.price * i.qty), 0) },
    get cartCount() { return this.cart.reduce((sum, i) => sum + i.qty, 0) }
}">
    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-amber-600 to-orange-500 text-white p-10 rounded-[40px] mb-10 flex items-center gap-6 shadow-2xl shadow-amber-100 relative overflow-hidden">
        <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-md relative z-10">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        </div>
        <div class="relative z-10">
            <h1 class="text-4xl font-black tracking-tight">Edit Order #{{ substr(md5($order->id), 0, 8) }}</h1>
            <p class="text-amber-50 font-medium mt-1">Modify your order details and items below.</p>
        </div>
    </div>

    <form action="{{ route('orders.update', $order->id) }}" method="POST" class="flex flex-col lg:flex-row gap-10">
        @csrf
        @method('PUT')
        
        <!-- Products Selection Column -->
        <div class="lg:col-span-1 flex-1">
            <h2 class="text-xl font-black text-slate-800 mb-6 uppercase tracking-widest text-[11px]">Modify Selection</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <template x-for="item in items" :key="item.id">
                    <div class="bg-white p-6 rounded-[32px] border border-slate-100 shadow-sm transition-all hover:shadow-xl hover:border-amber-100 group">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600 group-hover:bg-amber-600 group-hover:text-white transition-colors duration-300">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                </div>
                                <div>
                                    <p class="font-black text-slate-800 text-lg leading-tight" x-text="item.name"></p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase mt-1" x-text="item.stock + ' available'"></p>
                                </div>
                            </div>
                            <p class="text-2xl font-black text-amber-600" x-text="'₱' + item.price"></p>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <div class="flex-1 flex items-center justify-between bg-slate-50 rounded-2xl px-4 py-3 border border-slate-100">
                                <button type="button" @click="if(item.qty > 0) item.qty--" class="w-10 h-10 flex items-center justify-center text-slate-400 hover:text-rose-500 font-black text-xl transition-colors">-</button>
                                <span class="text-lg font-black text-amber-600" x-text="item.qty"></span>
                                <button type="button" @click="if(item.qty < item.stock) item.qty++" class="w-10 h-10 flex items-center justify-center text-slate-400 hover:text-amber-600 font-black text-xl transition-colors">+</button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Checkout Sidebar Column -->
        <div class="w-full lg:w-[420px]">
            <div class="bg-white rounded-[40px] border border-slate-200 shadow-2xl overflow-hidden sticky top-24">
                <div class="p-8 space-y-8">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3 text-amber-800">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.56-7.43H5.12"/></svg>
                            <h2 class="text-xl font-black uppercase tracking-tight">Updated Cart</h2>
                        </div>
                        <span class="w-8 h-8 bg-amber-600 text-white rounded-full flex items-center justify-center text-xs font-black" x-text="cartCount"></span>
                    </div>

                    <div class="min-h-[160px]">
                        <div class="space-y-4">
                            <template x-for="(item, index) in cart" :key="item.id">
                                <div class="bg-[#fffbeb] p-6 rounded-[32px] flex items-center justify-between border border-amber-50 relative group">
                                    <div>
                                        <p class="font-black text-slate-800" x-text="item.name"></p>
                                        <p class="text-[11px] text-slate-400 font-black uppercase mt-1" x-text="item.qty + ' × ₱' + item.price"></p>
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

                    <div class="space-y-3">
                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Delivery Address</label>
                        <textarea name="address" x-model="address" required 
                            class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-3xl focus:ring-2 focus:ring-amber-500 outline-none transition font-bold text-sm text-slate-700 h-28 resize-none"></textarea>
                    </div>

                    <!-- Payment Method -->
                    <div class="space-y-3">
                        <label class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Payment Method</label>
                        <input type="hidden" name="payment_method" :value="paymentMethod">
                        <div class="grid grid-cols-2 gap-4">
                            <button type="button" @click="paymentMethod = 'Cash'" 
                                :class="paymentMethod === 'Cash' ? 'border-amber-600 bg-amber-50 ring-1 ring-amber-500' : 'border-slate-100'"
                                class="flex flex-col items-center gap-2 py-4 border-2 rounded-2xl transition-all">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" :class="paymentMethod === 'Cash' ? 'text-amber-600' : 'text-slate-300'"><path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1"/><path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"/></svg>
                                <span class="text-[10px] font-black uppercase tracking-wider" :class="paymentMethod === 'Cash' ? 'text-amber-700' : 'text-slate-400'">Cash</span>
                            </button>
                            <button type="button" @click="paymentMethod = 'GCash'" 
                                :class="paymentMethod === 'GCash' ? 'border-amber-600 bg-amber-50 ring-1 ring-amber-500' : 'border-slate-100'"
                                class="flex flex-col items-center gap-2 py-4 border-2 rounded-2xl transition-all">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" :class="paymentMethod === 'GCash' ? 'text-amber-600' : 'text-slate-300'"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
                                <span class="text-[10px] font-black uppercase tracking-wider" :class="paymentMethod === 'GCash' ? 'text-amber-700' : 'text-slate-400'">GCash</span>
                            </button>
                        </div>
                    </div>

                    <div class="space-y-6 pt-4">
                        <div class="flex justify-between items-center px-2">
                            <span class="text-xl font-black text-slate-800">New Total</span>
                            <span class="text-4xl font-black text-amber-600" x-text="'₱' + total"></span>
                        </div>

                        <button type="submit" :disabled="cart.length === 0"
                            class="w-full py-6 bg-amber-600 text-white font-black rounded-3xl shadow-2xl shadow-amber-200 hover:bg-amber-700 active:scale-[0.98] transition-all flex items-center justify-center gap-3 disabled:opacity-50">
                            Save Changes
                        </button>
                        
                        <a href="{{ route('orders.index') }}" class="block text-center text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-slate-600">Cancel Editing</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
