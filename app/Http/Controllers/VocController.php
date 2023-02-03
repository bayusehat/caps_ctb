<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;

class VocController extends Controller
{
    public function hasil_voc_view()
    {
        $data = [
            'content' => 'master.voc_view',
            'title' => 'Master Data VOC'
        ];

        return view('layout.index',['data' => $data]);
    }

    public function loadData()
    {
        $response['data'] = [];
        $query = DB::select("SELECT * FROM CTB_VOC WHERE DELETED = 0");

        foreach($query as $i => $v){
            $response['data'][] = [
                ++$i,
                $v->voc,
                '
                <a href="" class="btn btn-primary btn-sm" onclick="editVoc('.$v->id_voc.')"><i class="fas fa-edit"></i> Edit</a>
                <a href="" class="btn btn-danger btn-sm" onclick="deleteVoc('.$v->id_voc.')"><i class="fas fa-trash"></i> Delete</a>
                '
            ];
        }

        return response($response);
    }

    public function insert(Request $request)
    {
        $rules = [
            'voc' => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return response([
                'status' =>  401,
                'errors' =>  $isValid->errors()
            ]);
        }else{
            $data = [
                'voc' => $request->input('voc')
            ];

            $insert = DB::table('ctb_voc')->insert($data);

            if($insert){
                return response([
                    'status' => 200,
                    'message' => 'Berhasil menambahkan VOC baru'
                ]);
            }else{
                return response([
                    'status' => 500,
                    'message' => 'Gagal menambahkan VOC !'
                ]);
            }
        }
    }

    public function edit($id)
    {
        $query = DB::select("SELECT * FROM CTB_VOC WHERE ID_VOC = $id");
        return response($query);
    }

    public function update(Request $request,$id)
    {
        $rules = [
            'voc' => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return response([
                'status' =>  401,
                'errors' =>  $isValid->errors()
            ]);
        }else{
            $data = [
                'voc' => $request->input('voc')
            ];

            $update = DB::table('ctb_voc')->where('id_voc',$id)->update($data);

            if($insert){
                return response([
                    'status' => 200,
                    'message' => 'Berhasil memperbarui VOC'
                ]);
            }else{
                return response([
                    'status' => 500,
                    'message' => 'Gagal memperbarui VOC !'
                ]);
            }
        }
    }

    public function destroy($id)
    {
        $query = DB::table('ctb_voc')->where('id_voc',$id)->update([
            'deleted' => 1
        ]);

        if($query){
            return response([
                'status' => 200,
                'message' => 'Berhasil menghapus VOC'
            ]);
        }else{
            return response([
                'status' => 400,
                'message' => 'Gagal menghapus VOC'
            ]);
        }
    }
}
