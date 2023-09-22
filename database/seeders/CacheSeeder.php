<?php

namespace Database\Seeders;

use App\Models\Candidato;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class CacheSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cache::remember('Users', 84600, function () {
            return User::get();
        });

        Cache::remember('Roles', 84600, function () {
            return Roles::get();
        });

        Cache::remember('Candidatos', 84600, function () {
            return Candidato::get();
        });
    }
}
