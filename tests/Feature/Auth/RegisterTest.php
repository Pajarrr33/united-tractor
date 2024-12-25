<?php

namespace Tests\Feature\Auth;

use Database\Seeders\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testRegisterSuccess()
    {
        $this->post('/api/register', [
            'email' => 'tokoweb@gmail.com',
            'password' => 'tokoweb'
        ])->assertStatus(201)
            ->assertJson([
                'data' => [
                    'email' => 'tokoweb@gmail.com',
                ]
            ]);
    }

    public function testRegisterFailed()
    {
        $this->post('/api/register', [
            'email' => '',
            'password' => ''
        ])->assertStatus(400)
            ->assertJson([
                'errors' => [
                    'email' => [
                        "The email field is required."
                    ],
                    "password" => [
                        "The password field is required."
                    ],
                ]
            ]);
    }

    public function testRegisterEmailAlreadyExists()
    {
        $this->seed([User::class]);
        $this->post('/api/register', [
            'email' => 'tokoweb@gmail.com',
            'password' => 'tokoweb'
        ])->assertStatus(400)
            ->assertJson([
                'erros' => [
                    'email' => 'Email already exist'
                ]
            ]);
    }
}
