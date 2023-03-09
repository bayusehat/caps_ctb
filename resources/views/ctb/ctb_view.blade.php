<h1 class="h3 mb-2 text-gray-800">CTB</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Master</h6>
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
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xl-12 mb-3">
                <a href="{{ url('ctb/create') }}" class="btn btn-success float-right"><i class="fas fa-plus"></i> Input data baru</a>
            </div>
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered display nowrap table-sm" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                    <th>#</th>
                    <th>ND POTS</th>
                    <th>ND INTERNET</th>
                    <th>NAMA PELANGGAN</th>
                    <th>NO HP</th>
                    <th>WITEL</th>
                    <th>TANGGAL INPUT</th>
                    <th>ACTION</th>
                </tr>
              </thead>
              <tbody>
                {{--  @foreach ($ctb as $i => $c)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $c->nd_pots }}</td>
                        <td>{{ $c->nd_internet }}</td>
                        <td>{{ $c->nama_pelanggan }}</td>
                        <td>{{ $c->no_hp }}5</td>
                        <td>{{ $c->witel }}</td>
                        <td>{{ date('d/m/Y H:i',strtotime($c->tgl_input)) }}</td>
                        <td>
                            <a href="{{ url('ctb/edit/'.$c->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                            <a href="{{ url('ctb/delete/'.$c->id) }}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                @endforeach  --}}
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
                url: "{{ url('ctb/load') }}",
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'GET'
            },
            columns: [
                { name: 'id', searchable: false, orderable: true, className: 'text-center' },
                { name: 'nd_pots'},
                { name: 'nd_internet'},
                { name: 'nama_pelanggan'},
                { name: 'no_hp'},
                { name: 'witel'},
                { name: 'tgl_input'},
                { name: 'action', searchable: false, orderable: false, className: 'text-center' }
            ],
            order: [[6, 'desc']],
            iDisplayInLength: 10 
        });
    }
</script>