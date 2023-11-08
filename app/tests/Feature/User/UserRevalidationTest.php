<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserRevalidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_revalidation_endpoint_when_user_is_authenticated(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->getJson('/api/user')
            ->assertStatus(200)
            ->assertJson($user->toArray());
    }

    public function test_revalidation_endpoint_when_user_is_not_authenticated(): void
    {
        $this->getJson('/api/user')
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }
}
