<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * Enviando Informacion Completa
     */

    public function test_login_correcto()
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
    }

    /**
     * Sin Informacion enviada
     */
    public function test_login_sin_datos_enviados()
    {
        $response = $this->json('POST', '/api/auth', []);
        $response->assertStatus(401)
            ->assertJsonStructure([
                'meta' => [
                    'success',
                    'errors'
                ]
            ]);


    }

    /**
     * Enviando Informacion incompleta
     */
    public function test_login_informacion_incompleta()
    {
        $response = $this->json('POST', '/api/auth', [
            'username' => 'tester'
        ]);
        $response->assertStatus(401)
            ->assertJsonStructure([
                'meta' => [
                    'success',
                    'errors'
                ]
            ]);


    }

    /**
     * Enviando Informacion completa datos erroneos
     */
    public function test_login_informacion_completa_datos_erroneos()
    {
        $response = $this->json('POST', '/api/auth', [
            'username' => 'tester'
        ]);
        $response->assertStatus(401)
            ->assertJsonStructure([
                'meta' => [
                    'success',
                    'errors'
                ]
            ]);


    }
}
