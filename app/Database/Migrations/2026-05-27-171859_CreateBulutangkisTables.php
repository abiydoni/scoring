<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBulutangkisTables extends Migration
{
    public function up()
    {
        // Table: bulutangkis_match
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'anggota_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'tanggal' => [
                'type' => 'DATE',
            ],
            'tipe_match' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'default'    => 'Tunggal',
            ],
            'lawan_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'lawan_nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'set_menang_atlet' => [
                'type'       => 'INT',
                'constraint' => 3,
                'default'    => 0,
            ],
            'set_menang_lawan' => [
                'type'       => 'INT',
                'constraint' => 3,
                'default'    => 0,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'default'    => 'ongoing',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('anggota_id', 'anggota', 'id', 'CASCADE', 'CASCADE');
        // If lawan_id points to anggota, let's just make it a foreign key too, but set null on delete.
        $this->forge->addForeignKey('lawan_id', 'anggota', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('bulutangkis_match');

        // Table: bulutangkis_game
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'match_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'set_ke' => [
                'type'       => 'INT',
                'constraint' => 3,
            ],
            'poin_atlet' => [
                'type'       => 'INT',
                'constraint' => 3,
                'default'    => 0,
            ],
            'poin_lawan' => [
                'type'       => 'INT',
                'constraint' => 3,
                'default'    => 0,
            ],
            'is_finished' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('match_id', 'bulutangkis_match', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('bulutangkis_game');
    }

    public function down()
    {
        $this->forge->dropTable('bulutangkis_game', true);
        $this->forge->dropTable('bulutangkis_match', true);
    }
}
