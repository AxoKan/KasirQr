<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class M_lelang extends Model
{

    public function tampil($table)
    {
        $this->setTable($table);
        return DB::table($this->table)->get();
    }
    public function joinTables($table, $table2, $on)
{
    return DB::table($table)
        ->leftJoin($table2, $on[0], '=', $on[1])
        ->get();
}

    public function tambah($table, $data)
    {
        $this->setTable($table); 
        return DB::table($this->table)->insert($data); 
    }
    public function tambah1($table, $data)
    {
        $this->setTable($table); 
        return DB::table($this->table)->insertGetId($data); // Returns the last inserted ID
    }
    
    public function getWhere($table, $where)
{
    return DB::table($table)->where($where)->first();
}

public function edit($table, $where, $data)
{
    $this->setTable($table);
    return DB::table($this->table)->where($where)->update($data);
}

public function hapus($table, $where)
{
    $this->setTable($table);
    return DB::table($this->table)->where($where)->delete();
}

public function getMenuCount()
{
    return \DB::table('gejala')->count();
}

  
    public function tampil2($tabel)
    {
        return DB::table($tabel)
                 
                 ->get();
    }



    public function getActivityLogs()
    {
        try {
            $query = DB::table('activity_log')
                ->leftJoin('user', 'activity_log.user_id', '=', 'user.id_user')
                ->select('user.user', 'activity_log.activity', 'activity_log.description', 'activity_log.timestamp')
                ->orderBy('activity_log.timestamp', 'DESC')
                ->get();
    
            return $query->toArray();
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Error fetching activity logs: ' . $e->getMessage());
            return [];
        }
    }
    public function logActivity($user_id, $activity, $description) {
        date_default_timezone_set('Asia/Jakarta'); // Set timezone ke WIB
        $timestamp = date('Y-m-d H:i:s'); // Waktu dalam WIB
    
        $data = [
            'user_id' => $user_id,
            'activity' => $activity,
            'description' => $description,
            'timestamp' => $timestamp, // Tambahkan timestamp ke data
        ];
    
        $this->db->table('activity_log')->insert($data);
    }

  
    public function getBackupData()
    {
        return DB::table('user_backup')->get();
    }

  
    public function getProductById($id)
    {
        return DB::table('user')->where('id_user', $id)->first();
    }
    public function hitungSemuaMenu()
    {
        // Count all rows in the 'permainan' table where 'deleted_at' is null
        return DB::table('menu')->whereNull('deleted_at')->count();
    }
    
    public function hitungTransaksiHariIni()
    {
        // Get today's date and tomorrow's date using Carbon
        $hariIni = Carbon::today();
        $besok = Carbon::tomorrow();
    
        // Count all rows in the 'transaksi' table created today
        return DB::table('transaksi')
            ->whereNull('deleted_at') // Filter out soft-deleted records
            ->where('created_at', '>=', $hariIni)
            ->where('created_at', '<', $besok)
            ->count();
    }
    public function cari($table, $awal, $akhir)
{
    return DB::table($table)
        ->whereBetween('tanggal_transaksi', [$awal, $akhir])
        ->get();
}

}

