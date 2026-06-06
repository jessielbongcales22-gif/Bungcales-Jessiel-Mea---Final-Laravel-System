@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="space-y-10 animate-in fade-in duration-700 pb-20">
    <!-- Blue Gradient Hero Banner -->
    <div class="bg-gradient-to-r from-[#0038a8] to-[#1e40af] p-12 rounded-[40px] text-white shadow-2xl shadow-blue-200 relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-5xl font-black tracking-tight mb-2">Admin Dashboard</h1>
            <p class="text-blue-100/80 text-xl font-medium mb-6">Welcome back, admin. Here's your business overview.</p>
            <p class="text-sm font-bold bg-white/10 inline-block px-4 py-2 rounded-full backdrop-blur-md">
                {{ now()->format('l, F d, Y') }}
            </p>
        </div>
        <!-- Decorative Water Mark BG -->
        <div class="absolute -right-10 -bottom-20 opacity-10">
            <svg width="400" height="400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>
        </div>
    </div>

    <!-- 5 Stats Cards Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
        <!-- Today's Revenue -->
        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-slate-100 flex flex-col gap-4">
            <div class="flex justify-between items-start">
                <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 shadow-inner">
                    <span class="text-xl font-black">₱</span>
                </div>
                <div class="flex items-center gap-1 text-emerald-500 font-bold text-xs bg-emerald-50 px-2 py-1 rounded-lg">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="23 6 13.5 15.5 8.5 10.5 1 15.5"/><polyline points="17 6 23 6 23 12"/></svg>
                    0%
                </div>
            </div>
            <div>
                <p class="text-3xl font-black text-slate-900 leading-none mb-2">₱{{ number_format($todayRevenue, 0) }}</p>
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Today's Revenue</p>
            </div>
        </div>

        <!-- Monthly Revenue -->
        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-slate-100 flex flex-col gap-4">
            <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 shadow-inner">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
                <p class="text-3xl font-black text-slate-900 leading-none mb-2">₱{{ number_format($monthlyRevenue, 0) }}</p>
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Monthly Revenue</p>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-slate-100 flex flex-col gap-4">
            <div class="flex justify-between items-start">
                <div class="w-12 h-12 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-600 shadow-inner">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.56-7.43H5.12"/></svg>
                </div>
                <span class="text-purple-400 font-bold text-[10px] bg-purple-50 px-2 py-1 rounded-lg">0 today</span>
            </div>
            <div>
                <p class="text-3xl font-black text-slate-900 leading-none mb-2">{{ $pendingOrders }}</p>
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Pending Orders</p>
            </div>
        </div>

        <!-- Total Users -->
        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-slate-100 flex flex-col gap-4">
            <div class="w-12 h-12 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-600 shadow-inner">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div>
                <p class="text-3xl font-black text-slate-900 leading-none mb-2">{{ $totalUsers }}</p>
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Total Users</p>
            </div>
        </div>

        <!-- Walk-in Sales -->
        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-slate-100 flex flex-col gap-4">
            <div class="flex justify-between items-start">
                <div class="w-12 h-12 bg-cyan-50 rounded-2xl flex items-center justify-center text-cyan-600 shadow-inner">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 8v8"/><path d="M8 12h8"/></svg>
                </div>
                <span class="text-cyan-400 font-bold text-[10px] bg-cyan-50 px-2 py-1 rounded-lg">{{ $walkInSalesCount }} today</span>
            </div>
            <div>
                <p class="text-3xl font-black text-slate-900 leading-none mb-2">{{ $walkInSalesCount }}</p>
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Walk-in Sales</p>
            </div>
        </div>
    </div>

    <!-- Comparison Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Walk-in Sales Comparison -->
        <div class="bg-white p-10 rounded-[40px] shadow-sm border border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-6">
                <div class="w-16 h-16 bg-[#e6f6f7] rounded-2xl flex items-center justify-center text-[#008996]">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/><path d="M12 11v4"/><path d="M10 13h4"/></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-400 mb-1">Walk-in Sales</p>
                    <p class="text-3xl font-black text-slate-900 leading-tight">₱{{ number_format($walkInRevenue, 0) }}</p>
                    <p class="text-[11px] text-slate-400 font-medium uppercase mt-1">{{ $walkInSalesCount }} transactions</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-4xl font-black text-[#10b981]">{{ $walkInPercent }}%</p>
                <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest mt-1 text-nowrap">of total sales</p>
            </div>
        </div>

        <!-- Delivery Orders Comparison -->
        <div class="bg-white p-10 rounded-[40px] shadow-sm border border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-6">
                <div class="w-16 h-16 bg-[#ebf2ff] rounded-2xl flex items-center justify-center text-blue-600">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.56-7.43H5.12"/></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-400 mb-1">Delivery Orders</p>
                    <p class="text-3xl font-black text-slate-900 leading-tight">₱{{ number_format($deliveryRevenue, 0) }}</p>
                    <p class="text-[11px] text-slate-400 font-medium uppercase mt-1">{{ $allTimeOrders - $walkInSalesCount }} transactions</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-4xl font-black text-slate-300">{{ $deliveryPercent }}%</p>
                <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest mt-1 text-nowrap">of total sales</p>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Revenue Trend -->
        <div class="lg:col-span-2 bg-white p-8 rounded-[40px] shadow-sm border border-slate-100">
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h3 class="text-xl font-black text-slate-800 tracking-tight">Revenue Trend</h3>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-1">Last 7 days performance</p>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-black text-blue-600">₱{{ number_format($monthlyRevenue, 0) }}</p>
                    <p class="text-[10px] text-slate-400 font-bold uppercase">Total this week</p>
                </div>
            </div>
            <div class="h-64">
                <canvas id="revenueTrendChart"></canvas>
            </div>
        </div>

        <!-- Payment Methods -->
        <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100 flex flex-col">
            <h3 class="text-xl font-black text-slate-800 tracking-tight mb-2">Payment Methods</h3>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-8">Revenue distribution</p>
            
            <div class="flex-1 flex flex-col items-center justify-center">
                <div class="w-48 h-48 mb-8">
                    <canvas id="paymentMethodsChart"></canvas>
                </div>
                <div class="w-full space-y-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="w-3 h-3 bg-blue-500 rounded-full shadow-lg shadow-blue-100"></span>
                            <span class="text-xs font-black text-slate-400 uppercase tracking-widest">Cash</span>
                        </div>
                        <span class="font-black text-slate-900">₱{{ number_format($cashRevenue, 0) }}</span>
                    </div>
                    <div class="flex items-center justify-between pt-4 border-t border-slate-50">
                        <div class="flex items-center gap-3">
                            <span class="w-3 h-3 bg-emerald-500 rounded-full shadow-lg shadow-emerald-100"></span>
                            <span class="text-xs font-black text-slate-400 uppercase tracking-widest">GCash</span>
                        </div>
                        <span class="font-black text-slate-900">₱{{ number_format($gcashRevenue, 0) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Row: Recent Orders & Sidebar Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Orders -->
        <div class="lg:col-span-2 bg-white p-8 rounded-[40px] shadow-sm border border-slate-100">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h3 class="text-xl font-black text-slate-800 tracking-tight">Recent Orders</h3>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-1">Latest transactions</p>
                </div>
                <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">{{ $recentOrders->count() }} total</span>
            </div>
            <div class="space-y-6">
                @foreach($recentOrders as $order)
                <div class="flex items-center justify-between p-4 bg-slate-50/50 rounded-3xl border border-slate-100 hover:bg-white hover:shadow-md transition-all">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 shadow-inner">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.56-7.43H5.12"/></svg>
                        </div>
                        <div>
                            <p class="font-black text-slate-800">{{ $order->user->name }}</p>
                            <p class="text-xs text-slate-400 font-bold uppercase">{{ $order->address }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-black text-slate-900 leading-none">₱{{ number_format($order->total, 0) }}</p>
                        <span class="text-[10px] font-black text-emerald-500 uppercase tracking-widest bg-emerald-50 px-2 py-0.5 rounded-full mt-2 inline-block">completed</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="space-y-8">
            <!-- Quick Actions -->
            <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100">
                <h3 class="text-xl font-black text-slate-800 tracking-tight mb-6">Quick Actions</h3>
                <div class="grid grid-cols-2 gap-4">
                    <a href="{{ route('admin.reports.index') }}" class="p-4 bg-blue-50/50 rounded-[32px] border border-blue-50 hover:bg-blue-50 transition-all flex flex-col items-center gap-2 group">
                        <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-blue-600 shadow-sm group-hover:scale-110 transition-transform">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 20v-6"/><path d="M6 20V10"/><path d="M18 20V4"/></svg>
                        </div>
                        <span class="text-xs font-black text-blue-800 uppercase tracking-widest">Reports</span>
                    </a>
                    <a href="{{ route('admin.users.create') }}" class="p-4 bg-emerald-50/50 rounded-[32px] border border-emerald-50 hover:bg-emerald-50 transition-all flex flex-col items-center gap-2 group">
                        <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-emerald-600 shadow-sm group-hover:scale-110 transition-transform">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M19 8v6"/><path d="M16 11h6"/></svg>
                        </div>
                        <span class="text-xs font-black text-emerald-800 uppercase tracking-widest">Add User</span>
                    </a>
                    <a href="{{ route('inventory.index') }}" class="p-4 bg-purple-50/50 rounded-[32px] border border-purple-50 hover:bg-purple-50 transition-all flex flex-col items-center gap-2 group">
                        <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-purple-600 shadow-sm group-hover:scale-110 transition-transform">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                        </div>
                        <span class="text-xs font-black text-purple-800 uppercase tracking-widest">Inventory</span>
                    </a>
                    <a href="{{ route('admin.reports.index') }}" class="p-4 bg-orange-50/50 rounded-[32px] border border-orange-50 hover:bg-orange-50 transition-all flex flex-col items-center gap-2 group">
                        <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-orange-600 shadow-sm group-hover:scale-110 transition-transform">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                        </div>
                        <span class="text-xs font-black text-orange-800 uppercase tracking-widest">Analytics</span>
                    </a>
                </div>
            </div>

            <!-- Top Products -->
            <div class="bg-white p-8 rounded-[40px] shadow-sm border border-slate-100">
                <h3 class="text-xl font-black text-slate-800 tracking-tight mb-8">Top Products</h3>
                <div class="space-y-6">
                    @foreach($topProducts as $index => $product)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-[#ebf2ff] rounded-full flex items-center justify-center text-blue-600 font-black text-xs shadow-inner">
                                {{ $index + 1 }}
                            </div>
                            <div>
                                <p class="font-black text-slate-800 text-sm">{{ $product->inventory->name }}</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $product->total_sold }} sold</p>
                            </div>
                        </div>
                        <p class="font-black text-slate-900">₱{{ number_format($product->revenue, 0) }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- All-Time Bar Footer -->
<div class="fixed bottom-0 right-0 left-64 bg-[#1a202c] text-white py-6 px-12 z-40 border-t border-white/5 flex items-center justify-between shadow-2xl">
    <div class="flex items-center gap-3">
        <div class="text-emerald-400">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="23 6 13.5 15.5 8.5 10.5 1 15.5"/><polyline points="17 6 23 6 23 12"/></svg>
        </div>
        <span class="text-sm font-black uppercase tracking-widest text-slate-400">Total All-Time Revenue</span>
    </div>
    <div class="flex items-center gap-16">
        <div class="text-center">
            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Total Revenue</p>
            <p class="text-2xl font-black">₱{{ number_format($totalRevenueAllTime, 0) }}</p>
        </div>
        <div class="text-center border-l border-white/10 pl-16">
            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Total Orders</p>
            <p class="text-2xl font-black">{{ $allTimeOrders }}</p>
        </div>
        <div class="text-center border-l border-white/10 pl-16">
            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Products</p>
            <p class="text-2xl font-black">{{ $totalProductsCount }}</p>
        </div>
    </div>
</div>

<script>
    // Revenue Trend Chart
    const revenueCtx = document.getElementById('revenueTrendChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: ['Fri', 'Sat', 'Sun', 'Mon', 'Tue', 'Wed', 'Thu'],
            datasets: [{
                data: [0, 0, 0, 0, {{ $walkInRevenue }}, 0, 0],
                borderColor: '#3b82f6',
                borderWidth: 4,
                tension: 0.5,
                pointBackgroundColor: '#3b82f6',
                pointRadius: 6,
                pointHoverRadius: 8,
                fill: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f8fafc', drawBorder: false }, ticks: { font: { weight: 'bold', size: 10 }, color: '#cbd5e1' } },
                x: { grid: { display: false }, ticks: { font: { weight: 'bold', size: 10 }, color: '#cbd5e1' } }
            }
        }
    });

    // Payment Methods Donut
    const paymentCtx = document.getElementById('paymentMethodsChart').getContext('2d');
    new Chart(paymentCtx, {
        type: 'doughnut',
        data: {
            labels: ['Cash', 'GCash'],
            datasets: [{
                data: [{{ $cashRevenue }}, {{ $gcashRevenue }}],
                backgroundColor: ['#3b82f6', '#10b981'],
                borderWidth: 0,
                cutout: '75%',
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } }
        }
    });
</script>
@endsection
