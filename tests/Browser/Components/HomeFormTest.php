<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class HomeFormTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function page_loads()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Make it Little');
        });
    }

    /** @test */
    public function create_url()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Little Url');
        });
    }
}
