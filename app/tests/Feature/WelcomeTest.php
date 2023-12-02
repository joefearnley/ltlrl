<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WelcomeTest extends TestCase
{
    use RefreshDatabase;

    public function test_welcome_page_displays_correctly(): void
    {
        $this->get(route('welcome'))
            ->assertStatus(200)
            ->assertSee('Log in')
            ->assertSee('Register')
            ->assertSee('enter a URL and...')
            ->assertSee('Make it Little')
            ->assertSee('ltlrl');
    }

    public function test_cannot_create_url_without_url(): void
    {
        $postData = [];

        $this->from(route('welcome'))
            ->post(route('welcome.create-url'), $postData)
            ->assertStatus(302)
            ->assertSessionHasErrors('url')
            ->assertRedirect(route('welcome'));
    }

    public function test_creating_url_on_welcome_page_redirects_you_back_to_welcome_page(): void
    {
        $url = 'https://www.google.com';

        $postData = [
            'url' => $url,
        ];

        $this->from(route('welcome'))
            ->post(route('welcome.create-url'), $postData)
            ->assertStatus(302)
            ->assertSessionHas('littleUrl')
            ->assertRedirect(route('welcome'));

        $this->assertDatabaseHas('urls', [
            'title' => null,
            'url' => $url,
            'user_id' => null,
        ]);
    }
}

