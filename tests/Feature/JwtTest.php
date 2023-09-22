<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JwtTest extends TestCase
{
    public function test_token_correcto(): void
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

    public function test_token_invalido(): void
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
        $token = $response->json('data.token');

        $response2 = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token . '12345',
        ])->get('/api/lead');

        $response2->assertStatus(401)
            ->assertJson([
                'meta' => [
                    'success' => false,
                    'errors' => 'Token invalid'
                ]
            ]);
    }

    public function test_token_expirado(): void
    {
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNjk1MTM4MTExLCJleHAiOjE2OTUxMzgxNzEsIm5iZiI6MTY5NTEzODExMSwianRpIjoiZHV2TVFUekJBekhtQmZVbyIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.YvYXlpdvqMKdwl3_MG6PGXul7iVNohuLPiI9AfmlKaw';

        $response2 = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/lead');

        $response2->assertStatus(401)
            ->assertJson([
                'meta' => [
                    'success' => false,
                    'errors' => 'Token expired'
                ]
            ]);
    }

    public function test_token_no_enviado(): void
    {
        $token = '';

        $response2 = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/lead');

        $response2->assertStatus(401)
            ->assertJson([
                'meta' => [
                    'success' => false,
                    'errors' => 'Token absent'
                ]
            ]);
    }
}