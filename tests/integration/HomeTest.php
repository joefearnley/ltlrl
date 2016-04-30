<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class HomeTest extends TestCase
{
    use DatabaseMigrations;

    public function test_home_page_show_main_form()
    {
        $this->visit('/')
             ->see('Little URL');
    }

    public function test_main_form_requires_url()
    {
        $this->visit('/')
            ->see('Little URL')
            ->press('Make it Little')
            ->seePageIs('/')
            ->see('The url field is required');
    }

    public function test_main_form_requires_valid_url()
    {
        $this->visit('/')
            ->see('Little URL')
            ->type('sdfasdfs', 'url')
            ->press('Make it Little')
            ->seePageIs('/')
            ->see('The url format is invalid');
    }

    public function test_main_form_displays_new_link_after_submitted()
    {
        $this->visit('/')
            ->see('Little URL')
            ->type('http://google.com', 'url')
            ->press('Make it Little')
            ->seePageIs('/')
            ->see('URL has been made little!');
    }

    public function test_main_form_creates_url_in_database()
    {
        $this->visit('/')
            ->see('Little URL')
            ->type('http://yahoo.com', 'url')
            ->press('Make it Little')
            ->seePageIs('/')
            ->see('URL has been made little!')
            ->seeInDatabase('urls', ['url' => 'http://yahoo.com']);
    }

    public function test_user_id_is_stored_in_database_when_user_is_logged_in()
    {
        $user = factory(App\User::class)->create();

        $this->actingAs($user)
            ->visit('/')
            ->see('Little URL')
            ->type('http://yahoo.com', 'url')
            ->press('Make it Little')
            ->seePageIs('/')
            ->see('URL has been made little!')
            ->seeInDatabase('urls', [
                'url' => 'http://yahoo.com',
                'user_id' => $user->id
            ]);
    }

    public function test_little_url_redirect_to_correct_url()
    {
        $key = '54kkjh';

        factory(App\Url::class)->create([
            'url' => 'http://google.com',
            'key' => $key
        ]);

        $this->visit('/' . $key)
            ->see('Google');
    }

    public function test_user_sees_404_when_url_is_not_found()
    {
        $response = $this->call('GET', '/2r23f23f32');

        $this->assertEquals(404, $response->status());
    }
}
