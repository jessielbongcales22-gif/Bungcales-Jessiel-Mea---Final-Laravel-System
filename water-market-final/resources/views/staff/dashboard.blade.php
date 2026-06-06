@extends('layouts.app')

@section('title', 'Staff Dashboard')

@section('content')
<div class="space-y-10 animate-in fade-in duration-700 pb-20">
    <!-- Blue Gradient Hero Banner -->
    <div class="bg-gradient-to-r from-[#006064] to-[#00838f] p-12 rounded-[40px] text-white shadow-2xl shadow-teal-200 relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-5xl font-black tracking-tight mb-2">Staff Hub</h1>
            <p class="text-teal-50/80 text-xl font-medium mb-6">Operations & Logistics Overview.</p>
            <p class="text-sm font-bold bg-white/10 inline-block px-4 py-2 rounded-full backdrop-blur-md">
                {{ now()->format('l, F d, Y') }}
            </p>
        </div>
        <!-- Decorative Water Mark BG -->
        <div class="absolute -right-10 -bottom-20 opacity-10">
            <svg width="400" height="400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>
        </div>
    </div>

    <!-- Stats Cards Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Today's Revenue -->
        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-slate-100 flex flex-col gap-4">
            <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 shadow-inner">
                <span class="text-xl font-black">₱</span>
            </div>
            <div>
                <p class="text-3xl font-black text-slate-900 leading-none mb-2">₱{{ number_format($todayRevenue, 0) }}</p>
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Today's Revenue</p>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-slate-100 flex flex-col gap-4">
            <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600 shadow-inner">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.56-7.43H5.12"/></svg>
            </div>
            <div>
                <p class="text-3xl font-black text-slate-900 leading-none mb-2">{{ $pendingOrders }}</p>
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Pending Refills</p>
            </div>
        </div>

        <!-- Out for Delivery -->
        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-slate-100 flex flex-col gap-4">
            <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 shadow-inner">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="1" y="3" width="15" height="13"/><polyline points="16 8 20 8 23 11 23 16 16 16"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
            </div>
            <div>
                <p class="text-3xl font-black text-slate-900 leading-none mb-2">{{ $outForDelivery }}</p>
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">In Transit</p>
            </div>
        </div>

        <!-- Walk-in Sales Today -->
        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-slate-100 flex flex-col gap-4">
            <div class="w-12 h-12 bg-cyan-50 rounded-2xl flex items-center justify-center text-cyan-600 shadow-inner">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 8v8"/><path d="M8 12h8"/></svg>
            </div>
            <div>
                <p class="text-3xl font-black text-slate-900 leading-none mb-2">{{ $walkInSalesCount }}</p>
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">In-Store Sales</p>
            </div>
        </div>
    </div>

    <!-- Grid: Recent Orders & Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Latest Transactions -->
        <div class="lg:col-span-2 bg-white p-8 rounded-[40px] shadow-sm border border-slate-100">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h3 class="text-xl font-black text-slate-800 tracking-tight">Recent Activity</h3>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-1">Latest dispatch requests</p>
                </div>
                <a href="{{ route('orders.index') }}" class="text-blue-600 font-bold text-xs uppercase tracking-widest hover:underline">View All</a>
            </div>
            <div class="space-y-6">
                @foreach($recentOrders as $order)
                <div class="flex items-center justify-between p-4 bg-slate-50/50 rounded-3xl border border-slate-100">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-blue-600 shadow-sm">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.56-7.43H5.12"/></svg>
                        </div>
                        <div>
                            <p class="font-black text-slate-800">{{ $order->user->name }}</p>
                            <p class="text-xs text-slate-400 font-bold uppercase truncate max-w-[200px]">{{ $order->address }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-black text-slate-900 leading-none">₱{{ number_format($order->total, 0) }}</p>
                        <span class="text-[9px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full mt-2 inline-block {{ $order->status === 'delivered' ? 'bg-emerald-50 text-emerald-500' : 'bg-blue-50 text-blue-500' }}">
                            {{ $order->status }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Operations Sidebar -->
        <div class="space-y-8">
            <!-- Quick Shortcuts -->
            <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100">
                <h3 class="text-xl font-black text-slate-800 tracking-tight mb-6">Station Tools</h3>
                <div class="grid grid-cols-2 gap-4">
                    <a href="{{ route('admin.walkin.create') }}" class="p-4 bg-teal-50/50 rounded-[32px] border border-teal-50 hover:bg-teal-50 transition-all flex flex-col items-center gap-2 group">
                        <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-teal-600 shadow-sm group-hover:scale-110 transition-transform">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 8v8"/><path d="M8 12h8"/></svg>
                        </div>
                        <span class="text-[10px] font-black text-teal-800 uppercase tracking-widest">Walk-in</span>
                    </a>
                    <a href="{{ route('inventory.index') }}" class="p-4 bg-purple-50/50 rounded-[32px] border border-purple-50 hover:bg-purple-50 transition-all flex flex-col items-center gap-2 group">
                        <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-purple-600 shadow-sm group-hover:scale-110 transition-transform">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                        </div>
                        <span class="text-[10px] font-black text-purple-800 uppercase tracking-widest">Inventory</span>
                    </a>
                </div>
            </div>

            <!-- Low Stock Alerts -->
            <div class="bg-rose-500 p-8 rounded-[40px] shadow-xl text-white">
                <h3 class="text-xl font-black tracking-tight mb-6">Stock Alerts</h3>
                @if($lowStockItems->count() > 0)
                    <div class="space-y-4">
                        @foreach($lowStockItems as $item)
                        <div class="bg-white/10 p-4 rounded-3xl border border-white/10">
                            <p class="font-black text-sm">{{ $item->name }}</p>
                            <p class="text-[10px] font-bold text-rose-100 uppercase">{{ $item->quantity }} {{ $item->unit }} remaining</p>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm font-bold text-rose-100">All inventory levels are healthy.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Bottom Operations Bar -->
<div class="fixed bottom-0 right-0 left-64 bg-[#111827] text-white py-6 px-12 z-40 border-t border-white/5 flex items-center justify-between shadow-2xl">
    <div class="flex items-center gap-3">
        <div class="text-blue-400">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><rect x="1" y="3" width="15" height="13"/><polyline points="16 8 20 8 23 11 23 16 16 16"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
        </div>
        <span class="text-sm font-black uppercase tracking-widest text-slate-400">Station Operational Status</span>
    </div>
    <div class="flex items-center gap-16">
        <div class="text-center">
            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Processing</p>
            <p class="text-2xl font-black">{{ $processingOrders }}</p>
        </div>
        <div class="text-center border-l border-white/10 pl-16">
            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Pending</p>
            <p class="text-2xl font-black">{{ $pendingOrders }}</p>
        </div>
        <div class="text-center border-l border-white/10 pl-16">
            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">In Transit</p>
            <p class="text-2xl font-black">{{ $outForDelivery }}</p>
        </div>
    </div>
</div>
@endsection

