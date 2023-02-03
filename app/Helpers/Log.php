<?php
namespace App\Helpers;
use Request;
use DB;

class Log {
    public static function log($method,$keterangan,$flag,$id,$hasil_caring) {
        $data = [
            'tanggal'    => date('Y-m-d H:i:s'),
            'method'     => $method,
            'keterangan' => $keterangan,
            'username'   => session('username'),
            'id'         => $id,
            'flag'       => $flag,
            'ip'         => $_SERVER['REMOTE_ADDR'],
            'hasil_caring' => $hasil_caring
        ];

        DB::table('ctb_log')->insert($data);

        return true;
    }
}