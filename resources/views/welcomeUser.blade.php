@extends('layout.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        @empty($data)
        <div class="alert alert-danger alert-dismissible">
            <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
            Data yang Anda cari tidak ditemukan.
        </div>
        @else
        <table class="table table-bordered table-striped table-hover table-sm">
            <tr>
                <th>ID</th>
                <td>{{ $data['user_id'] }}</td>
            </tr>
            <tr>
                <th>Nama</th>
                <td>{{ $data->nama }}</td>
            </tr>
            <tr>
                <th>Username</th>
                <td>{{ $data->username }}</td>
            </tr>
            <tr>
                <th>Foto</th>
                <td> <img src="{{ asset('imgProfile/' .$data->foto) }}" height="15%" width="15%"></td>
            </tr>
        </table>
        @endempty
        </div>
    </div>
@endsection

@push('css')
@endpush
@push('js')
@endpush
