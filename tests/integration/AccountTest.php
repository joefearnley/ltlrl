<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class AccountTest extends TestCase
{
    use DatabaseMigrations;

    public function test_user_needs_to_be_logged_in_to_view_account_section()
    {
        $this->visit('/account/dashboard')
            ->see('Login');
    }

    public function test_account_page_shows_properly()
    {
        $user = factory(App\User::class)->create();

        $this->actingAs($user)
            ->visit('/account/dashboard')
            ->see('Account Overview')
            ->see('Settings');
    }

//    public function test_

}
