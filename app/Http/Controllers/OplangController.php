<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Logs;
use DataTables;

class OplangController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data CTB Oplang',
            'content' => 'oplang.oplang_view',
            'ctb' => DB::select('SELECT * FROM CTB_FORM WHERE TGL_CALL IS NOT NULL ORDER BY TGL_INPUT DESC')
        ];

        return view('layout.index',['data' =>  $data]);
    }

    public function loadData(Request $request)
    {
        $response['data'] = [];
        $query = DB::select("select a.*, 'Under construction' kat_hvc from ctb_form a where TGL_CALL IS NOT NULL order by tgl_input desc");
        

        foreach ($query as $i => $c) {
            if($c->tgl_mc == null){
                $st_mc = '<label class="badge badge-danger">Belum ada hasil mc</label>';
            }else{
                $st_mc = '<label class="badge badge-success">Terupdate hasil mc by : '.$c->user_oplang.'</label>';
            }
            $tgl_lis = $c->tgl_psb != null ? date('d/m/Y H:i',strtotime($c->tgl_psb)) : '-'; 
            $tanggal = date('Ymd',strtotime($c->tgl_psb));
            $acuan = date('Ymd',strtotime('2020-11-05'));
            if($c->tgl_psb != NULL){ 
                $st_tsb = '<label class="badge badge-secondary">'.date('d/m/Y H:i',strtotime($c->tgl_psb)).'</label><br>';
                if($this->calculateYear($tanggal) < 1){
                    $st_tsb = '<label class="badge badge-danger">(001) Denda pengakhiran berlaku</label>';
                }else{
                    $st_tsb = '<label class="badge badge-primary">(002) Denda pengakhiran tidak berlaku</label>';
                }
            }else{
                $st_tsb = '<label class="badge badge-warning">(003) Tanggal PSB belum diketahui</label>';
            }
            $response['data'][] = [
                ++$i,
                $c->nd_internet,
                $c->nama_pelanggan,
                $c->no_hp,
                $c->witel,
                $c->kat_hvc,
                date('d/m/Y H:i',strtotime($c->tgl_mc)),
                date('d/m/Y H:i',strtotime($c->tgl_call)),
                $st_mc,
                $tgl_lis,
                $st_tsb,
                '<a href="'.url('oplang/edit/'.$c->id).'" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Update</a>'
            ];
        }

        return response($response);
    }

    // public function loadData(Request $request)
    // {
    //     // $datatable = DataTables::of(DB::select('SELECT id,nd_pots,nd_internet,nama_pelanggan,no_hp,witel,tgl_input,tgl_call,hasil_call,user_oplang,tgl_mc FROM CTB_FORM WHERE TGL_CALL IS NOT NULL ORDER BY TGL_INPUT DESC'))
    //     // ->addIndexColumn()
    //     // ->addColumn('action',function($row){
    //     //     return '<a href="'.url('oplang/edit/'.$row->id).'" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Update</a>';
    //     // })
    //     // ->addColumn('denda',function($row){
    //     // 	$tanggal = date('d',strtotime($row->tgl_input));
    //     // 	if($tanggal > 5){
    //     // 		return '<label class="badge badge-danger">Denda pengakhiran berlaku</label>';
    //     // 	}else{
    //     // 		return '<label class="badge badge-info">Denda pengakhiran tidak berlaku</label>';
    //     // 	}
    //     // })
    //     // ->editColumn('hasil_call',function($row){
    //     //     if($row->tgl_mc == null){
    //     //         $status  =  '<label class="badge badge-danger">Belum ada hasil mc</label>';
    //     //     }else{
    //     //         $status  =  '<label class="badge badge-success">Terupdate hasil mc by : '.$row->user_oplang.'</label>';
    //     //     }
    //     // })
    //     // ->rawColumns(['action','hasil_call','denda'])
    //     // ->removeColumn(['user_oplang','tgl_mc'])
    //     // ->make(true);

    //     // return $datatable;
    //     $whereLike = [
    //         'create_log',
    //         'nama',
    //         'ip_log',
    //         'keterangan_log',
    //     ];

    //     $start  = $request->input('start');
    //     $length = $request->input('length');
    //     $order  = $whereLike[$request->input('order.0.column')];
    //     $dir    = $request->input('order.0.dir');
    //     $search = $request->input('search.value');

    //     $totalData = DB::select('select nd_internet,nama_pelanggan, no_hp, witel, tgl_input, tgl_call, tgl_psb, hasil_call from ctb_form')->count();
    //     if (empty($search)) {
    //         $queryData = Log::join('eberkas_login','eberkas_login.id','=','eberkas_log.id_login')
    //             ->offset($start)
    //             ->limit($length)
    //             ->orderBy($order, $dir)
    //             ->get();
    //         $totalFiltered = Log::count();
    //     } else {
    //         $queryData = Log::join('eberkas_login','eberkas_login.id','=','eberkas_log.id_login')
    //             ->where(function($query) use ($search) {
    //                 $query->where('eberkas_login.nama', 'like', "%{$search}%");
    //                 $query->orWhere('keterangan_log','like',"%{$search}%");
    //             })
    //             ->offset($start)
    //             ->limit($length)
    //             ->orderBy($order, $dir)
    //             ->get();
    //         $totalFiltered = Log::join('eberkas_login','eberkas_login.id','=','eberkas_log.id_login')
    //             ->where(function($query) use ($search) {
    //                 $query->where('eberkas_login.nama', 'like', "%{$search}%");
    //                 $query->orWhere('keterangan_log','like',"%{$search}%");
    //             })
    //             ->count();
    //     }

    //     $response['data'] = [];
    //     if($queryData <> FALSE) {
    //         $nomor = $start + 1;
    //         foreach ($queryData as $val) {
    //                 $response['data'][] = [
    //                     $nomor,
    //                     $val->nama,
    //                     $val->ip_log,
    //                     $val->keterangan_log,
    //                     date('d F Y H:i',strtotime($val->create_log))
    //                 ];
    //             $nomor++;
    //         }
    //     }

    //     $response['recordsTotal'] = 0;
    //     if ($totalData <> FALSE) {
    //         $response['recordsTotal'] = $totalData;
    //     }

    //     $response['recordsFiltered'] = 0;
    //     if ($totalFiltered <> FALSE) {
    //         $response['recordsFiltered'] = $totalFiltered;
    //     }

    //     return response()->json($response);
    // }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit data CTB setelah Call',
            'content' => 'oplang.oplang_create',
            'ctb' => DB::select('SELECT A.*,B.HASIL_CARING FROM CTB_FORM a LEFT JOIN CTB_HASIL_CARING B ON A.HASIL_CALL = B.ID_HASIL_CARING WHERE ID = '.$id),
            'hasil_caring' => DB::select('SELECT * FROM CTB_HASIL_CARING WHERE DELETED = 0'),
            'reason' => DB::select('SELECT * FROM CTB_REASON')
        ];
        
        return view('layout.index',['data' => $data]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'hasil_mc' => 'required',
            'hasil_caring' => 'required',
            'reason_mc' => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return redirect()->back()->withErrors($isValid->errors());
        }else{
            $row = DB::select('select * from ctb_form where id = '.$id);
            if($row[0]->hasil_call != $request->input('hasil_caring')){
                $user_obc = session('username');
            }else{
                $user_obc = $row[0]->user_obc;
            }
            $data = [
                'hasil_call' => $request->input('hasil_caring'),
                'hasil_mc' => $request->input('hasil_mc'),
                'nomor_permintaan' => $request->input('nomor_permintaan'),
                'keterangan_mc' => $request->input('keterangan_mc'),
                'reason_mc' => $request->input('reason_mc'),
                'tgl_mc' => date('Y-m-d H:i:s'),
                'user_obc' => $user_obc,
                'user_oplang' => session('username'),
                'updated' => date('Y-m-d H:i:s')
            ];

            $update = DB::table('ctb_form')->where('id',$id)->update($data);

            if($update){
                Logs::log('edit','Memperbarui data CTB hasil mc Oplang','UDCTB',$id,$request->input('hasil_caring'));
                return redirect('oplang')->with('success','Data CTB hasil mc berhasil ditambahkan');
            }else{
                return redirect()->back()->with('error','Data CTB hasil mc gagal ditambahkan');
            }
        }
    }

    public function calculateYear($tgl_psb)
    {
        $date1 = $tgl_psb;
        $date2 = date('Y-m-d');

        $diff = abs(strtotime($date2) - strtotime($date1));

        $years = floor($diff / (365*60*60*24));

        return $years;
    }
}
