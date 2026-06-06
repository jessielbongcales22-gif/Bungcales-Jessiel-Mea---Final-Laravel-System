<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $gcashQr = Setting::get('gcash_qr_data');
        return view('admin.settings.index', compact('gcashQr'));
    }

    public function updateGcashQr(Request $request)
    {
        $request->validate([
            'gcash_qr' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        if ($request->hasFile('gcash_qr')) {
            $file = $request->file('gcash_qr');
            $extension = $file->getClientOriginalExtension();
            $data = file_get_contents($file->getRealPath());
            
            // Convert to Base64 to save directly in the database
            $base64 = 'data:image/' . $extension . ';base64,' . base64_encode($data);
            
            Setting::set('gcash_qr_data', $base64);
        }

        return back()->with('success', 'GCash QR Code saved to database successfully.');
    }
}
