<?php

namespace Tests\Feature;

use Artisan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class LeadTest extends TestCase
{
    public function test_lead_toda_la_data(): void
    {
        $response = $this->json('POST', '/api/auth', [
            'username' => 'tester',
            'password' => 'PASSWORD'
        ]);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'meta' => [
                    'success',
                    'errors'
                ],
                'data' => [
                    'token',
                    'min_to_expired'
                ]
            ]);
        $response->assertStatus(200)
            ->assertJson([
                'meta' => [
                    'success' => true,
                    'errors' => []
                ],
                'data' => []
            ]);

        $token = $response->json('data.token');

        $response2 = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/lead');

        $response2->assertStatus(200)
            ->assertJson([
                'meta' => [
                    'success' => true,
                    'errors' => []
                ],
                'data' => []
            ]);
    }

    public function test_lead_por_id(): void
    {
        $response = $this->json('POST', '/api/auth', [
            'username' => 'tester',
            'password' => 'PASSWORD'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'meta' => [
                    'success',
                    'errors'
                ],
                'data' => [
                    'token',
                    'min_to_expired'
                ]
            ])
            ->assertJson([
                'meta' => [
                    'success' => true,
                    'errors' => []
                ],
                'data' => []
            ]);

        $token = $response->json('data.token');
        $id = 17;

        $response2 = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/lead/' . $id);

        $response2->assertStatus(200)
            ->assertJson([
                'meta' => [
                    'success' => true,
                    'errors' => []
                ],
                'data' => []
            ]);
    }

    public function test_lead_por_id_usuario_sin_permiso(): void
    {
        $response = $this->json('POST', '/api/auth', [
            'username' => 'usuario',
            'password' => 'PASSWORD'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'meta' => [
                    'success',
                    'errors'
                ],
                'data' => [
                    'token',
                    'min_to_expired'
                ]
            ])
            ->assertJson([
                'meta' => [
                    'success' => true,
                    'errors' => []
                ],
                'data' => []
            ]);

        $token = $response->json('data.token');
        $id = 17;

        $response2 = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/lead/' . $id);

        $response2->assertStatus(401)
            ->assertJson([
                'meta' => [
                    'success' => false,
                    'errors' => 'You are not an owner'
                ]
            ]);
    }

    public function test_lead_por_id_usuario_sin_inactivo(): void
    {
        $response = $this->json('POST', '/api/auth', [
            'username' => 'test',
            'password' => 'PASSWORD'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'meta' => [
                    'success',
                    'errors'
                ],
                'data' => [
                    'token',
                    'min_to_expired'
                ]
            ])
            ->assertJson([
                'meta' => [
                    'success' => true,
                    'errors' => []
                ],
                'data' => []
            ]);

        $token = $response->json('data.token');
        $id = 17;

        $response2 = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/lead/' . $id);

        $response2->assertStatus(401)
            ->assertJson([
                'meta' => [
                    'success' => false,
                    'errors' => 'Users not active'
                ]
            ]);
    }
}