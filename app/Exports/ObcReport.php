<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class ObcReport implements FromCollection,WithHeadings
{
    protected $user;
    protected $paket;
    protected $columns;
    protected $tgl_awal;
    protected $tgl_akhir;
    protected $flag;

    public function __construct($user,$paket,$tgl_awal,$tgl_akhir,$columns,$flag)
    {
       $this->user = $user;
       $this->paket = $paket;
       $this->columns = $columns;
       $this->tgl_awal = $tgl_awal;
       $this->tgl_akhir = $tgl_akhir;
       $this->flag = $flag;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        if($this->tgl_awal != null){
            $rangetgl = "TGL_CALL BETWEEN '$this->tgl_awal 00:00:00'  AND '$this->tgl_akhir 23:59:59'";
        }else{
            $rangetgl = "1 = 1";
        }

        if($this->flag == 'obc'){
            $usr = 'user_obc';
            if($this->user == 'all'){
                $subusr = "1=1";
            }else{
                $subusr = "$usr = '$this->user'";
            }
        }else{
            $usr = 'user_ctb';
        }

        if($this->paket == 'TW'){
            $inquery = $subusr;
        }elseif($this->paket == 'TC'){
            $inquery = "$subusr AND TGL_CALL IS NOT NULL";
        }elseif($this->paket == 'PR'){
            $inquery = "$subusr AND HASIL_CALL != 25 AND HASIL_CALL != 4 AND HASIL_CALL != 27 AND HASIL_CALL != 26";
        }elseif($this->paket == 'PE'){
            $inquery = "$subusr AND HASIL_CALL = 4";
        }elseif($this->paket == 'BB'){
            $inquery = "$subusr AND HASIL_CALL = 25";
        }elseif($this->paket == 'FU'){
            $inquery = "$subusr AND HASIL_CALL = 27";
        }elseif($this->paket == 'RN'){
            $inquery = "$subusr AND HASIL_CALL = 26";
        }elseif($this->paket == 'SS'){
            $inquery = "$subusr AND HASIL_MC = 1";
        }elseif($this->paket == 'AM'){  
            $inquery = "$subusr AND HASIL_MC = 2";
        }elseif($this->paket == 'GG'){
            $inquery = "$subusr AND HASIL_MC = 3";
        }else{
            $inquery = "$subusr AND TGL_CALL IS NULL";
        }

        $query = DB::select(DB::raw("
            SELECT WITEL,ND_POTS,ND_INTERNET,NAMA_PELANGGAN,NO_HP,NO_KTP,PAKET_TERAKHIR,KETERANGAN_CTB,TGL_INPUT,USER_CTB,TGL_CALL,B.HASIL_CARING, KETERANGAN_CALL, PIC_OBC, USER_OBC, TGL_MC, 
            CASE 
                WHEN HASIL_MC = 1 THEN 'SUKSES' 
                WHEN HASIL_MC = 2 THEN 'ANOMALI' 
                WHEN HASIL_MC = 3 THEN 'GAGAL'
            END HASIL_MC,
            KETERANGAN_MC,USER_OPLANG
            FROM ctb_form A LEFT JOIN CTB_HASIL_CARING B ON A.HASIL_CALL = B.ID_HASIL_CARING WHERE $inquery AND $rangetgl AND A.DELETED = 0
            "));

        return collect($query);
    }

    public function headings(): array
    {
        return [
            'WITEL',
            'ND POTS',
            'ND INTERNET',
            'NAMA PELANGGAN',
            'NO. HP',
            'NO. KTP',
            'PAKET TERAKHIR',
            'KETERANGAN CTB',
            'TGL. INPUT',
            'USER CTB',
            'TGL. CALL',
            'HASIL CARING',
            'KETERANGAN CALL',
            'PIC CALL',
            'USER OBC',
            'TGL. MC',
            'HASIL MC',
            'KETERANGAN MC',
            'USER OPLANG'
        ];
    }
}
