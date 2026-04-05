<?php

namespace App\Http\Controllers;

use App\Models\JenisObat;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DaftarObatController extends Controller
{
   public function index()
   {
       $obats = Obat::with('jenis_obat')->get();
       $jenis_obats = JenisObat::all();
       return view('obat.index', [ // Changed from obat.index 
           'title' => 'Dashmin LifeCareYou',
           'obats' => $obats,
           'jenis_obats' => $jenis_obats
       ]);
   }

   public function jenisobat()
   {
       $jenis_obats = JenisObat::all(); 
       return view('jenis-obat.index', [
           'title' => 'Dashmin LifeCareYou',
           'jenis_obats' => $jenis_obats
       ]);
   }
   
   public function obat(Request $request)
   {
       $request->validate([
           'nama_obat' => 'required',
           'id_jenis' => 'required',
           'harga_jual' => 'required|numeric',
           'deskripsi_obat' => 'required',
           'foto1' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
           'foto2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
           'foto3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
           'stok' => 'required|integer|min:0',
       ]);

       $foto1Path = $request->file('foto1')->store('images/obat', 'public');
       $foto2Path = $request->file('foto2') ? $request->file('foto2')->store('images/obat', 'public') : null;
       $foto3Path = $request->file('foto3') ? $request->file('foto3')->store('images/obat', 'public') : null;

       Obat::create([
           'nama_obat' => $request->nama_obat,
           'id_jenis' => $request->id_jenis,
           'harga_jual' => $request->harga_jual,
           'deskripsi_obat' => $request->deskripsi_obat, // Changed from deskripsi
           'foto1' => $foto1Path,
           'foto2' => $foto2Path,
           'foto3' => $foto3Path,
           'stok' => $request->stok
       ]);

       return redirect()->route('obat')->with('success', 'Obat berhasil ditambahkan.');
   }

   public function destroyObat($id)
   {
       $obat = Obat::findOrFail($id);
       
       // Delete associated images
       if($obat->foto1) Storage::delete('public/' . $obat->foto1);
       if($obat->foto2) Storage::delete('public/' . $obat->foto2);
       if($obat->foto3) Storage::delete('public/' . $obat->foto3);
       
       $obat->delete();
       return redirect()->route('obat')->with('success', 'Obat berhasil dihapus.');
   }

   public function updateObat(Request $request, $id)
   {
       $obat = Obat::findOrFail($id);
       
       $data = $request->validate([
           'nama_obat' => 'required',
           'id_jenis' => 'required',
           'harga_jual' => 'required|numeric',
           'deskripsi_obat' => 'required',
           'foto1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
           'foto2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
           'foto3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
           'stok' => 'required|integer|min:0',
       ]);

       // Handle image updates
       if($request->hasFile('foto1')) {
           if($obat->foto1) Storage::delete('public/' . $obat->foto1);
           $data['foto1'] = $request->file('foto1')->store('images/obat', 'public');
       }
       if($request->hasFile('foto2')) {
           if($obat->foto2) Storage::delete('public/' . $obat->foto2);
           $data['foto2'] = $request->file('foto2')->store('images/obat', 'public');
       }
       if($request->hasFile('foto3')) {
           if($obat->foto3) Storage::delete('public/' . $obat->foto3);
           $data['foto3'] = $request->file('foto3')->store('images/obat', 'public');
       }
       
       $obat->update($data);
       return redirect()->route('obat')->with('success', 'Obat berhasil diperbarui.');
   }

   public function jenis(Request $request)
   {
       $request->validate([
           'jenis' => 'required',
           'deskripsi_jenis' => 'required',
           'image_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
       ]);

       $imagePath = $request->file('image_url')->store('images/jenisobat', 'public');

       JenisObat::create([
           'jenis' => $request->jenis,
           'deskripsi_jenis' => $request->deskripsi_jenis,
           'image_url' => $imagePath // Store only the path, not the full URL
       ]);
       return redirect()->route('jenis-obat')->with('success', 'Jenis Obat berhasil ditambahkan.');
   }

   public function updateJenis(Request $request, $id)
   {
       $jenisobat = JenisObat::findOrFail($id);
       
       $data = $request->validate([
           'jenis' => 'required',
           'deskripsi_jenis' => 'required',
           'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
       ]);

       if($request->hasFile('image_url')) {
           if($jenisobat->image_url) Storage::delete('public/' . $jenisobat->image_url);
           $data['image_url'] = $request->file('image_url')->store('images/jenisobat', 'public');
       }
       
       $jenisobat->update($data);
       return redirect()->route('jenis-obat')->with('success', 'Jenis Obat berhasil diperbarui.');
   }

   public function destroyJenis($id)
   {
       $jenisobat = JenisObat::findOrFail($id);
       if($jenisobat->image_url) {
           Storage::delete('public/' . $jenisobat->image_url);
       }
       $jenisobat->delete();
       return redirect()->route('jenis-obat')->with('success', 'Jenis Obat berhasil dihapus.');
   }

   public function updateHargaJual(Request $request, $id)
   {
       try {
           $obat = Obat::findOrFail($id);
           $obat->update([
               'harga_jual' => $request->harga_jual
           ]);

           return response()->json([
               'success' => true,
               'message' => 'Harga jual berhasil diperbarui'
           ]);
       } catch (\Exception $e) {
           return response()->json([
               'success' => false,
               'message' => 'Gagal memperbarui harga jual: ' . $e->getMessage()
           ], 500);
       }
   }
}
