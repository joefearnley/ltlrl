<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Url;

class HomeTest extends TestCase
{
    use DatabaseMigrations;

    public function test_home_page_show_main_form()
    {
        $this->get('/')
            ->assertSee('Little URL');
    }

    public function test_little_url_redirect_to_correct_url()
    {
        $url = factory(Url::class)->create([
            'url' => 'http://yahoo.com'
        ]);

        $this->get('/' . $url->key)
            ->assertRedirect('http://yahoo.com');
    }

    public function test_clicks_is_increased_when_an_url_is_hit()
    {
        $url = factory(Url::class)->create([
            'url' => 'http://yahoo.com'
        ]);

        $this->get('/' . $url->key);

        $url = Url::find($url->id);

        $this->assertEquals(1, $url->clicks->count());
    }

    public function test_click_record_created_when_url_is_hit()
    {
        $url = factory(Url::class)->create([
            'url' => 'http://yahoo.com'
        ]);

        $this->get('/' . $url->key);
        $url = Url::find($url->id);
        $this->assertEquals(1, $url->clicks->count());

        $this->get('/' . $url->key);
        $url = Url::find($url->id);
        $this->assertEquals(2, $url->clicks->count());

        $this->assertDatabaseHas('clicks', [
            'url_id' => $url->id
        ]);
    }

    public function test_user_sees_404_when_url_is_not_found()
    {
        $this->get('/2r23f23f32')->assertStatus(404);
    }

}
