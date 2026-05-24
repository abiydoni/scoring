<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AthletesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama'       => 'Pratama Yudha',
                'telepon'    => '081234567890',
                'email'      => 'pratama.yudha@archery.id',
                'asal_klub'  => 'Jakarta Archery Club',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'       => 'Rina Wijaya',
                'telepon'    => '089876543210',
                'email'      => 'rina.wijaya@archery.id',
                'asal_klub'  => 'Surabaya Archery Club',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama'       => 'Budi Santoso',
                'telepon'    => '085612345678',
                'email'      => 'budi.santoso@archery.id',
                'asal_klub'  => 'Bandung Archery Club',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Using Query Builder
        $this->db->table('anggota')->insertBatch($data);
    }
}
