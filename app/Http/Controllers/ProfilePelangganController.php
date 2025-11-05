<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfilePelangganController extends Controller
{
   
    public function index()
    {
        $pelanggan = Auth::guard('pelanggan', 'daftarAlamat')->user();
        return view('profile-pelanggan.index', [
            'title' => 'Profile - LifeCareYou',
            'pelanggan' => $pelanggan
        ]);
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            $pelanggan = Auth::guard('pelanggan')->user();

            $validated = $request->validate([
                'nama_pelanggan' => 'required|string',
                'email' => 'required|email',
                'no_telp' => 'required',
                'alamat' => 'required|array',
                'kota' => 'required|array',
                'provinsi' => 'required|array',
                'kodepos' => 'required|array',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'url_ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            // Handle file uploads
            if ($request->hasFile('foto')) {
                if ($pelanggan->foto) {
                    Storage::delete('public/' . $pelanggan->foto);
                }
                $validated['foto'] = $request->file('foto')->store('pelanggan/foto', 'public');
            }

            if ($request->hasFile('url_ktp')) {
                if ($pelanggan->url_ktp) {
                    Storage::delete('public/' . $pelanggan->url_ktp);
                }
                $validated['url_ktp'] = $request->file('url_ktp')->store('pelanggan/ktp', 'public');
            }

            // Update basic info
            $data = [
                'nama_pelanggan' => $validated['nama_pelanggan'],
                'email' => $validated['email'],
                'no_telp' => $validated['no_telp']
            ];

            // Add uploaded files to data if they exist
            if (isset($validated['foto'])) {
                $data['foto'] = $validated['foto'];
            }
            if (isset($validated['url_ktp'])) {
                $data['url_ktp'] = $validated['url_ktp'];
            }

            // Update addresses
            $data['alamat1'] = $validated['alamat'][0] ?? null;
            $data['kota1'] = $validated['kota'][0] ?? null;
            $data['provinsi1'] = $validated['provinsi'][0] ?? null;
            $data['kodepos1'] = $validated['kodepos'][0] ?? null;

            if (isset($validated['alamat'][1])) {
                $data['alamat2'] = $validated['alamat'][1];
                $data['kota2'] = $validated['kota'][1];
                $data['provinsi2'] = $validated['provinsi'][1];
                $data['kodepos2'] = $validated['kodepos'][1];
            }

            if (isset($validated['alamat'][2])) {
                $data['alamat3'] = $validated['alamat'][2];
                $data['kota3'] = $validated['kota'][2];
                $data['provinsi3'] = $validated['provinsi'][2];
                $data['kodepos3'] = $validated['kodepos'][2];
            }

            $pelanggan->update($data);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Profil berhasil diperbarui'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui profil: ' . $e->getMessage()
            ], 500);
        }
    }
}
