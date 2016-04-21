<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class AccountTest extends TestCase
{
    use DatabaseMigrations;

    public function test_account_page_shows_properly()
    {
        $this->visit('/account')
             ->see('Account');
    }

}
