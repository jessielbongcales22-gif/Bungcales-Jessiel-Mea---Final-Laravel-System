@extends('layouts.app')

@section('title', 'System Settings')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">System Settings</h1>
        <p class="text-slate-500">Configure station parameters and payment options.</p>
    </div>

    <div class="grid grid-cols-1 gap-8">
        <!-- GCash QR Code Upload -->
        <div class="bg-white rounded-[40px] shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-10">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 shadow-inner">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-800">GCash Payment Settings</h3>
                        <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Manage QR Code Image</p>
                    </div>
                </div>

                <form action="{{ route('admin.settings.updateGcash') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    @csrf
                    <div class="space-y-6">
                        <div class="p-6 bg-slate-50 rounded-[32px] border-2 border-dashed border-slate-200 flex flex-col items-center justify-center text-center">
                            @if($gcashQr)
                                <img src="{{ $gcashQr }}" class="w-48 h-48 object-contain rounded-xl mb-4 shadow-lg border border-white" alt="GCash QR">
                                <p class="text-xs text-slate-400 font-bold uppercase">Current QR Code (Stored in DB)</p>
                            @else
                                <div class="w-48 h-48 bg-slate-100 rounded-xl flex items-center justify-center text-slate-300 mb-4">
                                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><rect x="7" y="7" width="3" height="3"/><rect x="14" y="7" width="3" height="3"/><rect x="7" y="14" width="3" height="3"/><path d="M14 14h3v3h-3z"/></svg>
                                </div>
                                <p class="text-xs text-slate-400 font-bold uppercase">No QR Code Uploaded</p>
                            @endif
                        </div>
                    </div>

                    <div class="flex flex-col justify-center space-y-6">
                        <div class="space-y-2">
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Upload New QR Code</label>
                            <input type="file" name="gcash_qr" required 
                                class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-3xl focus:ring-2 focus:ring-blue-500 outline-none transition font-bold text-slate-700">
                            <p class="text-[10px] text-slate-400 ml-1">Recommended size: 500x500px. Formats: JPG, PNG, SVG.</p>
                        </div>

                        <button type="submit" class="w-full py-5 bg-[#0a56f1] text-white font-black rounded-[32px] shadow-2xl shadow-blue-200 hover:bg-blue-700 active:scale-[0.98] transition-all flex items-center justify-center gap-3">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                            Save QR Code
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
