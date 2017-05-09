<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AccountTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_needs_to_be_logged_in_to_view_account_section()
    {
        $this->get('/account')->see('Login');
    }

    /** @test */
    public function index_page_shows_properly()
    {
        $user = factory(User::class)->create();

        $url1 = factory(Url::class)->create([ 'user_id' => $user->id ]);
        $url2 = factory(Url::class)->create([ 'user_id' => $user->id ]);

        factory(Click::class)->create([ 'url_id' => $url1->id ]);
        factory(Click::class)->create([ 'url_id' => $url1->id ]);
        factory(Click::class)->create([ 'url_id' => $url2->id ]);
        factory(Click::class)->create([ 'url_id' => $url2->id ]);
        factory(Click::class)->create([ 'url_id' => $url2->id ]);

        $this->actingAs($user)
            ->visit('/account')
            ->see('Account Overview')
            ->see(1)
            ->see('Days Making Urls Little')
            ->see(3)
            ->see('Urls Made Little')
            ->see(5)
            ->see('Urls Clicked On')
            ->see('Settings')
            ->see('Account Overview');
    }

    /** @test */
    public function urls_page_shows_properly()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->visit('/account/urls')
            ->see('Urls');
    }

    /** @test */
    public function settings_page_shows_properly()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->visit('/account/settings')
            ->see('Account Settings')
            ->see('Personal Information')
            ->see('Update Password');
    }
}
