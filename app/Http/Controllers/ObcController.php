<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Logs;
use Validator;
use DataTables;

class ObcController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data CTB for OBC',
            'content' => 'obc.obc_view',
            // 'ctb' => DB::select('select * from ctb_form where deleted = 0 order by tgl_input desc')
        ];

        return view('layout.index',['data' => $data]);
    }

    public function loadData(Request $request)
    {   
        $response['data'] = [];
        if(session('username')){
            $user = session('profil') == '4' ? "1=1" : "user_obc = '".session('username')."'";
        }

        $query = DB::select("select * from ctb_form where deleted = 0 and $user and tgl_call is null order by tgl_input desc");
        foreach ($query as $i => $c) {
            $tgl_call = $c->tgl_call != null ? date('d/m/Y H:i',strtotime($c->tgl_call)) : '-'; 
            if($c->tgl_call == null){
                $tcall = '<label class="badge badge-danger">Belum ada hasil call</label>';
            }else{
                $tcall = '<label class="badge badge-success">Terupdate hasil call by : '.$c->user_obc.'</label>';
            }
            $tgl_lis = $c->tgl_psb != null ? date('d/m/Y',strtotime($c->tgl_psb)) : '-';

            $tanggal = date('Ymd',strtotime($c->tgl_psb));
            $acuan = date('Ymd',strtotime('2020-11-05'));
            if($c->tgl_psb != NULL){ 
                $stts = '<label class="badge badge-secondary">'.date('d/m/Y H:i',strtotime($c->tgl_psb)).'</label><br>';
                if($this->calculateYear($c->tgl_psb) < 1){
                    $stts = '<label class="badge badge-danger">(001) Denda pengakhiran berlaku</label>';
                }else{
                    $stts = '<label class="badge badge-primary">(002) Denda pengakhiran tidak berlaku</label>';
                }
            }else{
                $stts = '<label class="badge badge-warning">(003) Tanggal PSB belum diketahui</label>';
            }

            if($c->hasil_call == 27){ 
                $act = '<a href="'.url('obc/edit/'.$c->id).'" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Update</a>';
            }else if($c->tgl_call != null && $c->hasil_call == 26){
                $act = '<a href="'.url('obc/edit/'.$c->id).'" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Update</a>';
            }else if($c->tgl_call != null && $c->hasil_call != 26){
                $act = '<i>No Action</i>';
            }else if($c->tgl_call != null && $c->hasil_call != 27){
                $act = '<i>No Action</i>';
            }else if($c->tgl_call == null){
                $act = '<a href="'.url('obc/edit/'.$c->id).'" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Update</a>';
            }
            $response['data'][] = [
                ++$i,
                $c->nd_internet,
                $c->nama_pelanggan,
                $c->no_hp,
                $c->witel,
                $tgl_call,
                $tcall,
                $tgl_lis,
                $stts,
                $act,
            ];
        }

        return response($response);
    }

    // public function loadData(Request $request)
    // {
    //     $datable = DataTables::of(DB::select('select id,nd_pots,nd_internet,nama_pelanggan,no_hp,witel,tgl_input,tgl_call,hasil_call,user_obc from ctb_form where deleted = 0 order by tgl_input desc'))
    //     ->addIndexColumn()
    //     ->addColumn('action',function($row){
    //         if($row->hasil_call == 27){ 
    //             $btn =  '<a href="'.url('obc/edit/'.$row->id).'" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Update</a>';
    //         }elseif($row->tgl_call != null){
    //             $btn =  '<i>No Action</i>';
    //         }else{
    //             $btn = '<a href="'.url('obc/edit/'.$row->id).'" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Update</a>';
    //         }

    //         return $btn;
    //     })
    //     ->editColumn('hasil_call',function($row){
    //         if($row->tgl_call == null){
    //             $status =  '<label class="badge badge-danger">Belum ada hasil call</label>';
    //         }else{
    //             $status =  '<label class="badge badge-success">Terupdate hasil call by : '.$row->user_obc.'</label>';
    //         }

    //         return $status;
    //     })
    //     ->removeColumn('user_obc')
    //     ->rawColumns(['action','hasil_call'])
    //     ->make(true);
    //     return $datable;
    // }

    public function edit($id)
    {
        $data = [
            'title' => 'Update Data CTB for OBC',
            'content' => 'obc.obc_create',
            'ctb' => DB::select('SELECT * FROM CTB_FORM WHERE ID = '.$id),
            'hasil_caring' => DB::select('SELECT * FROM CTB_HASIL_CARING WHERE DELETED = 0')
        ];

        return view('layout.index',['data' => $data]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'hasil_call' => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return redirect()->back()->withErrors($isValid->errors());
        }else{
            $data = [
                'hasil_call' => $request->input('hasil_call'),
                'keterangan_call' => $request->input('keterangan_call'),
                'pic_obc' => $request->input('pic_obc'),
                'tgl_call' => date('Y-m-d H:i:s'),
                'user_obc' => session('username')
                // 'updated' => date('Y-m-d H:i:s')             
            ];

            $update = DB::table('ctb_form')->where('id',$id)->update($data);

            if($update){
                Logs::log('edit','Memperbarui data CTB hasil call OBC','UDCTB',$id,$request->input('hasil_call'));
                return redirect('obc')->with('success','Data CTB hasil call berhasil ditambahkan');
            }else{
                return redirect()->back()->with('error','Data CTB hasil call gagal ditambahkan');
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
