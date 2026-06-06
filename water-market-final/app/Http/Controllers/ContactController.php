<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Handle the contact form submission.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        try {
            ContactMessage::create($validated);
            
            return back()->with('success', 'Thank you! Your message has been sent successfully. We will get back to you soon.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Sorry, there was an issue sending your message. Please try again later.');
        }
    }
}
