@extends('layout.template') 
 
@section('content') 
  <div class="card card-outline card-primary"> 
      <div class="card-header"> 
        <h3 class="card-title">{{ $page->title }}</h3> 
        <div class="card-tools"> 
          <a class="btn btn-sm btn-primary mt-1" href="{{ url('user/create') }}">Tambah</a> 
        </div> 
      </div> 
      <div class="card-body"> 
        @if (session('success'))
        <div class="alert alert-success">{{session('success')}}</div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">{{session('error')}}</div>
        @endif
        <table class="table table-bordered table-striped table-hover table-sm" id="table_barang"> 
          <thead> 
            <tr><th>ID</th><th>Nama</th><th>TTL</th><th>Alamat</th><th>Aksi</th></tr> 
          </thead> 
      </table> 
    </div> 
  </div> 
@endsection 
 
@push('css') 
@endpush 
@push('js') 
  <script> 
    $(document).ready(function() { 
      var dataUser = $('#table_barang').DataTable({ 
          serverSide: true,     // serverSide: true, jika ingin menggunakan server side processing 
          ajax: { 
              "url": "{{ url('member/list') }}", 
              "dataType": "json", 
              "type": "POST",
            //   "data":function(d){
            //     d.level_id = $('#level_id').val();
            //   }
          }, 
          columns: [ 
            { 
             data: "DT_RowIndex", // nomor urut dari laravel datatable addIndexColumn()            
              className: "text-center", 
              orderable: false, 
              searchable: false     
            },{ 
              data: "nama",                
              className: "", 
              orderable: true,    // orderable: true, jika ingin kolom ini bisa diurutkan 
              searchable: true    // searchable: true, jika ingin kolom ini bisa dicari 
            },{ 
              data: "ttl",                
              className: "", 
              orderable: true,    // orderable: true, jika ingin kolom ini bisa diurutkan 
              searchable: true    // searchable: true, jika ingin kolom ini bisa dicari 
            },{ 
              data: "alamat",                
              className: "", 
              orderable: true,    // orderable: true, jika ingin kolom ini bisa diurutkan 
              searchable: true    // searchable: true, jika ingin kolom ini bisa dicari 
            },{ 
              data: "aksi",                
              className: "", 
              orderable: false,    // orderable: true, jika ingin kolom ini bisa diurutkan 
              searchable: false    // searchable: true, jika ingin kolom ini bisa dicari 
            } 
          ] 
      }); 
    //   $('#level_id').on('change', function(){
    //     dataUser.ajax.reload();
    //   });
    }); 
  </script> 
@endpush