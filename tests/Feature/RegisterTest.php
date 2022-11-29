<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Generator as Faker;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;


class RegisterTest extends TestCase
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

    public function register_page_loads(){
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function register_a_new_user(){
        $faker = new Faker();
        $username = $faker->unique()->userName();
        $color = $faker->hexColor();
        $credentials = [
            'username' => $username,
            'email' => $faker->unique()->safeEmail(),
            'dob' => $faker->date($format='d-m-Y', $max='-13 years'),
            'profile_pic' => "https://eu.ui-avatars.com/api/?name=".$username."&background=".substr($color, 1),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ];
        $response = $this->post('/register', [
            'username' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/');
    }

    public function register_a_new_user_email_exists(){
        $user = User::where('auth_type', null)->first();

        $faker = new Faker();
        $username = $faker->unique()->userName();
        $color = $faker->hexColor();
        $credentials = [
            'username' => $username,
            'email' => $user->email,
            'dob' => $faker->date($format='d-m-Y', $max='-13 years'),
            'profile_pic' => "https://eu.ui-avatars.com/api/?name=".$username."&background=".substr($color, 1),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ];
        $response = $this->post('/register', $credentials);
        $response->assertRedirect('/register');
        $response->assertSessionHasErrors();

    }

    public function register_a_new_user_username_exists(){
        $user = User::where('auth_type', null)->first();

        $faker = new Faker();
        $color = $faker->hexColor();
        $credentials = [
            'username' => $user->username,
            'email' => $faker->unique()->safeEmail(),
            'dob' => $faker->date($format='d-m-Y', $max='-13 years'),
            'profile_pic' => "https://eu.ui-avatars.com/api/?name=".$user->username."&background=".substr($color, 1),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ];
        $response = $this->post('/register', $credentials);
        $response->assertRedirect('/register');
        $response->assertSessionHasErrors();
    }


}
