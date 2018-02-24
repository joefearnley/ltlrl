<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use Illuminate\Support\Facades\Auth;

class LogoutTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_is_logged_out_when_the_logout_route_is_hit()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $this->assertTrue(Auth::check());
        $this->get('logout')
            ->assertRedirect('login');

        $this->assertFalse(Auth::check());
    }
}
