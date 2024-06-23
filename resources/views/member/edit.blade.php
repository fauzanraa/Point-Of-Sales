@extends('layout.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ url('/member/' .$member->member_id) }}" class="form-horizontal">
        @csrf
        @method('PUT')
        <div class="form-group row">
            <label class="col-1 control-label col-form-label">Nama</label>
            <div class="col-11">
                <input type="text" class="form-control" id="nama_member" name="nama_member"
                value="{{ old('nama_member', ($member->nama)) }}" required>
                @error('nama_member')
                <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-1 control-label col-form-label">Tempat Tanggal Lahir</label>
            <div class="col-11">
            <input type="date" class="form-control" id="ttl_member" name="ttl_member"
            value="{{ old('ttl_member', date('Y-m-d', strtotime($member->ttl))) }}" required>
            @error('ttl_member')
            <small class="form-text text-danger">{{ $message }}</small>
            @enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-1 control-label col-form-label">Alamat</label>
            <div class="col-11">
            <input type="text" class="form-control" id="alamat_member" name="alamat_member"
            value="{{ old('alamat_member', ($member->alamat)) }}" required>
            @error('alamat_member')
            <small class="form-text text-danger">{{ $message }}</small>
            @enderror
            </div>
        </div>
        <div class="form-group row">
            <label class="col-1 control-label col-form-label"></label>
        <div class="col-11">
            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
            <a class="btn btn-sm btn-default ml-1" href="{{ url('member') }}">Kembali</a>
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