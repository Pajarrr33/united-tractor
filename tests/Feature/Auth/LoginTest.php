<?php

namespace Tests\Feature\Auth;

use Database\Seeders\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testLoginSuccess()
    {
        $this->seed([User::class]);
        $this->post('/api/login', [
            'email' => 'tokoweb@gmail.com',
            'password' => 'tokoweb'
        ])->assertStatus(200)
            ->assertJson([
                'data' => [
                    'email' => 'tokoweb@gmail.com',
                ]
            ]);
    }

    public function testLoginFailedEmailNotFound()
    {
        $this->post('/api/login', [
            'email' => 'asasasasa@gmail.com',
            'password' => 'tokoweb'
        ])->assertStatus(401)
            ->assertJson([
                'erros' => [
                    'email' => 'Email or password is wrong'
                ]
            ]);
    }

    public function testLoginFailedPasswordWrong()
    {
        $this->seed([User::class]);
        $this->post('/api/login', [
            'email' => 'tokoweb@gmail.com',
            'password' => '1234567'
        ])->assertStatus(401)
            ->assertJson([
                'erros' => [
                    'email' => 'Email or password is wrong'
                ]
            ]);
    }
}
