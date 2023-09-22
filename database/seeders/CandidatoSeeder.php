<?php

namespace Database\Seeders;

use App\Models\Candidato;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;


class CandidatoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Candidato::factory()->count(50)->create();
    }
}
