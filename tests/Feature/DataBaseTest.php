<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class DataBaseTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_migrate_database(): void
    {
        Artisan::call('migrate');
        
    }
}
