<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
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
    }
}
