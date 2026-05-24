<?php

namespace App\Models;

use CodeIgniter\Model;

class PanahanShootModel extends Model
{
    protected $table            = 'panahan_shoot';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['game_id', 'session_number', 'shoot_number', 'total_score', 'is_lawan'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Get shoot totals by game, session, and is_lawan toggle
    public function getShootTotals($gameId, $sessionNumber, $isLawan = null)
    {
        $builder = $this->where('game_id', $gameId)
                        ->where('session_number', $sessionNumber);
        
        if ($isLawan !== null) {
            $builder->where('is_lawan', $isLawan);
        }

        return $builder->orderBy('shoot_number', 'ASC')
                       ->orderBy('is_lawan', 'ASC')
                       ->findAll();
    }
}
