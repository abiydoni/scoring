<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateScoringTables extends Migration
{
    public function up()
    {
        // 1. Tabel Anggota
        $this->forge->addField([
            'id' => [
                'type'           => 'INTEGER',
                'unsigned'       => false,
                'auto_increment' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => false,
            ],
            'telepon' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('anggota');

        // 2. Tabel Panahan Game
        $this->forge->addField([
            'id' => [
                'type'           => 'INTEGER',
                'unsigned'       => false,
                'auto_increment' => true,
            ],
            'anggota_id' => [
                'type'       => 'INTEGER',
                'null'       => false,
            ],
            'tanggal' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'jumlah_sesi' => [
                'type'       => 'INTEGER',
                'default'    => 2,
            ],
            'tipe_game' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'default'    => 'kualifikasi', // kualifikasi | aduan
            ],
            'lawan_id' => [
                'type'       => 'INTEGER',
                'null'       => true,
            ],
            'lawan_nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'total_score' => [
                'type'       => 'INTEGER',
                'default'    => 0,
            ],
            'total_score_lawan' => [
                'type'       => 'INTEGER',
                'default'    => 0,
            ],
            'set_point_atlet' => [
                'type'       => 'INTEGER',
                'default'    => 0,
            ],
            'set_point_lawan' => [
                'type'       => 'INTEGER',
                'default'    => 0,
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('anggota_id', 'anggota', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('panahan_game');

        // 3. Tabel Panahan Shoot (Rambahan)
        $this->forge->addField([
            'id' => [
                'type'           => 'INTEGER',
                'unsigned'       => false,
                'auto_increment' => true,
            ],
            'game_id' => [
                'type'       => 'INTEGER',
                'null'       => false,
            ],
            'session_number' => [
                'type'       => 'INTEGER',
                'null'       => false,
            ],
            'shoot_number' => [
                'type'       => 'INTEGER',
                'null'       => false,
            ],
            'total_score' => [
                'type'       => 'INTEGER',
                'default'    => 0,
            ],
            'is_lawan' => [
                'type'       => 'INTEGER',
                'default'    => 0, // 0 = atlet utama, 1 = lawan
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['game_id', 'session_number', 'shoot_number', 'is_lawan']);
        $this->forge->addForeignKey('game_id', 'panahan_game', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('panahan_shoot');

        // 4. Tabel Panahan Shot (Anak Panah)
        $this->forge->addField([
            'id' => [
                'type'           => 'INTEGER',
                'unsigned'       => false,
                'auto_increment' => true,
            ],
            'game_id' => [
                'type'       => 'INTEGER',
                'null'       => false,
            ],
            'session_number' => [
                'type'       => 'INTEGER',
                'null'       => false,
            ],
            'shoot_number' => [
                'type'       => 'INTEGER',
                'null'       => false,
            ],
            'arrow_number' => [
                'type'       => 'INTEGER',
                'null'       => false,
            ],
            'score' => [
                'type'       => 'INTEGER',
                'null'       => false,
            ],
            'display_value' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'null'       => true,
            ],
            'is_lawan' => [
                'type'       => 'INTEGER',
                'default'    => 0, // 0 = atlet utama, 1 = lawan
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['game_id', 'session_number', 'shoot_number', 'arrow_number', 'is_lawan']);
        $this->forge->addForeignKey('game_id', 'panahan_game', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('panahan_shot');
    }

    public function down()
    {
        $this->forge->dropTable('panahan_shot', true);
        $this->forge->dropTable('panahan_shoot', true);
        $this->forge->dropTable('panahan_game', true);
        $this->forge->dropTable('anggota', true);
    }
}
