<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Str;
use Session;
use Logs;
use Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }
    
    public function doLogin(Request $request)
    {
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return redirect()->back()->withErrors($isValid->errors());
        }else{
            $username = $request->input('username');
            $password = $request->input('password');

            $check = DB::select("SELECT USERNAME,ID_USER,WITEL_CBD WITEL,PROFIL,DELETED,PASSWORD FROM CTB_USER A LEFT JOIN P_M_WILAYAH B ON A.CWITEL=B.CWITEL WHERE USERNAME = '$username'");

            if($check){
                if($check[0]->deleted != 1){
                    if(Hash::check($request->input('password'), $check[0]->password)){
                        $session = [
                            'id_user' => $check[0]->id_user,
                            'username' => $check[0]->username,
                            'token' => Str::random(60),
                            'isLogged' => true,
                            'profil' => $check[0]->profil,
                            'witel' => $check[0]->witel
                        ];
                        Logs::log('login',$check[0]->username.' melakukan login','LGN',$check[0]->id_user,0);
                        session($session);
                        if(session('profil') == '2'){
                            return redirect('/ctb');
                        }else if(session('profil') == '3'){
                            return redirect('/oplang');
                        }else if(session('profil') == '1'){
                            return redirect('/obc');
                        }else{
                            return redirect('/home');
                        }
                    }else{
                        return redirect()->back()->with('error','Password yang anda masukkan salah!');
                    }
                }else{
                    return redirect()->back()->with('error','User tidak aktif!');
                }
            }else{
                return redirect()->back()->with('error','User tidak ditemukan');
            }
        }
    }

    public function doLogout()
    {
        Session::put('isLogged',false);
        Session::save();
        Logs::log('logout',session('username').' melakukan logout','LGT',session('id_user'),0);
        return redirect('/');
    }
}
