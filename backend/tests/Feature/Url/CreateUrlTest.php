<?php

namespace Tests\Feature\Url;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Url;

class CreateUrlTest extends TestCase
{
    use RefreshDatabase;

    public function test_cannot_create_url_without_url(): void
    {
        $postData = [];
        $this->postJson(route('urls.store'), $postData)
            ->assertStatus(422)
            ->assertJsonFragment(['The url field is required.']);
    }

    public function test_cannot_create_url_without_valid_url(): void
    {
        $postData = [
            'url' => 'this_is_a_test',
        ];

        $this->postJson(route('urls.store'), $postData)
            ->assertStatus(422)
            ->assertJsonFragment(['The url field must be a valid URL.']);
    }

    public function test_can_create_url(): void
    {
        $url = 'https://www.google.com';

        $postData = [
            'url' => 'https://www.google.com',
        ];

        $this->postJson(route('urls.store'), $postData)
            ->assertStatus(200)
            ->assertJsonFragment(['url' => $url])
            ->assertDatabaseHas('urls', ['url' => $url]);
    }
}
