<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use \App\User;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function test_it_calculates_totals_correctly()
    {
        $user = factory(App\User::class)->create();

        $url1 = factory(App\Url::class)->create(['user_id' => $user->id]);
        $url2 = factory(App\Url::class)->create(['user_id' => $user->id]);

        factory(App\Click::class)->create(['url_id' => $url1->id]);
        factory(App\Click::class)->create(['url_id' => $url1->id]);
        factory(App\Click::class)->create(['url_id' => $url2->id]);
        factory(App\Click::class)->create(['url_id' => $url2->id]);
        factory(App\Click::class)->create(['url_id' => $url2->id]);

        $this->assertEquals(0, $user->daysMakingUrlsLittle());
        $this->assertEquals(2, $user->urlsMade());
        $this->assertEquals(5, $user->urlsClickedOn());
    }
}
