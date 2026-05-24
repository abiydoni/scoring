<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAsalKlubToAnggota extends Migration
{
    public function up()
    {
        $fields = [
            'asal_klub' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ]
        ];
        $this->forge->addColumn('anggota', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('anggota', 'asal_klub');
    }
}
