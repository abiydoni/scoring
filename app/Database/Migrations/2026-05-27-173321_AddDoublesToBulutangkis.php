<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDoublesToBulutangkis extends Migration
{
    public function up()
    {
        $fields = [
            'partner_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => true,
                'after'          => 'anggota_id'
            ],
            'lawan_partner_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => true,
                'after'          => 'lawan_nama'
            ],
            'lawan_partner_nama' => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
                'null'           => true,
                'after'          => 'lawan_partner_id'
            ]
        ];

        $this->forge->addColumn('bulutangkis_match', $fields);

        // Tambahkan foreign keys jika dibutuhkan, tetapi karena ini nullable,
        // lebih aman jika dibiarkan tanpa foreign key cascade agar tidak error
        // ketika anggota dihapus, namun untuk integritas data kita tambahkan saja:
        $this->forge->addForeignKey('partner_id', 'anggota', 'id', 'SET NULL', 'SET NULL');
        $this->forge->addForeignKey('lawan_partner_id', 'anggota', 'id', 'SET NULL', 'SET NULL');
        // Tapi method addColumn tidak support addForeignKey secara langsung kecuali melalui proses alter.
        // Kita eksekusi query raw untuk aman
        $db = \Config\Database::connect();
        
        // Cek driver database, jika MySQL/MariaDB jalankan foreign key:
        if ($db->DBDriver === 'MySQLi') {
            $db->query('ALTER TABLE `bulutangkis_match` ADD CONSTRAINT `bulutangkis_match_partner_id_foreign` FOREIGN KEY (`partner_id`) REFERENCES `anggota`(`id`) ON DELETE SET NULL ON UPDATE SET NULL');
            $db->query('ALTER TABLE `bulutangkis_match` ADD CONSTRAINT `bulutangkis_match_lawan_partner_id_foreign` FOREIGN KEY (`lawan_partner_id`) REFERENCES `anggota`(`id`) ON DELETE SET NULL ON UPDATE SET NULL');
        }
    }

    public function down()
    {
        $db = \Config\Database::connect();
        if ($db->DBDriver === 'MySQLi') {
            $db->query('ALTER TABLE `bulutangkis_match` DROP FOREIGN KEY `bulutangkis_match_partner_id_foreign`');
            $db->query('ALTER TABLE `bulutangkis_match` DROP FOREIGN KEY `bulutangkis_match_lawan_partner_id_foreign`');
        }
        $this->forge->dropColumn('bulutangkis_match', ['partner_id', 'lawan_partner_id', 'lawan_partner_nama']);
    }
}
