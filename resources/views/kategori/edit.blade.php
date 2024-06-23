@extends('layout.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ url('/kategori/' .$kategori->kategori_id) }}" class="form-horizontal">
        @csrf
        @method('PUT')
        <div class="form-group row">
            <label class="col-1 control-label col-form-label">Kode kategoi</label>
            <div class="col-11">
            <input type="text" class="form-control" id="kode_kategori" name="kode_kategori"
            value="{{ old('kode_kategori', ($kategori->kategori_kode)) }}" required>
            @error('kode_kategori')
            <small class="form-text text-danger">{{ $message }}</small>
            @enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-1 control-label col-form-label">Nama Kategori</label>
            <div class="col-11">
                <input type="text" class="form-control" id="nama_kategori" name="nama_kategori"
                value="{{ old('nama_kategori', ($kategori->kategori_name)) }}" required>
                @error('nama_kategori')
                <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-1 control-label col-form-label"></label>
        <div class="col-11">
            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
            <a class="btn btn-sm btn-default ml-1" href="{{ url('kategori') }}">Kembali</a>
        </div>
        </div>
        </form>
    </div>
    </div>
@endsection

@push('css')
@endpush
@push('js')
@endpush