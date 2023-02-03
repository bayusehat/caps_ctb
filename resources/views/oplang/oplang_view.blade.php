<h1 class="h3 mb-2 text-gray-800">OPLANG</h1>
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
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                    <th>#</th>
                    <!-- <th>ND POTS</th> -->
                    <th>ND INTERNET</th>
                    <th>NAMA PELANGGAN</th>
                    <th>NO HP</th>
                    <th>WITEL</th>
                    <th>KETERANGAN HVC</th>
                    <th>TANGGAL INPUT</th>
                    <th>TANGGAL CALL</th>
                    <th>STATUS</th>
                    <th>TGL PSB</th>
                    <th>DENDA</th>
                    <th>ACTION</th>
                </tr>
              </thead>
              <tbody>
                {{--  @foreach ($ctb as $i => $c)
                    <tr>
                        <td>{{ ++$i }}</td>
                       <!--  <td>{{ $c->nd_pots }}</td> -->
                        <td>{{ $c->nd_internet }}</td>
                        <td>{{ $c->nama_pelanggan }}</td>
                        <td>{{ $c->no_hp }}5</td>
                        <td>{{ $c->witel }}</td>
                        <td>{{ date('d/m/Y H:i',strtotime($c->tgl_mc)) }}</td>
                        <td>{{ date('d/m/Y H:i',strtotime($c->tgl_call)) }}</td>
                        <td>
                            @php
                                if($c->tgl_mc == null){
                                    echo '<label class="badge badge-danger">Belum ada hasil mc</label>';
                                }else{
                                    echo '<label class="badge badge-success">Terupdate hasil mc by : '.$c->user_oplang.'</label>';
                                }
                            @endphp
                        </td>
                        <td>
                            @php
                                $tgl_lis = $c->tgl_psb != null ? date('d/m/Y H:i',strtotime($c->tgl_psb)) : '-'; 
                            @endphp
                            {{ $tgl_lis }}
                        </td>
                        <td>
                             @php
                                $tanggal = date('Ymd',strtotime($c->tgl_psb));
                                $acuan = date('Ymd',strtotime('2020-11-05'));
                                if($c->tgl_psb != NULL){ 
                                    echo '<label class="badge badge-secondary">'.date('d/m/Y H:i',strtotime($c->tgl_psb)).'</label><br>';
                                    if($tanggal > $acuan){
                                        echo '<label class="badge badge-danger">(001) Denda pengakhiran berlaku</label>';
                                    }else{
                                        echo '<label class="badge badge-primary">(002) Denda pengakhiran tidak berlaku</label>';
                                    }
                                }else{
                                    echo '<label class="badge badge-warning">(003) Tanggal PSB belum diketahui</label>';
                                }
                            @endphp
                        </td>
                        <td>
                            <a href="{{ url('oplang/edit/'.$c->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Update</a>
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
                url: "{{ url('oplang/load') }}",
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
                { name: 'hvc'},
                { name: 'tgl_input'},
                { name: 'tgl_call'},
                { name: 'status'},
                { name: 'tgl_psb'},
                { name: 'denda'},
                { name: 'action', searchable: false, orderable: false, className: 'text-center' }
            ],
            order: [[6, 'desc']],
            iDisplayInLength: 10 
        });
    }
</script>