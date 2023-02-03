<h1 class="h3 mb-2 text-gray-800">OBC</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Call {{ $status }}</h6>
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
                    <th>ND POTS</th>
                    <th>ND INTERNET</th>
                    <th>NAMA PELANGGAN</th>
                    <th>NO HP</th>
                    <th>WITEL</th>
                    <th>TANGGAL INPUT</th>
                    <th>TANGGAL CALL</th>
                    <th>STATUS</th>
                    <th>ACTION</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($ctb as $i => $c)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $c->nd_pots }}</td>
                        <td>{{ $c->nd_internet }}</td>
                        <td>{{ $c->nama_pelanggan }}</td>
                        <td>{{ $c->no_hp }}5</td>
                        <td>{{ $c->witel }}</td>
                        <td>{{ date('d/m/Y H:i',strtotime($c->tgl_input)) }}</td>
                        <td>{{ date('d/m/Y H:i',strtotime($c->tgl_call)) }}</td>
                        <td>
                            @php
                                if($c->tgl_call == null){
                                    echo '<label class="badge badge-danger">Belum ada hasil call</label>';
                                }else{
                                    echo '<label class="badge badge-success">Terupdate hasil call by : '.$c->user_obc.'</label>';
                                }
                            @endphp
                        </td>
                        <td>
                            @php
                                if($c->hasil_call == 27){ 
                                    echo '<a href="'.url('obc/edit/'.$c->id).'" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Update</a>';
                                }elseif($c->tgl_call != null){
                                   echo '<i>No Action</i>';
                                }else{
                                    echo '<a href="'.url('obc/edit/'.$c->id).'" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Update</a>';
                                }
                            @endphp
                        </td>
                    </tr>
                @endforeach
              </tbody>
            </table>
        </div>
    </div>
</div>