<?php

namespace App\Http\Controllers;

use App\Models\MetodeBayar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MetodeBayarController extends Controller
{
    public function index()
    {
        $metode_bayars = MetodeBayar::all();
        return view('metode-bayar.index',[
            'title' => 'Dashmin LifeCareYou',
            'metode_bayars' => $metode_bayars 
        ]);
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'metode_pembayaran' => 'required',
            'tempat_bayar' => 'required',
            'no_rekening' => 'required',
            'url_logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('url_logo')) {
            $logo = $request->file('url_logo')->store('metode-bayar', 'public');
            $validated['url_logo'] = $logo;
        }

        MetodeBayar::create($validated);
        return redirect()->route('metodebayar')->with('success', 'Metode pembayaran berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $metode_bayar = MetodeBayar::findOrFail($id);
        $validated = $request->validate([
            'metode_pembayaran' => 'required',
            'tempat_bayar' => 'required',
            'no_rekening' => 'required',
            'url_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('url_logo')) {
            if ($metode_bayar->url_logo) {
                Storage::disk('public')->delete($metode_bayar->url_logo);
            }
            $logo = $request->file('url_logo')->store('metode-bayar', 'public');
            $validated['url_logo'] = $logo;
        }

        $metode_bayar->update($validated);
        return redirect()->route('metodebayar')->with('success', 'Metode pembayaran berhasil diperbarui');
    }

    public function destroy($id)
    {
        $metode_bayar = MetodeBayar::findOrFail($id);
        if ($metode_bayar->url_logo) {
            Storage::disk('public')->delete($metode_bayar->url_logo);
        }
        $metode_bayar->delete();
        return redirect()->route('metodebayar')->with('success', 'Metode pembayaran berhasil dihapus');
    }
}
