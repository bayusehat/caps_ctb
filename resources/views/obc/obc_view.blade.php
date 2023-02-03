<h1 class="h3 mb-2 text-gray-800">OBC</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Call</h6>
    </div>
    <div class="card-body">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses!</strong> {{ Session::get('success')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <br>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> {{ Session::get('error')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="table-responsive">
            <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                    <th>#</th>
                    <!-- <th>ND POTS</th> -->
                    <th>ND INTERNET</th>
                    <th>NAMA PELANGGAN</th>
                    <th>NO HP</th>
                    <th>WITEL</th>
                    <th>TANGGAL CALL</th>
                    <th>STATUS</th>
                    <th>TGL PSB</th>
                    <th>DENDA</th>
                    <th>ACTION</th>
                </tr>
              </thead>
              <tbody>
               
              </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        loadData();
    })
    function loadData(){
        $('#dataTable').DataTable({
            asynchronous: true,
            processing: true, 
            destroy: true,
            ajax: {
                url: "{{ url('obc/load') }}",
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'GET'
            },
            columns: [
                { name: 'id', searchable: false, orderable: true, className: 'text-center' },
                { name: 'nd_internet'},
                { name: 'nama_pelanggan'},
                { name: 'no_hp'},
                { name: 'witel'},
                { name: 'tgl_call'},
                { name: 'status'},
                { name: 'tgl_psb'},
                { name: 'denda'},
                { name: 'action', searchable: false, orderable: false, className: 'text-center' }
            ],
            order: [[6, 'asc']],
            iDisplayInLength: 10 
        });
    }
</script>