<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HomeTest extends TestCase
{
    public function testHomePageShowMainForm()
    {
        $this->visit('/')
             ->see('Little URL');
    }

    public function testMainFormDisplaysNewLinkAfterSubmitted()
    {
        $this->visit('/')
            ->see('Little URL')
            ->type('http://google.com', 'url')
            ->press('Make Little')
            ->seePageIs('/')
            ->see('URL has been made little!');
    }

    public function testMainFormCreatesUrlInDatabase()
    {
        $this->visit('/')
            ->see('Little URL')
            ->type('http://google.com', 'url')
            ->press('Make Little')
            ->seePageIs('/')
            ->see('URL has been made little!');
    }
}
