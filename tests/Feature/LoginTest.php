<?php

namespace Tests\Feature;

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_login_correct_user(){
        $correctUser = User::random()->where('password',Hash::make('password'));
        $response = $this->post('/login',['email'=>$correctUser->email, 'password'=>'password', 'rememberMe' =>false]);
        $response->assertStatus(200);
    }

    public function test_login_wrong_user_password(){
        $inCorrectUser = User::factory()->create(['password' => "password2"]);
        $response = $this->post('/login', ['email' => $inCorrectUser->email, 'password' =>'', 'rememberMe' =>false]);
        $this->assertGuest();
        $response->assertRedirect('/');
    }

    public function test_login_wrong_user_email(){
        $email = 'mary@gmail.com';
        $inCorrectUser = User::factory()->create(['email' => "joohn@gmail.com"]);
        $response = $this->post('/login', ['email' =>$email, 'password'=>'password', 'rememberMe' =>false]);
        $this->assertGuest();
        $response->assertRedirect('/');
    }

    public function test_login_wrong_user_both(){
        $email = 'mary@gmail.com';
        $password = 'password2';
        $response = $this->post('/login', ['email'=>$email, 'password' =>$password, 'rememberMe' =>false]);
        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
