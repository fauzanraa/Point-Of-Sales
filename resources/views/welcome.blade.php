@extends('layout.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Halo, apa kabar</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            {!! $chart->container() !!}

            <div class="notif-validasi mt-5">
                <h5>User yang perlu divalidasi akunnya {{$notif->pluck('notif')->implode(',')}}</h5> 
            </div>

            <table class="table table-bordered table-striped table-hover table-sm" id="table_validasi"> 
                <thead> 
                    <tr><th>ID</th><th>Username</th><th>Nama</th><th>Status</th><th>Aksi</th></tr> 
                </thead> 
            </table>
        </div>
    </div>

    <script src="{{ $chart->cdn() }}"></script>

    {{$chart->script()}}

@endsection

@push('js') 
  <script> 
    $(document).ready(function() { 
      var dataUser = $('#table_validasi').DataTable({ 
          serverSide: true,
          ajax: { 
              "url": "{{ url('/list') }}", 
              "dataType": "json", 
              "type": "POST",
              "data":function(d){
                d.level_id = $('#level_id').val();
              }
          },    
          columns: [ 
            { 
             data: "DT_RowIndex", // nomor urut dari laravel datatable addIndexColumn()            
              className: "text-center", 
              orderable: false, 
              searchable: false     
            },{ 
              data: "username",                
              className: "", 
              orderable: true,    // orderable: true, jika ingin kolom ini bisa diurutkan 
              searchable: true    // searchable: true, jika ingin kolom ini bisa dicari 
            },{ 
              data: "nama",                
              className: "", 
              orderable: true,    // orderable: true, jika ingin kolom ini bisa diurutkan 
              searchable: true    // searchable: true, jika ingin kolom ini bisa dicari 
            },{ 
              data: "username_verified",                
              className: "", 
              orderable: false,    // orderable: true, jika ingin kolom ini bisa diurutkan 
              searchable: false    // searchable: true, jika ingin kolom ini bisa dicari
            },{ 
              data: "aksi",                
              className: "", 
              orderable: false,    // orderable: true, jika ingin kolom ini bisa diurutkan 
              searchable: false    // searchable: true, jika ingin kolom ini bisa dicari 
            } 
          ] 
      }); 
    }); 
  </script> 
@endpush