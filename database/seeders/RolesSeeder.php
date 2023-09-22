<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data[0] = ['name' => 'Manager'];
        $data[1] = ['name' => 'Agent'];
        
        foreach ($data as $d => $da) {
            $new = new Roles();
            $new->name = $da['name'];
            try {
                $new->save();
            } catch (\Exception $e) {
                var_dump($e->getMessage());
            }
        }
    }
}
