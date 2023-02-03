<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Str;

class MasterController extends Controller
{
    public function hasil_caring_view()
    {
        $data = [
            'title' => 'Data Master Hasil Caring',
            'content' => 'master.hasil_caring_view'
        ];

        return view('layout.index',['data' => $data]);
    }

    public function loadData()
    {
        $response['data'] = [];
        $query = DB::select("SELECT * FROM CTB_HASIL_CARING WHERE DELETED = 0 ORDER BY ID_HASIL_CARING");
        // if(count($query)){
            foreach ($query as $i => $hc) {
                $response['data'][] = [
                    ++$i,
                    $hc->hasil_caring,
                    '
                        <a href="javascript:void(0)" onclick="editHasilCaring('.$hc->id_hasil_caring.')" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                        <a href="javascript:void(0)" onclick="deleteHasilCaring('.$hc->id_hasil_caring.')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                    '
                ];
            }
        // }
        return response($response);
    }

    public function hasil_caring_insert(Request $request)
    {
        $rules = [
            'hasil_caring' => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            $data = [
                'status' => 401,
                'errors' => $isValid->errors()
            ];
            return response()->json($data);
        }else{
            $data = [
                'hasil_caring' => $request->input('hasil_caring')
            ];

            $insert = DB::table('ctb_hasil_caring')->insert($data);
            if($insert){
                $data = [
                    'status' => 200,
                    'message' => 'Berhasil menambah hasil caring baru!'
                ];

                return response()->json($data);
            }else{
                $data = [
                    'status' => 500,
                    'message' => 'Gagal menambah hasil caring baru!'
                ];

                return response()->json($data);
            }
        }
    }

    public function hasil_caring_edit($id)
    {
        $data = DB::select("SELECT * FROM CTB_HASIL_CARING WHERE ID_HASIL_CARING = $id");

        return response()->json($data);
    }

    public function hasil_caring_update(Request $request, $id)
    {
        $rules = [
            'hasil_caring' => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            $data = [
                'status' => 201,
                'message' => $isValid->errors()
            ];
            return response()->json($data);
        }else{
            $data = [
                'hasil_caring' => $request->input('hasil_caring')
            ];

            $update = DB::table('ctb_hasil_caring')->where('id_hasil_caring',$id)->update($data);
            if($update){
                $data = [
                    'status' => 200,
                    'message' => 'Berhasil memperbarui hasil caring baru!'
                ];

                return response()->json($data);
            }else{
                $data = [
                    'status' => 500,
                    'message' => 'Gagal memperbarui hasil caring baru!'
                ];

                return response()->json($data);
            }
        }
    }

    public function hasil_caring_delete($id)
    {
        $delete = DB::table('ctb_hasil_caring')->where('id_hasil_caring',$id)->update([
            'deleted' => 1
        ]);
        if($delete){
            $data = [
                'status' => 200,
                'message' => 'Berhasil menghapus hasil caring'
            ];

            return response()->json($data);
        }else{
            $data = [
                'status' => 500,
                'message' => 'Gagal menghapus hasil caring'
            ];

            return response()->json($data);
        }
    }

    public function hasil_voc_view()
    {
        $data = [
            'title' => 'Data VOC',
            'content' => 'master.voc_view'
        ];

        return view('layout.index',['data' => $data]);
    }

    public function loadDataVoc(Type $var = null)
    {
        # code...
    }
}
 