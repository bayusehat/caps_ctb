<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;

class PrepaidController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data Indihome Prepaid',
            'content' => 'prepaid.prepaid_view'
        ];

        return view('layout.index',['data' => $data]);
    }

    public function loadData()
    {
        $response['data'] = [];

        $query = DB::select("SELECT A.*,B.WITEL_CBD WITEL FROM CTB_PREPAID A LEFT JOIN P_M_WILAYAH B ON A.CWITEL = B.CWITEL ORDER BY CREATED DESC");

        foreach ($query as $i => $v) {
            if($v->status_prepaid == 'TIDAK ADA'){
                $action = '<a href="'.url('prepaid/edit/'.$v->id_prepaid).'" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Update Call</a>';
            }else{
                $action = '';
            }

            $status_caring = $v->hasil_voc != null ? '<label class="badge badge-success">Terupdate hasil call by : '.$v->user_obc.'</label>' : '<label class="badge badge-danger">Belum ada hasil call</label>';
            $response['data'][] = [
                ++$i,
                $v->nd,
                $v->cust_name,
                $v->cp_num,
                $v->witel,
                $v->status_prepaid,
                $status_caring,
                $action
            ];
        }

        return response($response);
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit data Indihome Prepaid Call',
            'content' => 'prepaid.prepaid_edit',
            'pp' => DB::select("SELECT A.*, B.WITEL_CBD WITEL FROM CTB_PREPAID A LEFT JOIN P_M_WILAYAH B ON A.CWITEL = B.CWITEL WHERE ID_PREPAID = $id"),
            'voc' => DB::select("SELECT * FROM CTB_VOC WHERE DELETED = 0")
        ];

        return view('layout.index',['data'=> $data]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'hasil_voc' => 'required',
            'pic_voc' => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return redirect()->back()->withInput()->withErrors($isValid->errors());
        }else{
            $data = [
                'hasil_voc' => $request->input('hasil_voc'),
                'pic_voc' => $request->input('pic_voc'),
                'status_date' => date('Y-m-d H:i:s'),
                'user_obc' => session('username')
            ];

            $update = DB::table('ctb_prepaid')->where('id_prepaid',$id)->update($data);

            if($update){
                return redirect('prepaid')->with('success','Berhasil memperbarui Indihome Prepaid');
            }else{
                return redirect()->back()->with('error','Gagal memperbarui Indihome Prepaid');
            }
        }
    }
}
