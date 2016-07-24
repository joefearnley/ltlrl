<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class AccountTest extends TestCase
{
    use DatabaseMigrations;

    public function test_user_needs_to_be_logged_in_to_view_account_section()
    {
        $this->visit('/account')
            ->see('Login');
    }

    public function test_index_page_shows_properly()
    {
        $user = factory(App\User::class)->create();

        $url1 = factory(App\Url::class)->create([ 'user_id' => $user->id ]);
        $url2 = factory(App\Url::class)->create([ 'user_id' => $user->id ]);
        $url3 = factory(App\Url::class)->create([ 'user_id' => $user->id ]);

        $click1 = factory(App\Click::class)->create([ 'url_id' => $url1->id ]);
        $click2 = factory(App\Click::class)->create([ 'url_id' => $url1->id ]);
        $click3 = factory(App\Click::class)->create([ 'url_id' => $url2->id ]);

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

    public function test_urls_page_shows_properly()
    {
        $user = factory(App\User::class)->create();

        $this->actingAs($user)
            ->visit('/account/urls')
            ->see('Urls');
    }

    public function test_settings_page_shows_properly()
    {
        $user = factory(App\User::class)->create();

        $this->actingAs($user)
            ->visit('/account/settings')
            ->see('Account Settings')
            ->see('Personal Information')
            ->see('Update Password');
    }
}
