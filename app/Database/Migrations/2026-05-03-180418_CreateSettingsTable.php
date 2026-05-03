<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'key' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
            ],
            'value' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'description' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('settings');

        // Insert initial data
        $db = \Config\Database::connect();
        $db->table('settings')->insertBatch([
            [
                'key' => 'site_name',
                'value' => 'Akademika',
                'description' => 'Nama website',
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'key' => 'site_description',
                'value' => 'Platform portal penelitian dan edukasi ilmiah modern untuk mempublikasikan karya terbaik Anda.',
                'description' => 'Deskripsi website di footer',
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'key' => 'contact_email',
                'value' => 'info@akademika.id',
                'description' => 'Email kontak',
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'key' => 'contact_phone',
                'value' => '+62 812-3456-7890',
                'description' => 'Nomor telepon kontak',
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'key' => 'footer_copyright',
                'value' => 'Akademika Portal. All rights reserved.',
                'description' => 'Teks hak cipta di footer',
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('settings');
    }
}
