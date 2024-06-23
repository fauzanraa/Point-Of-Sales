@extends('layout.template')
@section('content')
<div class="card card-outline card-primary">
  <div class="card-header">
    <h3 class="card-title">{{ $page->title }}</h3>
    <div class="card-tools"></div>
  </div>
  <div class="card-body">
    @if (session('error'))
        <div class="alert alert-danger">{{session('error')}}</div>
    @endif
    <form method="POST" action="{{ url('penjualan') }}" class="form-horizontal" enctype="multipart/form-data">
      @csrf
      <div class="form-group row">
        <label class="col-1 control-label col-form-label">Kasir</label>
        <div class="col-11">
          <input type="text" class="form-control" id="kasir" name="kasir" value="{{$user->nama}}" disabled>
          @error('kasir')
          <small class="form-text text-danger">{{ $message }}</small>
          @enderror
        </div>
      </div>
    <input type="text" class="form-control" id="id" name="id" value="{{$user->user_id}}" hidden>
      <div class="form-group row">
        <label class="col-1 control-label col-form-label">Pembeli</label>
        <div class="col-11">
          <input type="text" class="form-control" id="pembeli" name="pembeli" required>
          @error('pembeli')
          <small class="form-text text-danger">{{ $message }}</small>
          @enderror
        </div>
      </div>
      <button type="button" class="btn btn-primary" id="tambahBarang">Tambah Barang</button>
      <div id="inputBarangTambahan"></div>
      <br>

      <div class="form-group row">
        <label class="col-1 control-label col-form-label">Total Harga</label>
        <div class="col-11">
          <input type="text" class="form-control" id="totalHarga" name="total_harga" readonly>
        </div>
      </div>

      <div class="form-group row">
        <label class="col-1 control-label col-form-label"></label>
        <div class="col-11">
          <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
          <a class="btn btn-sm btn-default ml-1" href="{{ url('penjualan') }}">Kembali</a>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@push('css')
@endpush
@push('js')
<script>
document.getElementById('tambahBarang').addEventListener('click', function() {
    var div = document.createElement('div');
    div.classList.add('form-group');
    div.innerHTML = `
        <br>
        <div class="form-group row">
        <label class="col-1 control-label col-form-label">Barang</label>
        <div class="col-11">
          <select class="barang form-control" id="barang" name="barang_nama[]" required>
            <option value="">- Pilih Barang -</option>
            @foreach($barang as $item)
            <option value="{{ $item->barang_id }}" data-harga="{{ $item->harga_jual }}">{{ $item->barang_nama}}</option>
            @endforeach
          </select>
          @error('barang')
          <small class="form-text text-danger">{{ $message }}</small>
          @enderror
        </div>
      </div>
      <div class="form-group row">
        <label class="col-1 control-label col-form-label">Jumlah</label>
        <div class="col-11">
          <input type="text" class="jumlah form-control" id="jumlah" name="jumlah[]" required>
          @error('jumlah')
          <small class="form-text text-danger">{{ $message }}</small>
          @enderror
        </div>
      </div>
    `;
    document.getElementById('inputBarangTambahan').appendChild(div);
});

document.addEventListener('input', function(event) {
    if (event.target.classList.contains('barang') || event.target.classList.contains('jumlah')) {
        var totalHarga = 0;
        var semuaBarang = document.querySelectorAll('.barang');
        var semuaJumlah = document.querySelectorAll('.jumlah');

        for (var i = 0; i < semuaBarang.length; i++) {
            var harga = parseFloat(semuaBarang[i].options[semuaBarang[i].selectedIndex].getAttribute('data-harga'));
            console.log(harga);
            var jumlah = parseFloat(semuaJumlah[i].value);
            if (!isNaN(harga) && !isNaN(jumlah)) {
                totalHarga += harga * jumlah;
            }
        }

        document.getElementById('totalHarga').value = totalHarga.toFixed(2);
    }
});
</script>
@endpush

