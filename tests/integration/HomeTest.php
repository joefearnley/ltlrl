<?php

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

    public function test_main_form_creates_url_in_database()
    {
        $this->visit('/')
            ->see('Little URL')
            ->type('http://yahoo.com', 'url')
            ->press('Make it Little')
            ->seeInDatabase('urls', ['url' => 'http://yahoo.com']);
    }

    public function test_user_id_is_stored_in_database_after_url_is_created_when_user_is_logged_in()
    {
        $user = factory(App\User::class)->create();

        $this->actingAs($user)
            ->visit('/')
            ->see('Little URL')
            ->type('http://yahoo.com', 'url')
            ->press('Make it Little')
            ->seeInDatabase('urls', [
                'url' => 'http://yahoo.com',
                'user_id' => $user->id
            ]);
    }

    public function test_little_url_redirect_to_correct_url()
    {
        $url = factory(App\Url::class)->create([
            'url' => 'http://yahoo.com'
        ]);

        $this->visit('/' . $url->key)
            ->see('Yahoo');
    }

    public function test_clicks_is_increased_when_an_url_is_hit()
    {
        $url = factory(App\Url::class)->create([
            'url' => 'http://yahoo.com'
        ]);

        $this->visit('/' . $url->key);

        $url = Url::find($url->id);

        $this->assertEquals(1, $url->clicks->count());
    }

    public function test_click_record_created_when_url_is_hit()
    {
        $url = factory(App\Url::class)->create([
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
