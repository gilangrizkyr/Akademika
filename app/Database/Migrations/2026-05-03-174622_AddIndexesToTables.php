<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIndexesToTables extends Migration
{
    public function up()
    {
        // Researches table indexes
        $this->db->query("CREATE INDEX idx_researches_slug ON researches(slug)");
        $this->db->query("CREATE INDEX idx_researches_status ON researches(status)");
        $this->db->query("CREATE INDEX idx_researches_user_id ON researches(user_id)");
        
        // Sections table indexes
        $this->db->query("CREATE INDEX idx_sections_research_id ON research_sections(research_id)");
        $this->db->query("CREATE INDEX idx_sections_sort_order ON research_sections(sort_order)");

        // Users table indexes
        $this->db->query("CREATE INDEX idx_users_username ON users(username)");
        $this->db->query("CREATE INDEX idx_users_role ON users(role)");
    }

    public function down()
    {
        $this->db->query("DROP INDEX idx_researches_slug ON researches");
        $this->db->query("DROP INDEX idx_researches_status ON researches");
        $this->db->query("DROP INDEX idx_researches_user_id ON researches");
        
        $this->db->query("DROP INDEX idx_sections_research_id ON research_sections");
        $this->db->query("DROP INDEX idx_sections_sort_order ON research_sections");

        $this->db->query("DROP INDEX idx_users_username ON users");
        $this->db->query("DROP INDEX idx_users_role ON users");
    }
}
