<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UrlListTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_is_redirected_when_not_authenticated(): void
    {
        $this->getJson(route('urls.index'))
            ->assertStatus(302 )
            ->assertRedirect('/login');
    }

    // public function test_url_list_is_empty_when_user_does_not_have_any_urls(): void
    // {
    //     $user = User::factory()->create();

    //     $this->actingAs($user)
    //         ->getJson(route('urls.index'))
    //         ->assertStatus(200);
    // }
}
