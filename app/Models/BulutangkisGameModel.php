<?php

namespace App\Models;

use CodeIgniter\Model;

class BulutangkisGameModel extends Model
{
    protected $table            = 'bulutangkis_game';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'match_id',
        'set_ke',
        'poin_atlet',
        'poin_lawan',
        'is_finished'
    ];

    // Dates
    protected $useTimestamps = false;
}
