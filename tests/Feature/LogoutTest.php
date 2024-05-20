<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LogoutTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_an_autenticated_user_can_logout(): void
    {
        $this->withoutExceptionHandling();
        $john = User::factory()->create();
        $this->be($john);
        
        $this->delete('/logout')->assertRedirect('/login');
        $this->assertNull(auth()->user());
    }
    public function test_only_an_authenticated_user_can_logout(): void
    {
        $this->delete('/logout')->assertRedirect('/login');
    }
}
