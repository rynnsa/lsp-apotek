<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PelangganController extends Controller
{   
    public function register()
    {
        return view('fe.register', ['title' => 'Register - LifeCareYou']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'email' => 'required|email|unique:pelanggans',
            'katakunci' => 'required',
            'no_telp' => 'required|string',
            'alamat1' => 'required|string',
            'kota1' => 'required|string',
            'propinsi1' => 'required|string',
            'kodepos1' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'url_ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Hash password
        $validated['katakunci'] = Hash::make($validated['katakunci']);

        // Handle file uploads
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('pelanggan-photos', 'public');
            $validated['foto'] = $fotoPath;
        }
        
        if ($request->hasFile('url_ktp')) {
            $ktpPath = $request->file('url_ktp')->store('pelanggan-ktp', 'public');
            $validated['url_ktp'] = $ktpPath;
        }

        // Create new pelanggan
        $pelanggan = Pelanggan::create($validated);
        Auth::guard('pelanggan')->login($pelanggan);
        
        return redirect()->route('home')->with('success', 'Selamat datang, ' . $pelanggan->nama_pelanggan);
    }

    public function login()
    {
        return view('fe.login-pelanggan', ['title' => 'login - LifeCareYou']);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'katakunci' => 'required'
        ]);

        // Attempt to find the pelanggan
        $pelanggan = Pelanggan::where('email', $credentials['email'])->first();

        if ($pelanggan && Hash::check($credentials['katakunci'], $pelanggan->katakunci)) {
            Auth::guard('pelanggan')->login($pelanggan);
            $request->session()->regenerate();
            return redirect()->route('home')->with('success', 'Selamat datang kembali, ' . $pelanggan->nama_pelanggan);
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('pelanggan')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function datapelanggan()
    {
        $pelanggans = Pelanggan::all();
        return view('data-pelanggan.index', [
            'title' => 'Dashmin LifeCareYou',
            'pelanggans' => $pelanggans
        ]);
    }

    public function pesanan()
    {
        return view('pesanan.create', ['title' => 'Dashmin LifeCareYou']);
    }
}
