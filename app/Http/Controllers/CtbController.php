<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Logs;
use DataTables;

class CtbController extends Controller
{

    public function index()
    {
        $data = [
            'title' => 'Data CTB',
            'content' => 'ctb.ctb_view',
            // 'ctb' => DB::select('select * from ctb_form where deleted = 0')
        ];

        return view('layout.index',['data' => $data]);
    }

    public function loadData(Request $request)
    {
        $response['data'] = [];
        $query = DB::select('select * from ctb_form where deleted = 0');

        foreach ($query as $i => $c) {
            $response['data'][] = [
                ++$i,
                $c->nd_pots,
                $c->nd_internet ,
                $c->nama_pelanggan ,
                $c->no_hp ,
                $c->witel ,
                date('d/m/Y H:i',strtotime($c->tgl_input)), 
                '<a href="'.url('ctb/edit/'.$c->id).'" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                <a href="'.url('ctb/delete/'.$c->id) .'" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>'
            ];
        }

        return response($response);
    }

    public function create()
    {
        $data = [
            'title' => 'Input Data CTB',
            'content' => 'ctb.ctb_create',
            'witel' => DB::select("SELECT witel_cbd,cwitel from p_m_wilayah where reg = '5' and cwitel < 1000 order by witel_cbd")
        ];

        return view('layout.index',['data' => $data]);
    }

    public function insert(Request $request)
    {
        $rules = [
            // 'nd_pots'        => 'required_with_all:nd_internet',
            'nd_internet'    => 'required',
            'nama_pelanggan' => 'required',
            'no_hp'          => 'required',
            'paket_terakhir' => 'required'
        ];
        
        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return redirect()->back()->withInput()->withErrors($isValid->errors());
        }else{
            $data = [
                'witel'          => session('witel'),
                'nd_pots'        => $request->input('nd_pots'),
                'nd_internet'    => $request->input('nd_internet'),
                'nama_pelanggan' => $request->input('nama_pelanggan'),
                'no_hp'          => $request->input('no_hp'),
                'paket_terakhir' => $request->input('paket_terakhir'),
                'keterangan_ctb' => $request->input('keterangan_ctb'),
                'no_ktp'         => $request->input('no_ktp'),
                'periode'        => date('Ym'),
                'user_ctb'       => session('username'),
                'nama_bank'      => $request->input('nama_bank'),
                'no_rekening'    => $request->input('no_rekening'),
                'atas_nama'      => $request->input('atas_nama')
            ];

            $insert = DB::table('ctb_form')->insertGetId($data);
            if($insert){
                Logs::log('insert','Menambahkan data CTB','CDCTB',$insert,0);
                return redirect()->back()->with('success','Data berhasil disimpan!');
            }else{
                return redirect()->back()->with('error','Data gagal disimpan!');
            }
        }
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Data CTB',
            'content' => 'ctb.ctb_edit',
            'ctb' =>  DB::select('SELECT * FROM CTB_FORM WHERE ID = '.$id)
        ];

        return view('layout.index',['data' => $data]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            // 'nd_pots'        => 'required',
            'nd_internet'    => 'required',
            'nama_pelanggan' => 'required',
            'no_hp'          => 'required',
            'paket_terakhir' => 'required'
        ];
        
        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return redirect()->back()->withInput()->withErrors($isValid->errors());
        }else{
            $data = [
                'nd_pots'        => $request->input('nd_pots'),
                'nd_internet'    => $request->input('nd_internet'),
                'nama_pelanggan' => $request->input('nama_pelanggan'),
                'no_hp'          => $request->input('no_hp'),
                'paket_terakhir' => $request->input('paket_terakhir'),
                'keterangan_ctb' => $request->input('keterangan_ctb'),
                'no_ktp'         => $request->input('no_ktp'),
                'updated'        => date('Y-m-d H:i:s'),
                'nama_bank'      => $request->input('nama_bank'),
                'no_rekening'    => $request->input('no_rekening'),
                'atas_nama'      => $request->input('atas_nama')
            ];

            $update = DB::table('ctb_form')->where('id',$id)->update($data);
            if($update){
                Logs::log('edit','Memperbarui data CTB','UDCTB',$id,0);
                return redirect()->back()->with('success','Data berhasil diperbarui!');
            }else{
                return redirect()->back()->with('error','Data gagal diperbarui!');
            }
        }
    }

    public function destroy($id)
    {
        $query = DB::table('ctb_form')->where('id',$id)->update([
            'deleted' => 1
        ]);
        
        if($query){
            Logs::log('delete','Menghapus data CTB','DDCTB',$id,0);
            return redirect('ctb')->with('success','Data CTB berhasil dihapus!');
        }else{
            return redirect('ctb')->with('error','Data CTB gagal dihapus!');
        }
    }

    public function auto_fill(Request $request)
    {
        $data = $request->input('nd_internet');
        $query = DB::select("select * from lis_r5_current where nd_internet = '$data'");

        if($query){
            $data = [
                'status'         => 200,
                'nd_internet'    => $query[0]->nd_internet,
                'paket_terakhir' => $query[0]->desc_pack_inet,
                'message' => 'Paket tersedia!'
            ];
        }else{
            $data = [
                'status' => 500,
                'message' => 'Paket tidak tersedia! silahkan isi manual!'
            ];
        }

        return response($data);
    }
}
