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
}
