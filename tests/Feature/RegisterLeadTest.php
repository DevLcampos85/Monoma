<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterLeadTest extends TestCase
{
    public function test_lead_register_datos_completo(): void
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
        ])->post('/api/lead', [
                    'name' => 'Luis Campos',
                    'source' => 'Source Luis Campos',
                    'owner' => 1
                ]);

        $response2->assertStatus(201)
            ->assertJson([
                'meta' => [
                    'success' => true,
                    'errors' => []
                ],
                'data' => []
            ]);
    }

    public function test_lead_register_datos_incompletos(): void
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
        ])->post('/api/lead', [
                    'name' => 'Luis Campos',
                    'source' => 'Source Luis Campos',
                ]);

        $response2->assertStatus(401)
            ->assertJson([
                'meta' => [
                    'success' => false,
                    'errors' => 'incomplete params'
                ]
            ]);
    }

    public function test_lead_register_datos_completos_usuario_sin_permiso(): void
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
        ])->post('/api/lead', [
                    'name' => 'Luis Campos',
                    'source' => 'Source Luis Campos',
                ]);

        $response2->assertStatus(401)
            ->assertJson([
                'meta' => [
                    'success' => false,
                    'errors' => 'Insufficient Permits'
                ]
            ]);
    }

    public function test_lead_register_datos_completos_usuario_inactivo(): void
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
        ])->post('/api/lead', [
                    'name' => 'Luis Campos',
                    'source' => 'Source Luis Campos',
                    'owner' => 1
                ]);

        $response2->assertStatus(401)
            ->assertJson([
                'meta' => [
                    'success' => false,
                    'errors' => "Users not active"
                ]
            ]);
    }

    public function test_lead_register_datos_incompletos_usuario_inactivo(): void
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
        ])->post('/api/lead', [
                    'name' => 'Luis Campos',
                    'source' => 'Source Luis Campos'
                ]);

        $response2->assertStatus(401)
            ->assertJson([
                'meta' => [
                    'success' => false,
                    'errors' => "Users not active"
                ]
            ]);
    }
}