@extends('layout.template')
@section('content')
<div class="card card-outline card-primary">
  <div class="card-header">
    <h3 class="card-title">{{ $page->title }}</h3>
    <div class="card-tools"></div>
  </div>
  <div class="card-body">
    @empty($barang)
    <div class="alert alert-danger alert-dismissible">
      <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
      Data yang Anda cari tidak ditemukan.
    </div>
    @else
    <table class="table table-bordered table-striped table-hover table-sm">
      <tr>
        <th>ID</th>
        <td>{{ $barang->barang_id }}</td>
      </tr>
      <tr>
        <th>Kategori Barang</th>
        <td>{{ $barang->kategori->kategori_nama }}</td>
      </tr>
      <tr>
        <th>Kode Barang</th>
        <td>{{ $barang->barang_kode }}</td>
      </tr>
      <tr>
        <th>Nama Barang</th>
        <td>{{ $barang->barang_nama }}</td>
      </tr>
      @if (auth()->user()->level->level_nama != 'Member')
      <tr>
        <th>Harga Beli</th>
        <td>{{ $barang->harga_beli }}</td>
      </tr>
      <tr>
        <th>Harga Jual</th>
        <td>{{ $barang->harga_jual }}</td>
      </tr>
      @else
      <tr>
        <th>Harga</th>
        <td>{{ $barang->harga_jual }}</td>
      </tr>
      @endif
      <tr>
        <th>Gambar</th>
        <td><img src="{{asset('storage/barangImg/'.$barang->image)}}" alt=""></td>
      </tr>
    </table>
    @endempty
    <a href="{{ url('barang') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
  </div>
</div>
@endsection
@push('css')
@endpush
@push('js')
@endpush