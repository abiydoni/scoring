<?php

namespace App\Models;

use CodeIgniter\Model;

class PanahanShotModel extends Model
{
    protected $table            = 'panahan_shot';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['game_id', 'session_number', 'shoot_number', 'arrow_number', 'score', 'display_value', 'is_lawan'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Get all shots for a session, grouped by shoot_number and is_lawan
    public function getShotsForSession($gameId, $sessionNumber, $isLawan = null)
    {
        $builder = $this->where('game_id', $gameId)
                        ->where('session_number', $sessionNumber);
        
        if ($isLawan !== null) {
            $builder->where('is_lawan', $isLawan);
        }

        $shots = $builder->orderBy('shoot_number', 'ASC')
                         ->orderBy('is_lawan', 'ASC')
                         ->orderBy('arrow_number', 'ASC')
                         ->findAll();

        $grouped = [];
        foreach ($shots as $shot) {
            $lawanKey = $shot['is_lawan'];
            $grouped[$shot['shoot_number']][$lawanKey][] = $shot;
        }

        return $grouped;
    }
}
