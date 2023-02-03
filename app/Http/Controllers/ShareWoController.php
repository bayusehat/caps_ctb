<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;

class ShareWoController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Pembagian WO Call OBC',
            'content' => 'master.share_wo',
            'user_obc' => DB::select("SELECT * FROM ctb_user WHERE profil = 1 and deleted = 0")
        ];

        return view('layout.index',['data' => $data]);
    }

    public function add_wo_to_obc(Request $request)
    {
        $user_obc = $request->input('user_obc');
        $jumlah   = $request->input('jumlah');

        $rules = [
            'user_obc' => 'required',
            'jumlah'   => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            $data = [
                'status' => 401,
                'errors' => $isValid->errors()
            ];

            return response($data);
        }else{
            $query = DB::statement("
                UPDATE CTB_FORM 
                    SET USER_OBC = '".$request->input('user_obc')."' 
                        WHERE ID 
                            IN 
                        (SELECT ID 
                            FROM CTB_FORM 
                            WHERE USER_OBC IS NULL AND TGL_CALL IS NULL
                            AND DELETED = 0
                            LIMIT $jumlah)");

            if($query){
                $data = [
                    'status' => 200,
                    'message' => 'Berhasil share WO user obc '.$request->input('user_obc')
                ];
            }else{
                $data = [
                    'status' => 500,
                    'message' => 'Gagal share WO user obc '.$request->input('user_obc')
                ];
            }

            return response($data);
        }
    }

    public function get_unmapped_wo()
    {
        $query = DB::select("SELECT COUNT(*) TOTAL_WO,
        SUM(CASE WHEN TGL_CALL IS NOT NULL THEN 1 ELSE 0 END) TOTAL_CALL,
        SUM(CASE WHEN TGL_CALL IS NULL AND USER_OBC IS NULL THEN 1 ELSE 0 END) NOT_CALLED
        FROM CTB_FORM WHERE DELETED = 0 AND USER_CTB != 'ctb_admin' ORDER BY TOTAL_WO DESC");

        return response($query);
    }
}
