@extends('layouts.app')

@section('title', 'System Error')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="min-h-[60vh] flex flex-col items-center justify-center text-center">
        <div class="w-24 h-24 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center mb-8">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
        </div>
        <h1 class="text-4xl font-extrabold text-slate-900 mb-4 tracking-tight">Something went wrong.</h1>
        <p class="text-slate-500 max-w-md mb-8">We encountered an error while processing your request. This could be due to a lost connection or a server configuration issue.</p>
        
        <div class="flex gap-4">
            <a href="{{ url()->previous() }}" class="px-6 py-3 bg-white text-slate-700 font-bold rounded-xl border border-slate-200 hover:bg-slate-50 transition">
                Go Back
            </a>
            <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-100">
                Return Home
            </a>
        </div>
    </div>
</div>
@endsection
