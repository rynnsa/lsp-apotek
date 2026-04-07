<?php

namespace App\Http\Controllers;

use App\Models\DetailPembelian;
use App\Models\Distributor;
use App\Models\Obat;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class DistributorController extends Controller
{

    public function index()
    {
        $distributors = Distributor::orderBy('created_at', 'desc')->get();
        return view('distributor.index', 
        compact('distributors'))
            ->with('title', 'Dashmin LifeCareYou');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_distributor' => 'required',
            'telepon' => 'required',
            'alamat' => 'required'
        ]);

        Distributor::create($request->all());

        return redirect()->route('distributor')
            ->with('success', 'Distributor berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_distributor' => 'required',
            'telepon' => 'required',
            'alamat' => 'required'
        ]);

        $distributor = Distributor::findOrFail($id);
        $distributor->update($request->all());

        return redirect()->route('distributor')
            ->with('success', 'Distributor berhasil diperbarui');
    }

    public function updateDistributor(Request $request, $id)
    {
        return $this->update($request, $id);
    }

    public function destroyDistributor($id)
    {
        return $this->destroy($id);
    }

    public function destroy($id)
    {
        $distributor = Distributor::findOrFail($id);
        $distributor->delete();

        return redirect()->route('distributor')
            ->with('success', 'Distributor berhasil dihapus');
    }

    public function pembelian()
    {
        $pembelians = Pembelian::with(['distributor', 'detail_pembelians.obat'])->get();
        $distributors = Distributor::all();

        return view('pembelian.index', [
            'title' => 'Dashmin LifeCareYou',
            'pembelians' => $pembelians,
            'distributors' => $distributors,
        ]);
    }

    public function create()
    {
        return view('pembelian.create', [
            'title' => 'Dashmin LifeCareYou',
            'distributors' => Distributor::all(),
            'obats' => Obat::all()
        ]);
    }

    public function storePembelian(Request $request)
    {
        try {
            DB::beginTransaction();

            // Create pembelian
            $pembelian = Pembelian::create([
                'no_nota' => $request->no_nota,
                'tgl_pembelian' => $request->tgl_pembelian,
                'total_bayar' => $request->total_bayar,
                'id_distributor' => $request->id_distributor
            ]);

            // Create detail pembelian
            foreach ($request->details as $detail) {
                DetailPembelian::create([
                    'id_pembelian' => $pembelian->id,
                    'id_obat' => $detail['id_obat'],
                    'jumlah_beli' => $detail['jumlah_beli'],
                    'harga_beli' => $detail['harga_beli'],
                    'subtotal' => $detail['subtotal']
                ]);

                // Update stok obat
                $obat = Obat::find($detail['id_obat']);
                if ($obat) {
                    $obat->increment('stok', $detail['jumlah_beli']);
                }
            }

            DB::commit();
            return redirect()->route('pembelian')->with('success', 'Data pembelian berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $pembelian = Pembelian::with('distributor')->findOrFail($id);
        $detail_pembelians = DetailPembelian::where('id_pembelian', $id)->get();
        return view('pembelian.edit', [
            'title' => 'Dashmin LifeCareYou',
            'pembelian' => $pembelian,
            'detail_pembelians' => $detail_pembelians,
            'distributors' => Distributor::all(),
            'obats' => Obat::all()
        ]);
    }

    public function updatePembelian(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $pembelian = Pembelian::findOrFail($id);

            $validated = $request->validate([
                'no_nota' => 'required|unique:pembelians,no_nota,' . $id,
                'tgl_pembelian' => 'required|date',
                'total_bayar' => 'required|numeric',
                'id_distributor' => 'required|exists:distributors,id'
            ]);

            // Get old details for stock adjustment
            $oldDetails = DetailPembelian::where('id_pembelian', $id)->get();

            // Decrease stock for old quantities
            foreach ($oldDetails as $oldDetail) {
                $obat = Obat::find($oldDetail->id_obat);
                if ($obat) {
                    $obat->decrement('stok', $oldDetail->jumlah_beli);
                }
            }

            $pembelian->update($validated);

            // Delete old details
            DetailPembelian::where('id_pembelian', $id)->delete();

            // Create new details and update stock
            if ($request->has('details')) {
                foreach ($request->details as $detail) {
                    DetailPembelian::create([
                        'id_pembelian' => $pembelian->id,
                        'id_obat' => $detail['id_obat'],
                        'jumlah_beli' => $detail['jumlah_beli'],
                        'harga_beli' => $detail['harga_beli'],
                        'subtotal' => $detail['subtotal']
                    ]);

                    // Increase stock for new quantities
                    $obat = Obat::find($detail['id_obat']);
                    if ($obat) {
                        $obat->increment('stok', $detail['jumlah_beli']);
                    }
                }
            }

            DB::commit();
            return redirect()->route('pembelian')->with('success', 'Pembelian berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroyPembelian($id)
    {
        try {
            $pembelian = Pembelian::findOrFail($id);
            $pembelian->delete();
            return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus pembelian.');
        }
    }

    public function detail()
    {
        $detail_pembelians = DetailPembelian::with(['pembelian', 'obat'])->get();
        return view('detail-pembelian.index', [
            'title' => 'Dashmin LifeCareYou',
            'detail_pembelians' => $detail_pembelians,
            'pembelians' => Pembelian::all(),
            'distributors' => Distributor::all(),
            'obats' => Obat::all()
        ]);
    }

    public function storeDetail(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'id_pembelian' => 'required|exists:pembelians,id',
                'id_obat' => 'required|exists:obats,id',
                'jumlah_beli' => 'required|numeric|min:1',
                'harga_beli' => 'required|numeric'
            ]);

            $subtotal = $request->jumlah_beli * $request->harga_beli;

            DetailPembelian::create([
                'id_obat' => $request->id_obat,
                'jumlah_beli' => $request->jumlah_beli,
                'harga_beli' => $request->harga_beli,
                'subtotal' => $subtotal,
                'id_pembelian' => $request->id_pembelian
            ]);

            // Update stock
            $obat = Obat::find($request->id_obat);
            if ($obat) {
                $obat->increment('stok', $request->jumlah_beli);
            }

            DB::commit();
            return redirect()->route('detailpembelian.index')->with('success', 'Detail pembelian berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updateDetail(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $detail = DetailPembelian::findOrFail($id);

            $validated = $request->validate([
                'id_obat' => 'required|exists:obats,id',
                'jumlah_beli' => 'required|numeric|min:1',
                'harga_beli' => 'required|numeric',
                'id_pembelian' => 'required|exists:pembelians,id'
            ]);

            $validated['subtotal'] = $validated['jumlah_beli'] * $validated['harga_beli'];

            // Handle stock adjustment if obat changed or quantity changed
            if ($detail->id_obat != $validated['id_obat'] || $detail->jumlah_beli != $validated['jumlah_beli']) {
                // Decrease stock for old obat/quantity
                $oldObat = Obat::find($detail->id_obat);
                if ($oldObat) {
                    $oldObat->decrement('stok', $detail->jumlah_beli);
                }

                // Increase stock for new obat/quantity
                $newObat = Obat::find($validated['id_obat']);
                if ($newObat) {
                    $newObat->increment('stok', $validated['jumlah_beli']);
                }
            }

            $detail->update($validated);

            DB::commit();
            return redirect()->route('detailpembelian.index')->with('success', 'Detail pembelian berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroyDetail($id)
    {
        try {
            $detailPembelian = DetailPembelian::findOrFail($id);

            // Decrease stock when deleting detail
            $obat = Obat::find($detailPembelian->id_obat);
            if ($obat) {
                $obat->decrement('stok', $detailPembelian->jumlah_beli);
            }

            $detailPembelian->delete();
            return redirect()->route('detailpembelian.index')->with('success', 'Detail pembelian berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus detail pembelian.');
        }
    }
}