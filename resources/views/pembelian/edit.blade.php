@extends('be.master-admin')
@section('sidebar')
    @include('be.sidebar')  
@endsection
@section('content')
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="card">
                    <div class="card-header">
                        <h5>Pembelian</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('pembelian.update', $pembelian->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Nomor Nota</label>
                                        <input type="text" class="form-control" name="no_nota" value="{{ $pembelian->no_nota }}" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Tanggal Pembelian</label>
                                        <input type="date" class="form-control" name="tgl_pembelian" value="{{ $pembelian->tgl_pembelian }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Total Bayar</label>
                                        <input type="number" class="form-control" name="total_bayar" value="{{ $pembelian->total_bayar }}" readonly>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Distributor</label>
                                        <select class="form-select form-control rounded-3 custom-select" name="id_distributor" required>
                                            <option value="">Pilih Distributor</option>
                                            @foreach($distributors as $distributor)
                                                <option value="{{ $distributor->id }}" {{ $distributor->id == $pembelian->id_distributor ? 'selected' : '' }}>
                                                    {{ $distributor->nama_distributor }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="card mt-4">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5>Detail Pembelian</h5>
                                    <button type="button" class="btn btn-primary btn-sm" onclick="addDetailForm()">
                                        <i class="bi bi-plus-circle"></i> Tambah Detail
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div id="detail-forms">
                                        @foreach($detail_pembelians as $index => $detail)
                                            <div class="detail-form mb-4">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Obat</label>
                                                            <select class="form-select form-control rounded-3 custom-select" name="details[{{ $index }}][id_obat]" required>
                                                                <option value="">Pilih Obat</option>
                                                                @foreach($obats as $obat)
                                                                    <option value="{{ $obat->id }}" {{ $obat->id == $detail->id_obat ? 'selected' : '' }}>
                                                                        {{ $obat->nama_obat }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>Jumlah</label>
                                                            <input type="number" class="form-control" name="details[{{ $index }}][jumlah_beli]" value="{{ $detail->jumlah_beli }}" onchange="calculateSubtotal(this)" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>Harga</label>
                                                            <input type="number" class="form-control" name="details[{{ $index }}][harga_beli]" value="{{ $detail->harga_beli }}" onchange="calculateSubtotal(this)" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>Subtotal</label>
                                                            <input type="number" class="form-control" name="details[{{ $index }}][subtotal]" value="{{ $detail->subtotal }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1 d-flex align-items-end">
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="removeDetailForm(this)" {{ count($detail_pembelians) > 1 ? '' : 'style="display:none;"' }}>
                                                            <i class="ti-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('pembelian') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let detailCount = {{ count($detail_pembelians) }};

function addDetailForm() {
    // Create a new detail form template
    const template = document.createElement('div');
    template.className = 'detail-form mb-4';
    template.innerHTML = `
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Obat</label>
                    <select class="form-select form-control rounded-3 custom-select" name="details[${detailCount}][id_obat]" required>
                        <option value="">Pilih Obat</option>
                        @foreach($obats as $obat)
                            <option value="{{ $obat->id }}">{{ $obat->nama_obat }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Jumlah</label>
                    <input type="number" class="form-control" name="details[${detailCount}][jumlah_beli]" onchange="calculateSubtotal(this)" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Harga</label>
                    <input type="number" class="form-control" name="details[${detailCount}][harga_beli]" onchange="calculateSubtotal(this)" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Subtotal</label>
                    <input type="number" class="form-control" name="details[${detailCount}][subtotal]" readonly>
                </div>
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-sm" onclick="removeDetailForm(this)">
                    <i class="ti-trash"></i>
                </button>
            </div>
        </div>
    `;
    
    document.getElementById('detail-forms').appendChild(template);
    detailCount++;
    
    // Show remove buttons if there are more than 1 detail forms
    updateRemoveButtons();
}

function removeDetailForm(button) {
    const formDiv = button.closest('.detail-form');
    formDiv.remove();
    updateTotal();
    updateRemoveButtons();
}

function calculateSubtotal(input) {
    const row = input.closest('.row');
    const jumlah = row.querySelector('[name*="jumlah_beli"]').value || 0;
    const harga = row.querySelector('[name*="harga_beli"]').value || 0;
    const subtotal = jumlah * harga;
    row.querySelector('[name*="subtotal"]').value = subtotal;
    updateTotal();
}

function updateTotal() {
    const subtotals = [...document.querySelectorAll('[name*="subtotal"]')].map(input => Number(input.value) || 0);
    const total = subtotals.reduce((sum, current) => sum + current, 0);
    document.querySelector('[name="total_bayar"]').value = total;
}

function updateRemoveButtons() {
    const detailForms = document.querySelectorAll('.detail-form');
    const removeButtons = document.querySelectorAll('.detail-form .btn-danger');
    
    if (detailForms.length > 1) {
        removeButtons.forEach(button => {
            button.style.display = 'block';
        });
    } else {
        removeButtons.forEach(button => {
            button.style.display = 'none';
        });
    }
}

// Initialize remove buttons on page load
document.addEventListener('DOMContentLoaded', function() {
    updateRemoveButtons();
});
</script>
@endsection