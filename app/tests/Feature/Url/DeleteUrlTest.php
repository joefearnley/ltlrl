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

    public function test_cannot_update_url_when_not_authenticated(): void
    {
        $url = Url::factory()->create();

        $newTitle = 'Google';
        $newUrl = 'https://www.google.com';

        $formData = [
            'title' => $newTitle,
            'url' => $newUrl,
        ];

        $this->patch(route('urls.update', $url), $formData)
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    public function test_cannot_update_url_with_no_form_data(): void
    {
        $url = Url::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $formData = [];

        $response = $this->actingAs($this->user)
            ->from(route('urls.edit', $url->id))
            ->patch(route('urls.update', $url), $formData)
            ->assertStatus(302)
            ->assertSessionHasErrors(['url' => 'The url field is required.'])
            ->assertRedirect(route('urls.edit', $url->id));
    }

    public function test_cannot_update_url_with_no_url(): void
    {
        $url = Url::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $formData = [
            'url' => ''
        ];

        $this->actingAs($this->user)
            ->from(route('urls.edit', $url->id))
            ->patch(route('urls.update', $url), $formData)
            ->assertStatus(302)
            ->assertSessionHasErrors(['url' => 'The url field is required.'])
            ->assertRedirect(route('urls.edit', $url->id));
    }

    public function test_can_update_url(): void
    {
        $url = Url::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $newUrl = 'https://yahoo.com';

        $formData = [
            'url' => $newUrl,
        ];

        $this->actingAs($this->user)
            ->from(route('urls.edit', $url->id))
            ->patch(route('urls.update', $url), $formData)
            ->assertStatus(302)
            ->assertSessionHasNoErrors()
            ->assertSessionHas('message')
            ->assertSessionHas('littleUrl')
            ->assertRedirect(route('urls.index'));

        $this->assertDatabaseHas('urls', [
            'url' => $newUrl,
            'user_id' => $this->user->id,
        ]);
    }

    public function test_can_update_title_and_url(): void
    {
        $url = Url::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $newTitle = 'Google';
        $newUrl = 'https://www.google.com';

        $formData = [
            'title' => $newTitle,
            'url' => $newUrl,
        ];

        $this->actingAs($this->user)
            ->from(route('urls.edit', $url->id))
            ->patch(route('urls.update', $url), $formData)
            ->assertStatus(302)
            ->assertSessionHasNoErrors()
            ->assertSessionHas('message')
            ->assertSessionHas('littleUrl')
            ->assertRedirect(route('urls.index'));

        $this->assertDatabaseHas('urls', [
            'title' => $newTitle,
            'url' => $newUrl,
            'user_id' => $this->user->id,
        ]);
    }
}
