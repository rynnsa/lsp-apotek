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
                                        @foreach($detail_pembelians as $detail)
                                            <div class="detail-form mb-4">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Obat</label>
                                                            <select class="form-select form-control rounded-3 custom-select" name="id_obat" required>
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
                                                            <input type="number" class="form-control" name="jumlah_beli" value="{{ $detail->jumlah_beli }}" onchange="calculateSubtotal(this)" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>Harga</label>
                                                            <input class="form-control" name="harga_beli" value="{{ $detail->harga_beli }}" onchange="calculateSubtotal(this)" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>Subtotal</label>
                                                            <input type="number" class="form-control" name="subtotal" value="{{ $detail->subtotal }}" readonly>
                                                        </div>
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
let detailCount = 1;

function addDetailForm() {
    const template = document.querySelector('.detail-form').cloneNode(true);
    const inputs = template.querySelectorAll('input, select');
    
    inputs.forEach(input => {
        const name = input.getAttribute('name');
        if (name) {
            input.setAttribute('name', name.replace('[0]', `[${detailCount}]`));
        }
        if (input.type !== 'button') {
            input.value = '';
        }
    });
    
    template.querySelector('.btn-danger').style.display = 'block';
    document.getElementById('detail-forms').appendChild(template);
    detailCount++;
}

function removeDetailForm(button) {
    const formDiv = button.closest('.detail-form');
    formDiv.remove();
    updateTotal();
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
</script>
