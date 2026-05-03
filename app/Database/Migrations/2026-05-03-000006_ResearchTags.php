<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ResearchTags extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'research_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'tag_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);
        $this->forge->addForeignKey('research_id', 'researches', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('tag_id', 'tags', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('research_tags');
    }

    public function down()
    {
        $this->forge->dropTable('research_tags');
    }
}
