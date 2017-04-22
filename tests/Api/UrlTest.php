<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Carbon\Carbon;

class UrlTest extends TestCase
{
    use DatabaseMigrations;

    public function test_create_new_url()
    {
        $postData = [
            'url' => 'http://yahoo.com'
        ];

        $this->post('/url/create', $postData)
            ->seeJsonContains([
                'success' => true
            ])
            ->seeJsonContains([
                'id' => 1,
                'url' => 'http://yahoo.com'
            ]);

        $this->seeInDatabase('urls', ['url' => 'http://yahoo.com']);
    }

    public function test_user_id_is_stored_in_database_when_user_is_logged_in()
    {
        $user = factory(App\User::class)->create();

        $postData = [
            'url' => 'http://yahoo.com'
        ];

        $this->actingAs($user)
            ->post('/url/create', $postData)
            ->seeJsonContains([
                'success' => true
            ])
            ->seeJsonContains([
                'id' => 1,
                'url' => 'http://yahoo.com'
            ]);

        $this->seeInDatabase('urls', [
            'url' => 'http://yahoo.com',
            'user_id' => $user->id
        ]);
    }

    public function test_create_url_with_invalid_url_returns_an_error()
    {
        $url = factory(App\Url::class)->create([
            'url' => 'http://yahoo.com',
            'user_id' => 1
        ]);

        $postData = [
            'id' => $url->id,
            'url' => '//test.com/test'
        ];

        $this->json('POST', '/url/create', $postData)
            ->see('The url format is invalid.');
    }

    public function test_create_url_with_no_url_returns_an_error()
    {
        $url = factory(App\Url::class)->create([
            'url' => 'http://yahoo.com',
            'user_id' => 1
        ]);

        $postData = [
            'id' => $url->id,
            'url' => ''
        ];

        $this->json('POST', '/url/create', $postData)
            ->see('The url field is required.');
    }

    public function test_update_url()
    {
        $url = factory(App\Url::class)->create([
            'url' => 'http://yahoo.com',
            'user_id' => 1
        ]);

        $this->seeInDatabase('urls', ['url' => 'http://yahoo.com']);

        $postData = [
            'id' => $url->id,
            'url' => 'http://test.com/test'
        ];

        $this->json('POST', '/url/update', $postData)
            ->seeJsonContains([
                'success' => true
            ]);

        $this->seeInDatabase('urls', ['url' => 'http://test.com/test']);
    }

    public function test_update_url_with_invalid_url_returns_an_error()
    {
        $url = factory(App\Url::class)->create([
            'url' => 'http://yahoo.com',
            'user_id' => 1
        ]);

        $this->seeInDatabase('urls', ['url' => 'http://yahoo.com']);

        $postData = [
            'id' => $url->id,
            'url' => '//test.com/test'
        ];

        $this->json('POST', '/url/update', $postData)
            ->see('The url format is invalid.');
    }

    public function test_update_url_with_no_url_returns_an_error()
    {
        $url = factory(App\Url::class)->create([
            'url' => 'http://yahoo.com',
            'user_id' => 1
        ]);

        $postData = [
            'id' => $url->id,
            'url' => ''
        ];

        $this->json('POST', '/url/update', $postData)
            ->see('The url field is required.');
    }

    public function test_show_url()
    {
        $url = factory(App\Url::class)->create([
            'url' => 'http://yahoo.com',
            'user_id' => 1
        ]);

        $this->get('/url/' . $url->id)
            ->seeJsonContains([
                'id' => $url->id,
                'url' => 'http://yahoo.com',
                'user_id' => '1',
                'link' => 'http://localhost:8000/' . $url->key
            ]);
    }

    public function test_delete_url()
    {
        $url = factory(App\Url::class)->create([
            'url' => 'http://yahoo.com'
        ]);

        $this->post('/url/delete/' . $url->id)
            ->seeJsonContains([
                'success' => true
            ]);

        $this->notSeeInDatabase('urls', ['url' => 'http://yahoo.com']);
    }

    public function test_url_click_stats_display_properly()
    {
        $user = factory(App\User::class)->create();
        $url = factory(App\Url::class)->create([ 'user_id' => $user->id ]);

        $oneDaysAgo = Carbon::now()->subDay(1);
        $twoDaysAgo = Carbon::now()->subDay(2);
        $sevenDaysAgo = Carbon::now()->subDay(7);
        $tenDaysAgo = Carbon::now()->subDay(10);

        $this->createClicksForStats($url, $twoDaysAgo, $sevenDaysAgo);

        $this->get('url/stats/' . $url->id)
            ->seeJsonContains([
                'date' => $oneDaysAgo->format('m/d'),
                'clicks' => 0
            ])
            ->seeJsonContains([
                'date' => $twoDaysAgo->format('m/d'),
                'clicks' => 3
            ])
            ->seeJsonContains([
                'date' => $sevenDaysAgo->format('m/d'),
                'clicks' => 1
            ])
            ->seeJsonContains([
                'date' => $tenDaysAgo->format('m/d'),
                'clicks' => 0
            ]);
    }

    public function createClicksForStats($url, $twoDaysAgo, $sevenDaysAgo)
    {
        for ($i = 0; $i < 3; $i++) {
            factory(App\Click::class)->create([
                'url_id' => $url->id,
                'created_at' => $twoDaysAgo->toDateTimeString()
            ]);
        }

        factory(App\Click::class)->create([
            'url_id' => $url->id,
            'created_at' => $sevenDaysAgo
        ]);
    }
}
