@extends('layouts.app')

@section('title', 'Customer Dashboard')

@section('content')
<div class="space-y-10 animate-in fade-in duration-700 pb-20">
    <!-- Premium Greeting Banner -->
    <div class="bg-gradient-to-r from-[#1e40af] to-[#3b82f6] p-12 rounded-[40px] text-white shadow-2xl shadow-blue-200 relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-5xl font-black tracking-tight mb-2">Hello, {{ Auth::user()->name }}!</h1>
            <p class="text-blue-100/80 text-xl font-medium mb-6">Need a refill? We're ready to deliver to your doorstep...</p>
            <div class="flex gap-4">
                <a href="{{ route('orders.create') }}" class="px-8 py-3 bg-white text-blue-600 font-black rounded-2xl hover:bg-blue-50 transition shadow-xl">
                    Order Refill Now
                </a>
            </div>
        </div>
        <div class="absolute -right-20 -bottom-20 opacity-10">
            <svg width="400" height="400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>
        </div>
    </div>

    <!-- Stats Cards Row -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-slate-100 flex flex-col gap-4">
            <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 shadow-inner">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
            </div>
            <div>
                <p class="text-3xl font-black text-slate-900 leading-none mb-2">0</p>
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Total Refills</p>
            </div>
        </div>

        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-slate-100 flex flex-col gap-4">
            <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 shadow-inner">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <div>
                <p class="text-3xl font-black text-slate-900 leading-none mb-2">Active</p>
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Account Status</p>
            </div>
        </div>

        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-slate-100 flex flex-col gap-4">
            <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600 shadow-inner">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            </div>
            <div>
                <p class="text-3xl font-black text-slate-900 leading-none mb-2">120</p>
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Loyalty Points</p>
            </div>
        </div>
    </div>

    <!-- Info Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white p-10 rounded-[40px] shadow-sm border border-slate-100">
            <h3 class="text-xl font-black text-slate-800 tracking-tight mb-8">Delivery Information</h3>
            <div class="space-y-6">
                <div class="flex items-start gap-4 p-6 bg-slate-50 rounded-3xl border border-slate-100">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-blue-600 shadow-sm shrink-0">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Primary Address</p>
                        <p class="text-sm font-bold text-slate-700 leading-relaxed">{{ Auth::user()->address }}</p>
                    </div>
                </div>
                <p class="text-xs text-slate-400 font-medium px-2 italic">Note: You can update your delivery address for each specific order during checkout.</p>
            </div>
        </div>

        <div class="bg-slate-900 p-10 rounded-[40px] shadow-2xl text-white">
            <h3 class="text-xl font-black tracking-tight mb-6">Quick Tracking</h3>
            <div class="py-8 flex flex-col items-center justify-center text-center space-y-4">
                <div class="w-20 h-20 bg-white/10 rounded-full flex items-center justify-center text-blue-400 animate-pulse">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                </div>
                <p class="text-slate-400 font-bold">No active deliveries at the moment.</p>
                <a href="{{ route('orders.index') }}" class="text-blue-400 font-black text-xs uppercase tracking-widest hover:text-blue-300">View Order History</a>
            </div>
        </div>
    </div>
</div>
@endsection
