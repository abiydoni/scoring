<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFotoToAnggota extends Migration
{
    public function up()
    {
        $this->forge->addColumn('anggota', [
            'foto' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'kota',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('anggota', 'foto');
    }
}
