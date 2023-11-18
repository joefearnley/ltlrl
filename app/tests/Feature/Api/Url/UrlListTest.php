<?php

namespace Tests\Feature\Api\Url;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Url;

class UrlListTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_is_redirected_when_not_authenticated(): void
    {
        $this->getJson(route('urls.index'))
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    public function test_url_list_is_empty_when_user_does_not_have_any_urls(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->getJson(route('urls.index'))
            ->assertStatus(200)
            ->assertJson([]);
    }

    public function test_user_can_see_urls(): void
    {
        $user = User::factory()->create();
        $urls = Url::factory()->count(3)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->getJson(route('urls.index'));

        $response->assertStatus(200);

        foreach($urls as $url) {
            $response->assertJsonFragment([
                'id' => $url->id,
                'title' => $url->title,
                'url' => $url->url,
                'little_url' => $url->little_url,
                'created_at' => $url->created_at->format('M j, Y'),
            ]);

            $this->assertDatabaseHas('urls', [
                'title' => $url->title,
                'url' => $url->url,
                'user_id' => $user->id,
                'key' => $url->key,
            ]);
        }
    }

    public function test_cannot_see_other_users_urls(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $userUrls = Url::factory()->count(3)->create([
            'user_id' => $user->id,
        ]);

        $otherUserUrls = Url::factory()->count(3)->create([
            'user_id' => $otherUser->id,
        ]);


        $response = $this->actingAs($user)
            ->getJson(route('urls.index'));

        $response->assertStatus(200);

        foreach($userUrls as $url) {
            $response->assertJsonFragment([
                'id' => $url->id,
                'title' => $url->title,
                'url' => $url->url,
                'little_url' => $url->little_url,
                'created_at' => $url->created_at->format('M j, Y'),
            ]);

            $this->assertDatabaseHas('urls', [
                'title' => $url->title,
                'url' => $url->url,
                'user_id' => $user->id,
                'key' => $url->key,
            ]);
        }

        foreach($otherUserUrls as $otherUserUrl) {
            $response->assertJsonMissing([
                'id' => $otherUserUrl->id,
                'title' => $otherUserUrl->title,
                'url' => $otherUserUrl->url,
                'little_url' => $otherUserUrl->little_url,
            ]);

            $this->assertDatabaseMissing('urls', [
                'title' => $otherUserUrl->title,
                'url' => $otherUserUrl->url,
                'user_id' => $user->id,
                'key' => $otherUserUrl->key,
            ]);
        }
    }
}
