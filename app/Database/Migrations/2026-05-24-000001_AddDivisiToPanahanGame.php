<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDivisiToPanahanGame extends Migration
{
    public function up()
    {
        $fields = [
            'divisi' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
                'default'    => 'recurve', // 'recurve' (standard/national) or 'compound'
            ]
        ];
        $this->forge->addColumn('panahan_game', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('panahan_game', 'divisi');
    }
}
