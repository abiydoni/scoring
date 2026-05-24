<?php

namespace App\Models;

use CodeIgniter\Model;

class PanahanGameModel extends Model
{
    protected $table            = 'panahan_game';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'anggota_id', 
        'tanggal', 
        'jumlah_sesi', 
        'tipe_game', 
        'lawan_id', 
        'lawan_nama', 
        'total_score', 
        'total_score_lawan', 
        'set_point_atlet', 
        'set_point_lawan', 
        'divisi',
        'keterangan'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Custom method to get game details with athlete & opponent info
    public function getGameWithAthlete($id = null)
    {
        $selectStr = 'panahan_game.*, anggota.nama as nama_anggota, lawan.nama as nama_lawan_db';
        
        $builder = $this->select($selectStr)
                        ->join('anggota', 'anggota.id = panahan_game.anggota_id')
                        ->join('anggota as lawan', 'lawan.id = panahan_game.lawan_id', 'left');

        if ($id === null) {
            return $builder->orderBy('panahan_game.tanggal', 'DESC')
                           ->orderBy('panahan_game.id', 'DESC')
                           ->findAll();
        }

        return $builder->where('panahan_game.id', $id)
                       ->first();
    }

    // Get games by athlete
    public function getGamesByAthlete($athleteId)
    {
        return $this->select('panahan_game.*, anggota.nama as nama_anggota, lawan.nama as nama_lawan_db')
                    ->join('anggota', 'anggota.id = panahan_game.anggota_id')
                    ->join('anggota as lawan', 'lawan.id = panahan_game.lawan_id', 'left')
                    ->where('anggota_id', $athleteId)
                    ->orderBy('tanggal', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->findAll();
    }
}
