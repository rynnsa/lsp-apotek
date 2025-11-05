<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index', ['title' => 'Kontak - LifeCareYou']);
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'message' => 'required',
        ]);

        Mail::raw("Pesan dari: {$validated['email']}\n\n{$validated['message']}", function ($mail) use ($validated) {
            $mail->to('lifecareyou@gmail.com')
                 ->subject('Pesan dari Form Kontak');
        });

        return back()->with('success', 'Pesan kamu berhasil dikirim!');
    }
}