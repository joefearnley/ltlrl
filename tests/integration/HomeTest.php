<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

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
            ->see('');
    }

//    public function test_main_form_displays_new_link_after_submitted()
//    {
//        $this->visit('/')
//            ->see('Little URL')
//            ->type('http://google.com', 'url')
//            ->press('Make it Little')
//            ->seePageIs('/')
//            ->see('URL has been made little!');
//    }

//    public function test_main_Form_creates_url_in_database()
//    {
//        $this->visit('/')
//            ->see('Little URL')
//            ->type('http://google.com', 'url')
//            ->press('Make Little')
//            ->seePageIs('/')
//            ->see('URL has been made little!');
//    }
}
