<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Pages\Home;

class HomeTest extends DuskTestCase
{
    /** @test */
    public function it_should_see_the_homepage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Home)
                ->assertSee('Little URL')
                ->assertSee('Make it Little');
        });
    }

    /** @test */
    public function it_should_see_error_when_url_format_is_invalid()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Home)
                ->press('Make it Little')
                ->assertSee('The url format is invalid.');
        });
    }
}
