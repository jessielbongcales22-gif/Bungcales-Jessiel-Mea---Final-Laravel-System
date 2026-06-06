@extends('layouts.app')

@section('title', 'Sales Reports')

@section('content')
<!-- Chart.js for data visualization -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
        <div>
            <h1 class="text-3xl font-extrabold text-[#1e293b] tracking-tight">Sales Reports</h1>
            <p class="text-slate-500 font-medium">Analyze your business performance</p>
        </div>
        
        <div class="flex items-center gap-4">
            <div class="flex bg-white p-1 rounded-xl border border-slate-200 shadow-sm">
                <a href="?period=week" class="px-4 py-2 text-sm font-bold rounded-lg transition {{ $period == 'week' ? 'bg-slate-100 text-slate-900' : 'text-slate-500 hover:text-slate-700' }}">Week</a>
                <a href="?period=month" class="px-4 py-2 text-sm font-bold rounded-lg transition {{ $period == 'month' ? 'bg-slate-100 text-slate-900' : 'text-slate-500 hover:text-slate-700' }}">Month</a>
                <a href="?period=year" class="px-4 py-2 text-sm font-bold rounded-lg transition {{ $period == 'year' ? 'bg-slate-100 text-slate-900' : 'text-slate-500 hover:text-slate-700' }}">Year</a>
            </div>
            <button class="bg-[#10b981] hover:bg-[#059669] text-white px-5 py-2.5 rounded-xl font-bold flex items-center gap-2 shadow-lg shadow-emerald-100 transition">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Export CSV
            </button>
        </div>
    </div>

    <!-- Stats Cards Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
        <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm flex flex-col gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600">
                    <span class="font-black text-lg">₱</span>
                </div>
                <div class="text-emerald-500">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 15.5"/><polyline points="17 6 23 6 23 12"/></svg>
                </div>
            </div>
            <div>
                <p class="text-3xl font-black text-slate-900">₱{{ number_format($totalRevenue, 0) }}</p>
                <p class="text-sm font-bold text-slate-400">Total Revenue ({{ $period }})</p>
            </div>
        </div>

        <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm flex flex-col gap-4">
            <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.56-7.43H5.12"/></svg>
            </div>
            <div>
                <p class="text-3xl font-black text-slate-900">{{ $totalOrders }}</p>
                <p class="text-sm font-bold text-slate-400">Total Orders ({{ $period }})</p>
            </div>
        </div>

        <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm flex flex-col gap-4">
            <div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center text-purple-600">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
                <p class="text-3xl font-black text-slate-900">₱{{ number_format($avgOrderValue, 0) }}</p>
                <p class="text-sm font-bold text-slate-400">Avg Order Value</p>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
        <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
            <h3 class="text-lg font-black text-slate-800 mb-8">Sales Trend</h3>
            <div class="h-64">
                <canvas id="salesTrendChart"></canvas>
            </div>
        </div>
        <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
            <h3 class="text-lg font-black text-slate-800 mb-8">Orders Trend</h3>
            <div class="h-64">
                <canvas id="ordersTrendChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Top Products & Payment Methods Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
        <!-- Top Products -->
        <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
            <h3 class="text-lg font-black text-slate-800 mb-8">Top Products by Revenue</h3>
            <div class="space-y-6">
                @forelse($topProducts as $index => $product)
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white font-black text-xs">
                            {{ $index + 1 }}
                        </div>
                        <div>
                            <p class="font-bold text-slate-900 text-sm">{{ $product->inventory->name }}</p>
                            <p class="text-[11px] text-slate-400 font-bold uppercase">{{ $product->total_sold }} sold</p>
                        </div>
                    </div>
                    <p class="font-black text-slate-900">₱{{ number_format($product->revenue, 0) }}</p>
                </div>
                @empty
                <p class="text-center text-slate-400 py-10">No data available.</p>
                @endforelse
            </div>
        </div>

        <!-- Payment Methods -->
        <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
            <h3 class="text-lg font-black text-slate-800 mb-8">Payment Methods</h3>
            <div class="flex flex-col items-center">
                <div class="h-48 w-48 mb-6">
                    <canvas id="paymentMethodsChart"></canvas>
                </div>
                <div class="grid grid-cols-2 gap-x-8 gap-y-4">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 bg-blue-500 rounded-full shadow-lg shadow-blue-100"></span>
                        <div class="flex flex-col">
                            <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest leading-none">Cash</span>
                            <span class="text-sm font-black text-slate-700 mt-1">₱{{ number_format($cashRevenue, 0) }}</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 bg-emerald-500 rounded-full shadow-lg shadow-emerald-100"></span>
                        <div class="flex flex-col">
                            <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest leading-none">GCash</span>
                            <span class="text-sm font-black text-slate-700 mt-1">₱{{ number_format($gcashRevenue, 0) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction History Table -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden mb-20">
        <div class="p-8 border-b border-slate-50">
            <h3 class="text-lg font-black text-slate-800">Transaction History</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50/50 text-[11px] font-black text-slate-400 uppercase tracking-widest">
                    <tr>
                        <th class="px-8 py-5">Order ID</th>
                        <th class="px-8 py-5">Customer</th>
                        <th class="px-8 py-5">Date</th>
                        <th class="px-8 py-5">Payment</th>
                        <th class="px-8 py-5 text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($transactions as $tx)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-5 text-sm font-bold text-slate-400">#o{{ $tx->id }}{{ rand(1000, 9999) }}</td>
                        <td class="px-8 py-5 text-sm font-bold text-slate-700">
                            {{ $tx->customer_name ?? $tx->user->name }}
                        </td>
                        <td class="px-8 py-5 text-sm font-bold text-slate-400">{{ $tx->created_at->format('n/j/Y') }}</td>
                        <td class="px-8 py-5 text-sm font-bold">
                            <span class="{{ $tx->payment_method === 'GCash' ? 'text-emerald-500' : 'text-blue-500' }}">
                                {{ $tx->payment_method }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-right font-black text-slate-900">₱{{ number_format($tx->total, 0) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-10 text-center text-slate-300 font-bold">No transactions recorded yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Sales Trend Chart
    const salesCtx = document.getElementById('salesTrendChart').getContext('2d');
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: ['Fri', 'Sat', 'Sun', 'Mon', 'Tue', 'Wed', 'Thu'],
            datasets: [{
                data: [0, 0, 0, 0, {{ $totalRevenue }}, 0, 0],
                borderColor: '#3b82f6',
                borderWidth: 3,
                tension: 0.4,
                pointBackgroundColor: '#3b82f6',
                pointRadius: 4,
                fill: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { font: { weight: 'bold' }, callback: v => '₱'+v } },
                x: { grid: { display: false }, ticks: { font: { weight: 'bold' } } }
            }
        }
    });

    // Orders Trend Chart
    const ordersCtx = document.getElementById('ordersTrendChart').getContext('2d');
    new Chart(ordersCtx, {
        type: 'bar',
        data: {
            labels: ['Fri', 'Sat', 'Sun', 'Mon', 'Tue', 'Wed', 'Thu'],
            datasets: [{
                data: [0, 0, 0, 0, {{ $totalOrders }}, 0, 0],
                backgroundColor: '#10b981',
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { font: { weight: 'bold' }, stepSize: 1 } },
                x: { grid: { display: false }, ticks: { font: { weight: 'bold' } } }
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
                cutout: '75%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ₱' + context.raw.toLocaleString();
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
