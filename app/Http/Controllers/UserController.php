<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Logs;
use Hash;

class UserController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'User Page',
            'content' => 'master.user_view',
            'user' => DB::select('SELECT ID_USER,USERNAME,B.WITEL_CBD WITEL,PROFIL FROM CTB_USER A LEFT JOIN P_M_WILAYAH B ON A.CWITEL = A.CWITEL WHERE A.DELETED = 0'),
            'witel' => DB::select("SELECT CWITEL,WITEL_CBD WITEL FROM P_M_WILAYAH WHERE REG ='5' ORDER BY WITEL_CBD")
        ];

        return view('layout.index',['data' => $data]);
    }

    public function loadData()
    {
        $response['data'] = [];
        $query = DB::select('SELECT ID_USER, USERNAME, PROFIL, B.WITEL_CBD WITEL FROM CTB_USER A LEFT JOIN P_M_WILAYAH B ON A.CWITEL = B.CWITEL WHERE DELETED = 0 ORDER BY CREATED DESC');
        if(count($query)){
            foreach ($query as $i => $v) {
                if($v->profil == 1){
                    $profil = 'OBC';
                }else if($v->profil == 2){
                    $profil = 'CTB';
                }else if($v->profil == 3){
                    $profil = 'OPLANG';
                }else{
                    $profil = 'ADMIN';
                }

                $response['data'][] = [
                    ++$i,
                    $v->username,
                    $profil,
                    $v->witel,
                    '
                        <a href="javascript:void(0)" class="btn btn-success btn-sm" onclick="editUser('.$v->id_user.')"><i class="fas fa-edit"></i> </a>
                        <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="deleteUser('.$v->id_user.')"><i class="fas fa-trash"></i> </a>
                    '
                ];
            }
        } 

        return response($response);
    }

    public function insert(Request $request)
    {
        $rules = [
            'username' => 'required',
            'witel' => 'required',
            'profil' => 'required',
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            $data = [
                'status' => 401,
                'errors' => $isValid->errors()
            ];

            return response($data);
        }else{
            $data = [
                'username' => $request->input('username'),
                'cwitel' => $request->input('witel'),
                'password' => Hash::make('telkom'),
                'profil' => $request->input('profil')
            ];

            $insert = DB::table('ctb_user')->insert($data);

            if($insert){
                $id = DB::table('ctb_user')->where('username',$request->username)->first();
                $res = [
                    'status' => 200,
                    'message' => 'Berhasil menambahkan User baru!'
                ];
                Logs::log('insert','Menambahkan User baru','CDU',$id);
                return response($res);

            }else{

                $res = [
                    'status' => 500,
                    'message' => 'Gagal menambahkan User baru!'
                ];

                return response($res);
            }
        }
    }

    public function edit($id)
    {
        $query = DB::select('SELECT ID_USER,USERNAME,A.CWITEL,WITEL_CBD WITEL,PROFIL FROM CTB_USER A LEFT JOIN P_M_WILAYAH B ON A.CWITEL = A.CWITEL WHERE A.DELETED = 0 AND ID_USER = '.$id);

        return response($query);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'username' => 'required',
            'witel'    => 'required',
            'profil'   => 'required',
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            $data = [
                'status' => 401,
                'errors' => $isValid->errors()
            ];

            return response($data);
        }else{
            $data = [
                'username' => $request->input('username'),
                'cwitel' => $request->input('witel'),
                'profil' => $request->input('profil')
            ];

            $update = DB::table('ctb_user')->where('id_user',$id)->update($data);

            if($update){
                $res = [
                    'status' => 200,
                    'message' => 'Berhasil memperbarui User!'
                ];
                Logs::log('edit','Memperbarui User','UDU',$id);
                return response($res);

            }else{

                $res = [
                    'status' => 500,
                    'message' => 'Gagal memperbarui User!'
                ];

                return response($res);
            }
        }
    }

    public function destroy($id)
    {
        $query = DB::table('ctb_user')->where('id_user',$id)->update([
            'deleted' => 1
        ]);

        if($query){
            $res = [
                'status' => 200,
                'message' => 'Berhasil menghapus user!'
            ];

            return response($res);
        }else{
            $res = [
                'status' => 500,
                'message' => 'Gagal menghapus user!'
            ];

            return response($res);
        }
    }

    public function updatePassword($id_user)
    {
        $password = Hash::make('ctbpass2022');
        $query = DB::table('ctb_user')->where('username',$id_user)->update([
            'password' => $password 
        ]);
    }
}
