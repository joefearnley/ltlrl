<?php

namespace Tests\Feature\Url;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Url;

class DeleteUrlTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_cannot_delete_url_when_not_authenticated(): void
    {
        $url = Url::factory()->create();

        $newTitle = 'Google';
        $newUrl = 'https://www.google.com';

        $formData = [
            'title' => $newTitle,
            'url' => $newUrl,
        ];

        $this->delete(route('urls.destroy', $url), $formData)
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    public function test_can_delete_url(): void
    {
        $url = Url::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $this->actingAs($this->user)
            ->from(route('urls.index'))
            ->delete(route('urls.destroy', $url))
            ->assertStatus(302)
            ->assertSessionHasNoErrors()
            ->assertSessionHas('message')
            ->assertSessionHas('urlTitle')
            ->assertSessionHas('littleUrl')
            ->assertRedirect(route('urls.index'));

        $this->assertDatabaseMissing('urls', [
            'id' => $url->id,
            'url' => $url->url,
        ]);
    }

    public function test_cannot_delete_url_user_does_not_own(): void
    {
        $differentUser = User::factory()->create();
        $differentUsersUrl = Url::factory()->create([
            'user_id' => $differentUser->id,
        ]);

        $this->actingAs($this->user)
            ->from(route('urls.index'))
            ->delete(route('urls.update', $differentUsersUrl))
            ->assertStatus(403);
    }
}
