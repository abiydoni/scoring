<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateAnggotaAndGameForMixteam extends Migration
{
    public function up()
    {
        // 1. Update tabel `anggota`
        $fieldsAnggota = [
            'jenis_kelamin' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'null'       => true,
            ],
            'divisi' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'klub' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'kota' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
        ];
        $this->forge->addColumn('anggota', $fieldsAnggota);

        // Hapus kolom asal_klub jika ada
        if ($this->db->fieldExists('asal_klub', 'anggota')) {
            $this->forge->dropColumn('anggota', 'asal_klub');
        }

        // 2. Update tabel `panahan_game`
        $fieldsGame = [
            'partner_id' => [
                'type' => 'INTEGER',
                'null' => true,
            ],
            'partner_nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
        ];
        $this->forge->addColumn('panahan_game', $fieldsGame);
    }

    public function down()
    {
        $this->forge->dropColumn('panahan_game', 'partner_id');
        $this->forge->dropColumn('panahan_game', 'partner_nama');

        $this->forge->dropColumn('anggota', 'jenis_kelamin');
        $this->forge->dropColumn('anggota', 'divisi');
        $this->forge->dropColumn('anggota', 'klub');
        $this->forge->dropColumn('anggota', 'kota');
        
        // Kembalikan asal_klub
        $this->forge->addColumn('anggota', [
            'asal_klub' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ]
        ]);
    }
}
