<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIdentityToAppUsers extends Migration
{
    public function up()
    {
        $fields = [
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'picture' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ];
        $this->forge->addColumn('app_users', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('app_users', 'name');
        $this->forge->dropColumn('app_users', 'picture');
    }
}
