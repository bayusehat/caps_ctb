<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use DataTables;

class HvcController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'HVC Caps List',
            'content' => 'hvc.hvc_view'
        ];
        return view('layout.index',['data' => $data]);
    }

    public function loadData(Request $request)
    {
        $response['data'] = [];
        $query = DB::select("SELECT CONCAT('0',case when substr(cp,1,2) = '62' then substr(cp,3) else cp end) newcp, * FROM HVC_CAPS WHERE HASIL_CARING = 'CAPS'");
        $no = 1;
        foreach ($query as $c) {
            $tgl_call = $c->tgl_call != null ? date('d/m/Y H:i',strtotime($c->tgl_call)) : '-';
            if($c->tgl_call == null){
                $usr = '<label class="badge badge-danger">Belum ada hasil call</label>';
            }else{
                $usr = '<label class="badge badge-success">Terupdate hasil call by : '.$c->user_call.'</label>';
            }
            if($c->hasil_call == 27){
                $action = '<a href="'.url('hvc/edit/'.$c->id).'" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Update</a>';
            }else if($c->tgl_call != null && $c->hasil_call == 26){
                $action =  '<a href="'.url('hvc/edit/'.$c->id).'" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Update</a>';
            }else if($c->tgl_call != null && $c->hasil_call != 26){
                $action =  '<i>No Action</i>';
            }else if($c->tgl_call != null && $c->hasil_call != 27){
                $action =  '<i>No Action</i>';
            }else if($c->tgl_call == null){
                $action =  '<a href="'.url('hvc/edit/'.$c->id).'" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Update</a>';
            }
            $response['data'][] = [
                $no++,
                $c->notel_net,
                $c->nama,
                $c->newcp,
                $c->witel,
                $tgl_call,
                $usr,
                $action
            ];
        }

        return response($response);
    }

    public function detailHvc($id)
    {
        $data = [
            'title' => 'Update Data Call HVC ',
            'content' => 'hvc.hvc_create',
            'hvc' => DB::select("SELECT CONCAT('0',case when substr(cp,1,2) = '62' then substr(cp,3) else cp end) newcp,* FROM hvc_caps WHERE ID = $id"),
            'hasil_caring' => DB::select('SELECT * FROM CTB_HASIL_CARING WHERE DELETED = 0')
        ];

        return view('layout.index',['data' => $data]);
    }

    public function updateHvc(Request $request, $id)
    {
        $rules = [
            'hasil_call' => 'required',
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails())
            return redirect()->back()->withErrors($isValid->errors());

        $data = [
            'hasil_call' =>  $request->input('hasil_call'),
            'keterangan_call' => $request->input('keterangan_call'),
            'tgl_call' => date('Y-m-d H:i:s'),
            'user_call' => session('username'),
            'updated' => date('Y-m-d H:i:s')
        ];

        $update = DB::table('hvc_caps')->where('id',$id)->update($data);
        if($update)
            return redirect('hvc')->with('success','Berhasil mengubah data HVC Caps');

        return redirect()->back()->with('error','Gagal mengubah data HVC Caps');
    }
}
