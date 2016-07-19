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

        $this->actingAs($user)
            ->visit('/account')
            ->see('Account Overview')
            ->see('Urls')
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
            ->see('Account Settings');
    }
}
