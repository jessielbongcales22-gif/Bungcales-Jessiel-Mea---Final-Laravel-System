@extends('layouts.app')

@section('title', Auth::user()->role === 'customer' ? 'My Orders' : 'Order Management')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 animate-in fade-in duration-500">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">
                {{ Auth::user()->role === 'customer' ? 'Order History' : 'Dispatch Queue' }}
            </h1>
            <p class="text-slate-500 font-medium">
                {{ Auth::user()->role === 'customer' ? 'Track your water refill deliveries.' : 'Manage and update incoming customer orders.' }}
            </p>
        </div>
        @if(Auth::user()->role === 'customer')
            <a href="{{ route('orders.create') }}" class="px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-100 transition flex items-center gap-2">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                New Refill Order
            </a>
        @endif
    </div>

    <!-- Filters Row for Staff -->
    @if(Auth::user()->role !== 'customer')
        <div class="flex gap-4 overflow-x-auto pb-2 no-scrollbar">
            <a href="{{ route('orders.index') }}" class="px-5 py-2 rounded-full font-bold text-sm bg-white border border-slate-200 text-slate-600 hover:border-blue-500 transition shadow-sm">All</a>
            <a href="#" class="px-5 py-2 rounded-full font-bold text-sm bg-blue-50 border border-blue-100 text-blue-600 shadow-sm">Pending</a>
            <a href="#" class="px-5 py-2 rounded-full font-bold text-sm bg-white border border-slate-200 text-slate-600 hover:border-blue-500 transition shadow-sm">In Transit</a>
            <a href="#" class="px-5 py-2 rounded-full font-bold text-sm bg-white border border-slate-200 text-slate-600 hover:border-blue-500 transition shadow-sm">Completed</a>
        </div>
    @endif

    <!-- Orders List -->
    <div class="space-y-4">
        @forelse($orders as $order)
            <div class="bg-white rounded-[32px] border border-slate-200 shadow-sm overflow-hidden hover:shadow-md transition-all duration-300">
                <div class="p-6 md:p-8 flex flex-col lg:flex-row justify-between gap-8">
                    <div class="flex-1 space-y-6">
                        <!-- Order Header -->
                        <div class="flex items-center justify-between lg:justify-start lg:gap-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 shadow-inner">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.56-7.43H5.12"/></svg>
                                </div>
                                <div>
                                    <h3 class="font-black text-slate-900 text-lg">Order #{{ substr(md5($order->id), 0, 8) }}</h3>
                                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">{{ $order->created_at->format('F d, Y • h:i A') }}</p>
                                </div>
                            </div>
                            
                            <div class="flex flex-col items-end lg:items-start">
                                <span class="px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-widest shadow-sm
                                    {{ $order->status === 'delivered' ? 'bg-emerald-100 text-emerald-700' : 
                                       ($order->status === 'pending' ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700') }}">
                                    {{ str_replace('-', ' ', $order->status) }}
                                </span>
                            </div>
                        </div>

                        <!-- Order Details Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4 border-t border-slate-50">
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Customer & Location</p>
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 bg-slate-50 rounded-full flex items-center justify-center text-slate-400">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-700">{{ $order->user->name }}</p>
                                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">{{ $order->address }}</p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Items Purchased</p>
                                <div class="space-y-2">
                                    @foreach($order->items as $item)
                                        <div class="flex justify-between items-center text-sm font-bold">
                                            <span class="text-slate-600">{{ $item->quantity }}x {{ $item->inventory->name }}</span>
                                            <span class="text-slate-900">₱{{ number_format($item->price_at_purchase * $item->quantity, 2) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Actions Sidebar (The functional part for staff) -->
                    <div class="lg:w-72 bg-[#f8fafc] p-8 flex flex-col justify-between border-t lg:border-t-0 lg:border-l border-slate-100">
                        <div class="text-center lg:text-right mb-6">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Grand Total</p>
                            <p class="text-4xl font-black text-slate-900 leading-none">₱{{ number_format($order->total, 2) }}</p>
                            <div class="flex flex-col items-center lg:items-end mt-2">
                                <span class="text-[10px] font-black uppercase {{ $order->payment_status === 'paid' ? 'text-emerald-500' : 'text-amber-500' }}">
                                    {{ $order->payment_status }}
                                </span>
                                <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded mt-1">
                                    via {{ $order->payment_method }}
                                </span>
                            </div>
                        </div>

                        @if(Auth::user()->role !== 'customer')
                            <!-- Staff/Admin Controls -->
                            <div class="space-y-3">
                                @if($order->status === 'pending')
                                    <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="processing">
                                        <button type="submit" class="w-full py-4 bg-[#0a56f1] text-white font-black rounded-2xl shadow-lg shadow-blue-100 hover:bg-blue-700 transition-all text-xs uppercase tracking-widest">Accept Order</button>
                                    </form>
                                @elseif($order->status === 'processing')
                                    <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="out-for-delivery">
                                        <button type="submit" class="w-full py-4 bg-purple-600 text-white font-black rounded-2xl shadow-lg shadow-purple-100 hover:bg-purple-700 transition-all text-xs uppercase tracking-widest flex items-center justify-center gap-2">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><rect x="1" y="3" width="15" height="13"/><polyline points="16 8 20 8 23 11 23 16 16 16"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                                            Dispatch
                                        </button>
                                    </form>
                                @elseif($order->status === 'out-for-delivery')
                                    <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="delivered">
                                        <button type="submit" class="w-full py-4 bg-emerald-600 text-white font-black rounded-2xl shadow-lg shadow-emerald-100 hover:bg-emerald-700 transition-all text-xs uppercase tracking-widest flex items-center justify-center gap-2">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 11"/></svg>
                                            Confirm Delivery
                                        </button>
                                    </form>
                                @endif
                                
                                @if($order->payment_status === 'pending')
                                    <form action="{{ route('orders.recordPayment', $order->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full py-3 bg-white border border-slate-200 text-slate-700 font-bold rounded-2xl text-xs uppercase tracking-widest hover:bg-slate-50">Record Payment</button>
                                    </form>
                                @endif
                            </div>
                        @else
                            <!-- Customer Controls -->
                            <div class="space-y-3">
                                @if($order->status === 'pending')
                                    <div class="grid grid-cols-2 gap-3">
                                        <a href="{{ route('orders.edit', $order->id) }}" class="flex-1 py-4 bg-amber-50 text-amber-600 font-black rounded-2xl hover:bg-amber-100 transition-all text-[10px] uppercase tracking-widest text-center">Edit Order</a>
                                        <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Cancel this order?')">
                                            @csrf
                                            <button type="submit" class="w-full py-4 bg-rose-50 text-rose-500 font-black rounded-2xl hover:bg-rose-100 transition-all text-[10px] uppercase tracking-widest">Cancel</button>
                                        </form>
                                    </div>
                                @elseif($order->status === 'delivered' || $order->status === 'cancelled')
                                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Delete this record from history?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-full py-4 bg-slate-50 text-slate-400 font-black rounded-2xl hover:bg-rose-50 hover:text-rose-500 transition-all text-[10px] uppercase tracking-widest">Remove Record</button>
                                    </form>
                                @else
                                    <button class="w-full py-4 bg-white border border-slate-200 text-slate-400 font-bold rounded-2xl text-[10px] uppercase tracking-widest cursor-default">
                                        Order in Progress
                                    </button>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="py-24 text-center bg-white rounded-[40px] border-2 border-dashed border-slate-100">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-200">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                </div>
                <h3 class="text-xl font-black text-slate-800 tracking-tight">No orders yet</h3>
                <p class="text-slate-400 font-medium">New customer requests will appear here in the dispatch queue.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
