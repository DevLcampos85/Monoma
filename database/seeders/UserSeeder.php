<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data[0] = ['username' => 'tester', 'active' => true, 'role' => 1];
        $data[1] = ['username' => 'usuario', 'active' => true, 'role' => 2];
        $data[2] = ['username' => 'test', 'active' => false, 'role' => 2];

        foreach ($data as $d => $da) {
            $new = new User();
            $new->username = $da['username'];
            $new->password = bcrypt('PASSWORD');
            $new->last_login = date("Y-m-d H:m:s");
            $new->is_active = $da['active'];
            $new->role = $da['role'];
            try {
                $new->save();
            } catch (\Exception $e) {
                var_dump($e->getMessage());
            }
        }
        User::factory()->count(10)->create();
    }
}