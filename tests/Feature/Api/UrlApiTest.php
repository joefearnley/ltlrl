<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Carbon\Carbon;
use App\User;
use App\Click;
use App\Url;

class UrlApiTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function create_new_url()
    {
        $postData = [
            'url' => 'http://yahoo.com'
        ];

        $this->post('/url/create', $postData)
            ->assertStatus(200)
            ->assertJsonFragment([
                'id' => 1,
                'url' => 'http://yahoo.com'
            ]);

        $this->assertDatabaseHas('urls', ['url' => 'http://yahoo.com']);
    }

    /** @test */
    public function user_id_is_stored_in_database_when_user_is_logged_in()
    {
        $user = factory(User::class)->create();

        $postData = [
            'url' => 'http://yahoo.com'
        ];

        $this->actingAs($user)
            ->post('/url/create', $postData)
            ->assertStatus(200)
            ->assertJsonFragment([
                'id' => 1,
                'url' => 'http://yahoo.com'
            ]);

        $this->assertDatabaseHas('urls', [
            'url' => 'http://yahoo.com',
            'user_id' => $user->id
        ]);
    }

    /** @test */
    public function create_url_with_invalid_url_returns_an_error()
    {
        $url = factory(Url::class)->create([
            'url' => 'http://yahoo.com',
            'user_id' => 1
        ]);

        $postData = [
            'id' => $url->id,
            'url' => '//test.com/test'
        ];

        $this->json('POST', '/url/create', $postData)
            ->assertStatus(422)
            ->assertJsonFragment(['The url format is invalid.']);
    }

    /** @test */
    public function create_url_with_no_url_returns_an_error()
    {
        $url = factory(Url::class)->create([
            'url' => 'http://yahoo.com',
            'user_id' => 1
        ]);

        $postData = [
            'id' => $url->id,
            'url' => ''
        ];

        $this->json('POST', '/url/create', $postData)
            ->assertStatus(422)
            ->assertJsonFragment(['The url field is required.']);
    }

    /** @test */
    public function update_url()
    {
        $url = factory(Url::class)->create([
            'url' => 'http://yahoo.com',
            'user_id' => 1
        ]);

        $this->assertDatabaseHas('urls', ['url' => 'http://yahoo.com']);

        $postData = [
            'id' => $url->id,
            'url' => 'http://test.com/test'
        ];

        $this->json('POST', '/url/update', $postData)
            ->assertStatus(200)
            ->assertJsonFragment([
                'success' => true
            ]);

        $this->assertDatabaseHas('urls', ['url' => 'http://test.com/test']);
    }

    /** @test */
    public function update_url_with_invalid_url_returns_an_error()
    {
        $url = factory(Url::class)->create([
            'url' => 'http://yahoo.com',
            'user_id' => 1
        ]);

        $this->assertDatabaseHas('urls', ['url' => 'http://yahoo.com']);

        $postData = [
            'id' => $url->id,
            'url' => '//test.com/test'
        ];

        $this->json('POST', '/url/update', $postData)
            ->assertStatus(422)
            ->assertJsonFragment(['The url format is invalid.']);
    }

    /** @test */
    public function update_url_with_no_url_returns_an_error()
    {
        $url = factory(Url::class)->create([
            'url' => 'http://yahoo.com',
            'user_id' => 1
        ]);

        $postData = [
            'id' => $url->id,
            'url' => ''
        ];

        $this->json('POST', '/url/update', $postData)
            ->assertStatus(422)
            ->assertJsonFragment(['The url field is required.']);
    }

    /** @test */
    public function show_url()
    {
        $url = factory(Url::class)->create([
            'url' => 'http://yahoo.com',
            'user_id' => 1
        ]);

        $this->get('/url/' . $url->id)
            ->assertStatus(200)
            ->assertJsonFragment([
                'id' => $url->id,
                'url' => 'http://yahoo.com',
                'user_id' => '1',
                'short_url' => 'http://localhost:8000/' . $url->key
            ]);
    }

    /** @test */
    public function delete_url()
    {
        $url = factory(Url::class)->create([
            'url' => 'http://yahoo.com'
        ]);

        $this->post('/url/delete/' . $url->id)
            ->assertStatus(200)
            ->assertJsonFragment([
                'success' => true
            ]);

        $this->assertDatabaseMissing('urls', ['url' => 'http://yahoo.com']);
    }

    /** @test */
    public function delete_url_and_clicks()
    {
        $url = factory(Url::class)->create([
            'url' => 'http://yahoo.com'
        ]);

        $click = factory(Click::class)->create([
            'url_id' => $url->id
        ]);

        $this->post('/url/delete/' . $url->id)
            ->assertStatus(200)
            ->assertJsonFragment([
                'success' => true
            ]);

        $this->assertDatabaseMissing('urls', ['id' => "$url->id"]);
        $this->assertDatabaseMissing('clicks', ['id' => "$click->id"]);
    }

    /** @test */
    public function url_click_stats_display_properly()
    {
        $user = factory(User::class)->create();
        $url = factory(Url::class)->create([
            'user_id' => $user->id
        ]);

        $oneDaysAgo = Carbon::now()->subDay(1);
        $twoDaysAgo = Carbon::now()->subDay(2);
        $sevenDaysAgo = Carbon::now()->subDay(7);
        $tenDaysAgo = Carbon::now()->subDay(10);

        $this->createClicksForStats($url, $twoDaysAgo, $sevenDaysAgo);

        $this->get('url/stats/' . $url->id)
            ->assertStatus(200)
            ->assertJsonFragment([
                'date' => $oneDaysAgo->format('m/d'),
                'clicks' => 0
            ])
            ->assertJsonFragment([
                'date' => $twoDaysAgo->format('m/d'),
                'clicks' => 3
            ])
            ->assertJsonFragment([
                'date' => $sevenDaysAgo->format('m/d'),
                'clicks' => 1
            ])
            ->assertJsonFragment([
                'date' => $tenDaysAgo->format('m/d'),
                'clicks' => 0
            ]);
    }

    public function createClicksForStats($url, $twoDaysAgo, $sevenDaysAgo)
    {
        for ($i = 0; $i < 3; $i++) {
            factory(Click::class)->create([
                'url_id' => $url->id,
                'created_at' => $twoDaysAgo->toDateTimeString()
            ]);
        }

        factory(Click::class)->create([
            'url_id' => $url->id,
            'created_at' => $sevenDaysAgo
        ]);
    }
}
