<?php

namespace App\Models;

use CodeIgniter\Model;

class BulutangkisMatchModel extends Model
{
    protected $table            = 'bulutangkis_match';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'anggota_id',
        'partner_id',
        'tanggal',
        'tipe_match',
        'lawan_id',
        'lawan_nama',
        'lawan_partner_id',
        'lawan_partner_nama',
        'set_menang_atlet',
        'set_menang_lawan',
        'status'
    ];

    // Dates
    protected $useTimestamps = false;
}
