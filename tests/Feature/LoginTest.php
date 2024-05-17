<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    /*** @test */
    public function test_when_user_give_his_credentials_to_auth(): void
    {


        $this->withoutExceptionHandling();

        $john = User::factory()->create();

        $credentials = [
            'email' => $john->email,
            'password' => 'password',
        ];


        $this->post('/login', $credentials)->assertRedirect(route('dashboard'));
        $this->assertEquals(auth()->id(), $john->id);


    }

    /**@test
     * A user must provide an existing email to be authenticated.
     *
     */
    public function test_to_be_authenticated_a_user_must_provide_existing_email(){

        $credentials = [
            'email' => 'not-existing@example.com',
            'password' => 'password',
        ];

        $this->post('/login', $credentials)->assertSessionHasErrors('email');

    }

    /**
     * A user must provide a valid email to be authenticated.
     *
     */
    public function test_to_be_authenticated_a_user_must_provide_valid_email(){

        $credentials = [
            'email' => 'not-valid-email',
            'password' => 'password',
        ];

        $this->post('/login', $credentials)->assertSessionHasErrors('email');

    }

    public function test_authentication_a_user_must_require_email(){

        $credentials = [
            'email' => '',
            'password' => 'password',
        ];

        $this->post('/login', $credentials)->assertSessionHasErrors('email');

    }

    public function test_authentication_required_password(){

        $credentials = [
            'email' => 'existing@example.com',
            'password' => '',
        ];

        $this->post('/login', $credentials)->assertSessionHasErrors('password');

    }

    /**
     * A user must provide correct credentials to be authenticated.
     */
    public function test_to_be_authenticated_user_must_provide_correct_password(){
         
        // $this->withoutExceptionHandling();

        $john = User::factory()->create();

        $credentials = [
            'email' => $john->email,
            'password' => 'fake-password',
        ];

        
        $this->post('/login', $credentials)->assertSessionHasErrors('email');

    }


}
