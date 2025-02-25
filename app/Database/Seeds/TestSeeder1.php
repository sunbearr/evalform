<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TestSeeder1 extends Seeder
{
    public function run()
    {
        // Insert sample data into the User table for multiple users
        $user_data = [
            [
                'username' => 'johnny123',
                'email' => 'user1@example.com',
                'phone' => '123-456-2232',
                'url' => 'https://user1.com',
                'status' => 1
            ],
            [
                'username' => 'michael1813',
                'email' => 'user2@example.com',
                'phone' => '453-452-2972',
                'url' => 'https://user2.com',
                'status' => 1
            ],
            [
                'username' => 'hellohitestest',
                'email' => 'user3@example.com',
                'phone' => '111-847-0872',
                'url' => 'https://user3.com',
                'status' => 1
            ]
        ];

        $userIds = [];

        foreach ($user_data as $user) {
            $this->db->table('User')->insert($user);
            $userIds[] = $this->db->insertID();
        }

    }
}
