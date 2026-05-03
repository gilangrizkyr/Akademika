<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        $this->db->query('SET FOREIGN_KEY_CHECKS=0;');
        $this->db->table('users')->truncate();
        $this->db->table('categories')->truncate();
        $this->db->table('tags')->truncate();
        $this->db->table('researches')->truncate();
        $this->db->table('research_sections')->truncate();
        $this->db->table('research_tags')->truncate();
        $this->db->table('bookmarks')->truncate();
        $this->db->table('auth_logins')->truncate();
        $this->db->table('settings')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Users
        $users = [
            [
                'username'      => 'superadmin',
                'email'         => 'superadmin@example.com',
                'password_hash' => password_hash('620a608e807d272a', PASSWORD_BCRYPT),
                'role'          => 'superadmin',
                'status'        => 'active',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'username'      => 'admin',
                'email'         => 'admin@example.com',
                'password_hash' => password_hash('0d04a1c43ebf6f55', PASSWORD_BCRYPT),
                'role'          => 'admin',
                'status'        => 'active',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'username'      => 'researcher',
                'email'         => 'researcher@example.com',
                'password_hash' => password_hash('3bf3dc1a29c8b08d', PASSWORD_BCRYPT),
                'role'          => 'user',
                'status'        => 'active',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ]
        ];
        $this->db->table('users')->insertBatch($users);

        // 2. Categories
        $categories = [
            ['name' => 'Technology', 'slug' => 'technology', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'Health', 'slug' => 'health', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'Education', 'slug' => 'education', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        ];
        $this->db->table('categories')->insertBatch($categories);

        // 3. Tags
        $tags = [
            ['name' => 'AI', 'slug' => 'ai', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'Machine Learning', 'slug' => 'machine-learning', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'Public Health', 'slug' => 'public-health', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'E-Learning', 'slug' => 'e-learning', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        ];
        $this->db->table('tags')->insertBatch($tags);

        // 4. Research Data
        $this->call('ResearchSeeder');

        // 5. Settings
        $settings = [
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
            [
                'key' => 'social_twitter',
                'value' => 'https://twitter.com/akademika',
                'description' => 'Link Twitter',
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'key' => 'social_linkedin',
                'value' => 'https://linkedin.com/company/akademika',
                'description' => 'Link LinkedIn',
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'key' => 'social_instagram',
                'value' => 'https://instagram.com/akademika',
                'description' => 'Link Instagram',
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table('settings')->insertBatch($settings);
    }
}
