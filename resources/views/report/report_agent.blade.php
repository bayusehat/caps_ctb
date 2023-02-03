<h1 class="h3 mb-2 text-gray-800">REPORT AGENT</h1>
<!-- DataTales Example -->
@php
    $tgl_akhir = isset($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : '';
    $tgl_awal  = isset($_GET['tgl_awal']) ? $_GET['tgl_awal'] : '';

   if(request()->segment(2) == 'agent'){
        $url = 'report/ctb/dowload';
        $flag = 'agent';
   }else{
        $url = 'report/obc/dowload';
        $flag = 'obc';
   }
@endphp
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Report</h6>
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
        <form action="{{ url()->current() }}" method="get">
            <div class="row">
                <div class="col-md-3 col-sm-12">
                    <input type="text" name="tgl_awal" class="form-control datepicker" id="tgl_awal" placeholder="Tanggal Awal" value="{{ $tgl_awal }}" autocomplete="off">
                </div>
                <div class="col-md-3 col-sm-12">
                    <input type="text" name="tgl_akhir" class="form-control datepicker" id="tgl_akhir" placeholder="Tanggal Akhir" value="{{ $tgl_akhir }}" autocomplete="off">
                </div>
                <div class="col-md-3 col-sm-12">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-sync"></i> Reload</button>
                </div>
                <div class="col-md-3 col-sm-12">
                    <a href="{{ url()->current() }}" class="btn btn-success float-right"><i class="fas fa-sync"></i> Reset</a>
                </div>
            </div>
        </form>
    <hr>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">
              <thead>
                <tr>
                    <th rowspan="2">#</th>
                    <th rowspan="2">AGENT</th>
                    <th rowspan="2">TOTAL WO</th>
                    <th rowspan="2">TOTAL CALLED</th>
                    <th colspan="4" align="center">CONTACTED</th>
                    <th rowspan="2">RNA</th>
                    <th colspan="3" align="center">PROSES MC</th>
                    <th rowspan="2">NOT CALLED</th>
                </tr>
                <tr>
                    <th>PAKET RETENSI</th>
                    <th>PAKET EKSISTING</th>
                    <th>BERHENTI BERLANGGANAN</th>
                    <th>FOLLOW UP</th>
                    <th>SUKSES</th>
                    <th>ANOMALI</th>
                    <th>GAGAL</th>
                </tr>
              </thead>
              <tbody>
                @php
                    $total_wo = $total_call = $paket_retensi = $paket_existing = $berhenti_berlangganan = $follow_up = $not_contacted = $mc_sukses = $mc_anomali = $mc_gagal = $not_called = 0;
                @endphp
                @foreach ($ctb as $i => $v)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $v->agent }}</td>
                        <td align="right"><a href="{{ url($url.'?user='.$v->agent.'&paket=TW&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&flag='.$flag) }}">{{ $v->total_wo }}</a></td>
                        <td align="right"><a href="{{ url($url.'?user='.$v->agent.'&paket=TC&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&flag='.$flag) }}">{{ $v->total_call }}</a></td>
                        <td align="right"><a href="{{ url($url.'?user='.$v->agent.'&paket=PR&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&flag='.$flag) }}">{{ $v->paket_retensi }}</a></td>
                        <td align="right"><a href="{{ url($url.'?user='.$v->agent.'&paket=PE&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&flag='.$flag) }}">{{ $v->paket_existing }}</a></td>
                        <td align="right"><a href="{{ url($url.'?user='.$v->agent.'&paket=BB&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&flag='.$flag) }}">{{ $v->berhenti_berlangganan }}</a></td>
                        <td align="right"><a href="{{ url($url.'?user='.$v->agent.'&paket=FU&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&flag='.$flag) }}">{{ $v->follow_up }}</a></td>
                        <td align="right"><a href="{{ url($url.'?user='.$v->agent.'&paket=RN&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&flag='.$flag) }}">{{ $v->not_contacted }}</a></td>
                        <td align="right"><a href="{{ url($url.'?user='.$v->agent.'&paket=SS&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&flag='.$flag) }}">{{ $v->mc_sukses }}</a></td>
                        <td align="right"><a href="{{ url($url.'?user='.$v->agent.'&paket=AM&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&flag='.$flag) }}">{{ $v->mc_anomali }}</a></td>
                        <td align="right"><a href="{{ url($url.'?user='.$v->agent.'&paket=GG&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&flag='.$flag) }}">{{ $v->mc_gagal }}</a></td>
                        <td align="right"><a href="{{ url($url.'?user='.$v->agent.'&paket=NC&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&flag='.$flag) }}">{{ $v->not_called }}</a></td>
                    </tr>
                    @php
                        $total_wo += $v->total_wo;
                        $total_call += $v->total_call;
                        $paket_retensi += $v->paket_retensi;
                        $paket_existing += $v->paket_existing;
                        $berhenti_berlangganan += $v->berhenti_berlangganan;
                        $follow_up += $v->follow_up;
                        $not_contacted += $v->not_contacted;
                        $mc_sukses += $v->mc_sukses;
                        $mc_anomali += $v->mc_anomali;
                        $mc_gagal += $v->mc_gagal;
                        $not_called += $v->not_called;
                    @endphp
                @endforeach
              </tbody>
              <tfoot>
                  <tr>
                        <th colspan="2">TOTAL</th>
                        <th align="right"><a href="{{ url($url.'?user=all&paket=TW&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&flag='.$flag) }}">{{ $total_wo }}</a></th>
                        <th align="right"><a href="{{ url($url.'?user=all&paket=TC&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&flag='.$flag) }}">{{ $total_call }}</a></th>
                        <th align="right"><a href="{{ url($url.'?user=all&paket=PR&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&flag='.$flag) }}">{{ $paket_retensi }}</a></th>
                        <th align="right"><a href="{{ url($url.'?user=all&paket=PE&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&flag='.$flag) }}">{{ $paket_existing }}</a></th>
                        <th align="right"><a href="{{ url($url.'?user=all&paket=BB&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&flag='.$flag) }}">{{ $berhenti_berlangganan }}</a></th>
                        <th align="right"><a href="{{ url($url.'?user=all&paket=FU&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&flag='.$flag) }}">{{ $follow_up }}</a></th>
                        <th align="right"><a href="{{ url($url.'?user=all&paket=RN&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&flag='.$flag) }}">{{ $not_contacted }}</a></th>
                        <th align="right"><a href="{{ url($url.'?user=all&paket=SS&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&flag='.$flag) }}">{{ $mc_sukses }}</a></th>
                        <th align="right"><a href="{{ url($url.'?user=all&paket=AM&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&flag='.$flag) }}">{{ $mc_anomali }}</a></th>
                        <th align="right"><a href="{{ url($url.'?user=all&paket=GG&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&flag='.$flag) }}">{{ $mc_gagal }}</a></th>
                        <th align="right"><a href="{{ url($url.'?user=all&paket=NC&tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&flag='.$flag) }}">{{ $not_called }}</a></th>
                  </tr>
              </tfoot>
            </table>
        </div>
    </div>
</div>

<script>
    $('#dataTables').DataTable({
        scrollX : true
    });
</script>