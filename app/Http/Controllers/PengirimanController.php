<?php

namespace App\Http\Controllers;

use App\Models\JenisPengiriman;
use App\Models\Pengiriman;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class PengirimanController extends Controller
{
    public function index()
    {
        $penjualans = Penjualan::with(['pelanggan'])
            ->where('status_order', 'Diproses')  
            ->whereNotNull('no_resi')
            ->latest()
            ->get();

        $kurirs = User::where('jabatan', 'kurir')->get();
        $pengirimans = Pengiriman::with(['penjualan.pelanggan'])->latest()->get();

        return view('pengiriman.pengiriman', compact('penjualans', 'kurirs', 'pengirimans'))
            ->with('title', 'Dashmin LifeCareYou');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_penjualan' => 'required|exists:penjualans,id',
            'no_invoice' => 'required|string',
            'nama_kurir' => 'required|string',
            'telpon_kurir' => 'required|string',
            'tgl_kirim' => 'nullable|date',
            'tgl_tiba' => 'nullable|date',
            'status_kirim' => 'nullable|string',
            'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $validated['tgl_kirim'] = now();
        $validated['status_kirim'] = 'Sedang Dikirim';
        $validated['keterangan'] = 'Kurir belum konfirmasi';

        // Jika upload foto
        if ($request->hasFile('bukti_foto')) {
            $file = $request->file('bukti_foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pengiriman'), $filename);
            $validated['bukti_foto'] = $filename;
        }

        // Simpan data pengiriman
        Pengiriman::create($validated);

        // Update status penjualan
        Penjualan::find($request->id_penjualan)->update([
            'status_order' => 'Menunggu Kurir'
        ]);

        return redirect()->route('pengiriman')->with('success', 'Data pengiriman berhasil ditambahkan');
    }


    public function update(Request $request, $id)
    {
        try {
            $pengiriman = Pengiriman::findOrFail($id);

            $data = $request->validate([
                'status_kirim' => 'required',
                'tgl_tiba' => 'nullable|date',
                'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'keterangan' => 'nullable|string'
            ]);

            if ($request->hasFile('bukti_foto')) {
                // Delete old image
                if ($pengiriman->bukti_foto) {
                    Storage::delete('public/' . $pengiriman->bukti_foto);
                }
                
                // Store new image
                $data['bukti_foto'] = $request->file('bukti_foto')->store('pengiriman', 'public');
            }

            // Update related penjualan status if delivery is completed
            if ($data['status_kirim'] == 'Tiba Ditujuan') {
                $pengiriman->penjualan->update(['status_order' => 'Selesai']);
            }

            $pengiriman->update($data);
            return redirect()->route('pengiriman');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $pengiriman = Pengiriman::findOrFail($id);
            
            // Delete bukti_foto if exists
            if ($pengiriman->bukti_foto) {
                Storage::delete('public/' . $pengiriman->bukti_foto);
            }
            
            $pengiriman->delete();
            return redirect()->route('pengiriman')->with('success', 'Data pengiriman berhasil dihapus');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        } 
    }

    public function jenis()
    {
        $jenis_pengirimans = JenisPengiriman::orderBy('created_at', 'desc')->get();
        return view('pengiriman.jenis-pengiriman', [
            'jenis_pengirimans' => $jenis_pengirimans,
            'title' => 'Dashmin LifeCareYou'
        ]);
    }

    public function storeJenis(Request $request)
    {
        $request->validate([
            'jenis_kirim' => 'required',
            'ongkos_kirim' => 'required|numeric',
            'nama_expedisi' => 'nullable|string',
            'logo_expedisi' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        try {
            $data = $request->all();

            if ($request->hasFile('logo_expedisi')) {
                $logo = $request->file('logo_expedisi');
                $logoName = time() . '.' . $logo->getClientOriginalExtension();
                $logo->move(public_path('uploads/logo_expedisi'), $logoName);
                $data['logo_expedisi'] = $logoName;
            }

            JenisPengiriman::create($data);

            return redirect()->route('jenis-pengiriman')
                ->with('success', 'Jenis pengiriman berhasil ditambahkan');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updateJenis(Request $request, $id)
    {
        $request->validate([
            'jenis_kirim' => 'required',
            'nama_expedisi' => 'required',
            'logo_expedisi' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $jenis_pengiriman = JenisPengiriman::find($id);

        if ($request->hasFile('logo_expedisi')) {
            // Delete old image
            if ($jenis_pengiriman->logo_expedisi && file_exists(public_path('uploads/logo_expedisi/' . $jenis_pengiriman->logo_expedisi))) {
                unlink(public_path('uploads/logo_expedisi/' . $jenis_pengiriman->logo_expedisi));
            }
            
            $file = $request->file('logo_expedisi');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/logo_expedisi'), $filename);
            $jenis_pengiriman->logo_expedisi = $filename;
        }

        $jenis_pengiriman->jenis_kirim = $request->jenis_kirim;
        $jenis_pengiriman->nama_expedisi = $request->nama_expedisi;
        $jenis_pengiriman->save();

        return redirect()->route('jenis-pengiriman')->with('success', 'Jenis Pengiriman berhasil diperbarui');
    }

    public function destroyJenis($id)
    {
        $jenis_pengiriman = JenisPengiriman::find($id);
        $jenis_pengiriman->delete();

        return redirect()->route('jenis-pengiriman')->with('success', 'Jenis Pengiriman berhasil dihapus');
    }

    public function datapengiriman()
    {
        $pengirimans = Pengiriman::with('penjualan')->get();
        $penjualans = Penjualan::with('pelanggan')
            ->where('status_order', 'Diproses')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pengiriman.data-pengiriman', [
            'title' => 'Dashmin LifeCareYou',
            'pengirimans' => $pengirimans,
            'penjualans' => $penjualans,
        ]);
    }

    public function storeDataPengiriman(Request $request)
    {
        $request->validate([
            'id_penjualan' => 'required|exists:penjualans,id',
            'no_invoice' => 'required',
            'tgl_kirim' => 'required|date',
            'status_kirim' => 'required',
            'nama_kurir' => 'required',
            'telpon_kurir' => 'required',
            'ongkos_kirim' => 'required|numeric',
            'tgl_tiba' => 'nullable|date',
            'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'keterangan' => 'nullable'
        ]);

        $data = $request->all();
        
        if ($request->hasFile('bukti_foto')) {
            $file = $request->file('bukti_foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pengiriman'), $filename);
            $data['bukti_foto'] = $filename;
        }

        Pengiriman::create($data);
        return redirect()->route('pengiriman')->with('success', 'Data pengiriman berhasil ditambahkan');
    }

    public function updateDataPengiriman(Request $request, $id)
    {
        $request->validate([
            'no_invoice' => 'required',
            'tgl_kirim' => 'required|date',
            'status_kirim' => 'required',
            'nama_kurir' => 'required',
            'telpon_kurir' => 'required',
            'bukti_foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'keterangan' => 'nullable'
        ]);

        $pengiriman = Pengiriman::find($id);
        $data = $request->all();

        if ($request->hasFile('bukti_foto')) {
            // Delete old image if exists
            if ($pengiriman->bukti_foto && file_exists(public_path('uploads/pengiriman/' . $pengiriman->bukti_foto))) {
                unlink(public_path('uploads/pengiriman/' . $pengiriman->bukti_foto));
            }
            
            $file = $request->file('bukti_foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pengiriman'), $filename);
            $data['bukti_foto'] = $filename;
        }

        $pengiriman->update($data);
        return redirect()->route('pengiriman')->with('success', 'Data pengiriman berhasil diperbarui');
    }

    public function destroyDataPengiriman($id)
    {
        $pengiriman = Pengiriman::find($id);
        
        // Delete image if exists
        if ($pengiriman->bukti_foto && file_exists(public_path('uploads/pengiriman/' . $pengiriman->bukti_foto))) {
            unlink(public_path('uploads/pengiriman/' . $pengiriman->bukti_foto));
        }
        
        $pengiriman->delete();
        return redirect()->route('pengiriman')->with('success', 'Data pengiriman berhasil dihapus');
    }
    
}