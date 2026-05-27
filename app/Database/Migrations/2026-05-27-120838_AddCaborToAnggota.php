<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCaborToAnggota extends Migration
{
    public function up()
    {
        $fields = [
            'cabor' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'default'    => 'Panahan',
                'null'       => false,
            ],
        ];
        $this->forge->addColumn('anggota', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('anggota', 'cabor');
    }
}
