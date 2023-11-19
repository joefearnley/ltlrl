<?php

namespace Tests\Feature\Api\Url;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Url;

class DeleteUrlTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_delete_url_when_unauthenticated(): void
    {
        $url = Url::factory()->create();

        $this->deleteJson(route('api.urls.destroy', ['url' => $url->id]))
            ->assertStatus(401);
    }

    public function test_can_delete_url(): void
    {
        $user = User::factory()->create();
        $url = Url::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->actingAs($user)
            ->deleteJson(route('api.urls.destroy', ['url' => $url->id]))
            ->assertStatus(200);

        $this->assertDatabaseMissing('urls', [
            'id' => $url->id,
            'title' => $url->title,
            'url' => $url->url,
            'user_id' => $user->id,
        ]);
    }
}
