<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Url;

class HomeTest extends TestCase
{
    use DatabaseMigrations;

    public function test_home_page_show_main_form()
    {
        $this->visit('/')
            ->see('Little URL');
    }

    public function test_little_url_redirect_to_correct_url()
    {
        $url = factory(Url::class)->create([
            'url' => 'http://yahoo.com'
        ]);

        $this->visit('/' . $url->key)
            ->see('Yahoo');
    }

    public function test_clicks_is_increased_when_an_url_is_hit()
    {
        $url = factory(Url::class)->create([
            'url' => 'http://yahoo.com'
        ]);

        $this->visit('/' . $url->key);

        $url = Url::find($url->id);

        $this->assertEquals(1, $url->clicks->count());
    }

    public function test_click_record_created_when_url_is_hit()
    {
        $url = factory(Url::class)->create([
            'url' => 'http://yahoo.com'
        ]);

        $this->visit('/' . $url->key);
        $url = Url::find($url->id);
        $this->assertEquals(1, $url->clicks->count());

        $this->visit('/' . $url->key);
        $url = Url::find($url->id);
        $this->assertEquals(2, $url->clicks->count());

        $this->seeInDatabase('clicks', [
            'url_id' => $url->id
        ]);
    }

    public function test_user_sees_404_when_url_is_not_found()
    {
        $response = $this->call('GET', '/2r23f23f32');

        $this->assertEquals(404, $response->status());
    }

}
