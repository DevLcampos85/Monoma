<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CheckTokenTest extends TestCase
{
    public function test_check_login()
    {
        /**
         * Enviando Informacion Completa
         */
        $response = $this->json('POST', '/api/login', [
            'username' => 'tester',
            'password' => 'PASSWORD'
        ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonStructure(['success', 'token']);

        $token = $response->json('token');

        $response2 = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/test');

        $response2->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonStructure(['success', 'data']);
    }

    public function test_check_invalid_token()
    {
        /**
         * Verificar Validacion de Token (Token Invalido)
         */

        $response = $this->json('POST', '/api/login', [
            'username' => 'tester',
            'password' => 'PASSWORD'
        ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonStructure(['success', 'token']);

        $token = $response->json('token');

        $response2 = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token . 'asdfadsf',
        ])->post('/api/test');

        $response2->assertStatus(401)
            ->assertJsonStructure(['success', 'message'])
            ->assertJson(['success' => false])
            ->assertJson(['message' => 'Token Signature could not be verified.']);
    }

    public function test_check_token_expired()
    {
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNjk1MTM4MTExLCJleHAiOjE2OTUxMzgxNzEsIm5iZiI6MTY5NTEzODExMSwianRpIjoiZHV2TVFUekJBekhtQmZVbyIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.YvYXlpdvqMKdwl3_MG6PGXul7iVNohuLPiI9AfmlKaw';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/test');

        $response->assertStatus(400)
            ->assertJsonStructure(['success', 'message'])
            ->assertJson(['success' => false])
            ->assertJson(['message' => 'Token has expired']);
    }
}
