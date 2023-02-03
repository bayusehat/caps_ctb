<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Exports\CtbReport;
use App\Exports\ObcReport;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class ReportController extends Controller
{
    public function report_agent(Request $request)
    {
        $tgl_awal = $request->input('tgl_awal');
        $tgl_akhir = $request->input('tgl_akhir');
        if($tgl_awal != '' && $tgl_akhir != ''){
            $rep = DB::select("SELECT USER_CTB AGENT, COUNT(*) TOTAL_WO,
            SUM(CASE WHEN TGL_CALL IS NOT NULL THEN 1 ELSE 0 END) TOTAL_CALL,
            SUM(CASE WHEN HASIL_CALL = 25 THEN 1 ELSE 0 END) BERHENTI_BERLANGGANAN,
            SUM(CASE WHEN HASIL_CALL = 4 THEN 1 ELSE 0 END) PAKET_EXISTING,
            SUM(CASE WHEN HASIL_CALL != 25 AND HASIL_CALL != 4 AND HASIL_CALL != 27 AND HASIL_CALL != 26 THEN 1 ELSE 0 END) PAKET_RETENSI,
            SUM(CASE WHEN HASIL_CALL = 27 THEN 1 ELSE 0 END) FOLLOW_UP,
            SUM(CASE WHEN HASIL_CALL = 26 THEN 1 ELSE 0 END) NOT_CONTACTED,
            SUM(CASE WHEN HASIL_MC = 1 THEN 1 ELSE 0 END) MC_SUKSES,
            SUM(CASE WHEN HASIL_MC = 2 THEN 1 ELSE 0 END) MC_ANOMALI,
            SUM(CASE WHEN HASIL_MC = 3 THEN 1 ELSE 0 END) MC_GAGAL,
            COUNT(*) - SUM(CASE WHEN TGL_CALL IS NOT NULL THEN 1 ELSE 0 END) NOT_CALLED
            FROM CTB_FORM WHERE DELETED = 0 AND USER_CTB != 'ctb_admin' AND CREATED BETWEEN '$tgl_awal 00:00:00'  AND '$tgl_akhir 23:59:59' GROUP BY USER_CTB");
        }else{
            $tgl_awal = date('Y-m-01');
            $tgl_akhir = date('Y-m-d');
            $rep = DB::select("SELECT USER_CTB AGENT, COUNT(*) TOTAL_WO,
            SUM(CASE WHEN TGL_CALL IS NOT NULL THEN 1 ELSE 0 END) TOTAL_CALL,
            SUM(CASE WHEN HASIL_CALL = 25 THEN 1 ELSE 0 END) BERHENTI_BERLANGGANAN,
            SUM(CASE WHEN HASIL_CALL = 4 THEN 1 ELSE 0 END) PAKET_EXISTING,
            SUM(CASE WHEN HASIL_CALL != 25 AND HASIL_CALL != 4 AND HASIL_CALL != 27 AND HASIL_CALL != 26 THEN 1 ELSE 0 END) PAKET_RETENSI,
            SUM(CASE WHEN HASIL_CALL = 27 THEN 1 ELSE 0 END) FOLLOW_UP,
            SUM(CASE WHEN HASIL_CALL = 26 THEN 1 ELSE 0 END) NOT_CONTACTED,
            SUM(CASE WHEN HASIL_MC = 1 THEN 1 ELSE 0 END) MC_SUKSES,
            SUM(CASE WHEN HASIL_MC = 2 THEN 1 ELSE 0 END) MC_ANOMALI,
            SUM(CASE WHEN HASIL_MC = 3 THEN 1 ELSE 0 END) MC_GAGAL,
            COUNT(*) - SUM(CASE WHEN TGL_CALL IS NOT NULL THEN 1 ELSE 0 END) NOT_CALLED
            FROM CTB_FORM WHERE DELETED = 0 AND USER_CTB != 'ctb_admin' AND CREATED BETWEEN '$tgl_awal 00:00:00'  AND '$tgl_akhir 23:59:59' GROUP BY USER_CTB");
        }

            $data = [
                'title'   => 'Report Agent CTB',
                'content' => 'report.report_agent',
                'ctb'     => $rep
            ];

        return view('layout.index',['data' => $data]);
    }

    public function report_obc(Request $request)
    {
        $tgl_awal = $request->input('tgl_awal');
        $tgl_akhir = $request->input('tgl_akhir');
        if($tgl_awal != '' && $tgl_akhir != ''){
            $rep = DB::select("SELECT CASE WHEN USER_OBC IS NULL THEN 'NO PLOT' ELSE USER_OBC END AGENT, COUNT(*) TOTAL_WO,
            SUM(CASE WHEN TGL_CALL IS NOT NULL THEN 1 ELSE 0 END) TOTAL_CALL,
            SUM(CASE WHEN HASIL_CALL = 25 THEN 1 ELSE 0 END) BERHENTI_BERLANGGANAN,
            SUM(CASE WHEN HASIL_CALL = 4 THEN 1 ELSE 0 END) PAKET_EXISTING,
            SUM(CASE WHEN HASIL_CALL != 25 AND HASIL_CALL != 4 AND HASIL_CALL != 27 AND HASIL_CALL != 26 THEN 1 ELSE 0 END) PAKET_RETENSI,
            SUM(CASE WHEN HASIL_CALL = 27 THEN 1 ELSE 0 END) FOLLOW_UP,
            SUM(CASE WHEN HASIL_CALL = 26 THEN 1 ELSE 0 END) NOT_CONTACTED,
            SUM(CASE WHEN HASIL_MC = 1 THEN 1 ELSE 0 END) MC_SUKSES,
            SUM(CASE WHEN HASIL_MC = 2 THEN 1 ELSE 0 END) MC_ANOMALI,
            SUM(CASE WHEN HASIL_MC = 3 THEN 1 ELSE 0 END) MC_GAGAL,
            COUNT(*) - SUM(CASE WHEN TGL_CALL IS NOT NULL THEN 1 ELSE 0 END) NOT_CALLED
            FROM CTB_FORM WHERE DELETED = 0 AND USER_CTB != 'ctb_admin' AND TGL_CALL BETWEEN '$tgl_awal 00:00:00'  AND '$tgl_akhir 23:59:59' GROUP BY USER_OBC ORDER BY TOTAL_WO DESC");
        }else{
            $rep = DB::select("SELECT CASE WHEN USER_OBC IS NULL THEN 'NO PLOT' ELSE USER_OBC END AGENT, COUNT(*) TOTAL_WO,
            SUM(CASE WHEN TGL_CALL IS NOT NULL THEN 1 ELSE 0 END) TOTAL_CALL,
            SUM(CASE WHEN HASIL_CALL = 25 THEN 1 ELSE 0 END) BERHENTI_BERLANGGANAN,
            SUM(CASE WHEN HASIL_CALL = 4 THEN 1 ELSE 0 END) PAKET_EXISTING,
            SUM(CASE WHEN HASIL_CALL != 25 AND HASIL_CALL != 4 AND HASIL_CALL != 27 AND HASIL_CALL != 26 THEN 1 ELSE 0 END) PAKET_RETENSI,
            SUM(CASE WHEN HASIL_CALL = 27 THEN 1 ELSE 0 END) FOLLOW_UP,
            SUM(CASE WHEN HASIL_CALL = 26 THEN 1 ELSE 0 END) NOT_CONTACTED,
            SUM(CASE WHEN HASIL_MC = 1 THEN 1 ELSE 0 END) MC_SUKSES,
            SUM(CASE WHEN HASIL_MC = 2 THEN 1 ELSE 0 END) MC_ANOMALI,
            SUM(CASE WHEN HASIL_MC = 3 THEN 1 ELSE 0 END) MC_GAGAL,
            COUNT(*) - SUM(CASE WHEN TGL_CALL IS NOT NULL THEN 1 ELSE 0 END) NOT_CALLED
            FROM CTB_FORM WHERE DELETED = 0 AND USER_CTB != 'ctb_admin' GROUP BY USER_OBC ORDER BY TOTAL_WO DESC");
        }
        

        $data = [
            'title'   => 'Report Agent OBC',
            'content' => 'report.report_agent',
            'ctb'     => $rep
        ];

        return view('layout.index',['data' => $data]);
    }

    public function reportDetail($jenis_agent,$agent,$hasil_call)
    { 
        $response['data'] = [];
        if($jenis_agent == 'ctb'){
            $query = DB::select("SELECT * FROM CTB_FORM WHERE USER_CTB = '$agent' AND HASIL_CALL = $hasil_call");
        }else{
            $query = DB::select("SELECT * FROM CTB_FORM WHERE USER_CALL = '$agent' AND HASIL_CALL = $hasil_call");
        }
    }

    public function detailReport(Request $request)
    {
        $user = $request->input('user');
        $paket = $request->input('paket');
        $tgl_awal = $request->input('tgl_awal');
        $tgl_akhir = $request->input('tgl_akhir');
        $flag = $request->input('flag');

        if($tgl_awal != null){
            $rangetgl = "TGL_CALL BETWEEN '$tgl_awal 00:00:00'  AND '$tgl_akhir 23:59:59'";
        }else{
            $rangetgl = "1 = 1";
        }

        if($flag == 'agent'){
            $usr = 'user_ctb';
        }else{
            $usr = 'user_obc';
        }

        if($paket == 'TW'){
            $status = 'TOTAL WO';
            $inquery = "$usr = '$user'";
        }elseif($paket == 'TC'){
            $status = 'TOTAL CALL';
            $inquery = "$usr = '$user' AND TGL_CALL IS NOT NULL";
        }elseif($paket == 'PR'){
            $status = 'PAKET RETENSI';
            $inquery = "$usr = '$user' AND HASIL_CALL != 25 AND HASIL_CALL != 4 AND HASIL_CALL != 27 AND HASIL_CALL != 26";
        }elseif($paket == 'PE'){
            $status = 'PAKET EKSISTING';
            $inquery = "$usr = '$user' AND HASIL_CALL = 4";
        }elseif($paket == 'BB'){
            $status = 'BERHENTI BERLANGGANAN';
            $inquery = "$usr = '$user' AND HASIL_CALL = 25";
        }elseif($paket == 'FU'){
            $status = 'FOLLOW UP';
            $inquery = "$usr = '$user' AND HASIL_CALL = 27";
        }elseif($paket == 'RN'){
            $status = 'RNA';
            $inquery = "$usr = '$user' AND HASIL_CALL = 26";
        }elseif($paket == 'SS'){
            $status = 'MC : SUKSES';
            $inquery = "$usr = '$user' AND HASIL_MC = 1";
        }elseif($paket == 'AM'){ 
            $status = 'MC : ANOMALI'; 
            $inquery = "$usr = '$user' AND HASIL_MC = 2";
        }elseif($paket == 'GG'){
            $status = 'MC : GAGAL';
            $inquery = "$usr = '$user' AND HASIL_MC = 3";
        }else{
            $status = 'NOT CALLED';
            $inquery = "$usr = '$user' AND TGL_CALL IS NULL";
        }

        $query = DB::select(DB::raw("
            SELECT ID,WITEL,ND_POTS,ND_INTERNET,NAMA_PELANGGAN,NO_HP,NO_KTP,PAKET_TERAKHIR,KETERANGAN_CTB,TGL_INPUT,USER_CTB,TGL_CALL,A.HASIL_CALL,A.HASIL_MC,B.HASIL_CARING, KETERANGAN_CALL, PIC_OBC, USER_OBC, TGL_MC, 
            CASE 
                WHEN HASIL_MC = 1 THEN 'SUKSES' 
                WHEN HASIL_MC = 2 THEN 'ANOMALI' 
                WHEN HASIL_MC = 3 THEN 'GAGAL'
            END HASIL_MC,
            KETERANGAN_MC,USER_OPLANG
            FROM ctb_form A LEFT JOIN CTB_HASIL_CARING B ON A.HASIL_CALL = B.ID_HASIL_CARING WHERE $inquery AND $rangetgl AND A.DELETED = 0
            "));

        $data = [
            'title' => 'Detail Report OBC',
            'content' => 'report.report_detail',
            'ctb' => $query,
            'status' => $status
        ];

        return view('layout.index',['data' =>  $data]);
    }

    public function downloadCtbReport(Request $request)
    {
        $user = $request->input('user');
        $paket = $request->input('paket');
        $tgl_awal = $request->input('tgl_awal');
        $tgl_akhir = $request->input('tgl_akhir');
        $flag = $request->input('flag');

        $columns = Schema::getColumnListing('ctb_form');
        return Excel::download(new CtbReport($user,$paket,$tgl_awal,$tgl_akhir,$columns,$flag), $user.'-'.$paket.'-'.date('YmdHis').'.xlsx');
    }

    public function downloadObcReport(Request $request)
    {
        $user = $request->input('user');
        $paket = $request->input('paket');
        $tgl_awal = $request->input('tgl_awal');
        $tgl_akhir = $request->input('tgl_akhir');
        $flag = $request->input('flag');

        $columns = Schema::getColumnListing('ctb_form');
        return Excel::download(new ObcReport($user,$paket,$tgl_awal,$tgl_akhir,$columns,$flag), $user.'-'.$paket.'-'.date('YmdHis').'.xlsx');
    }
}
 