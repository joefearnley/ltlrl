<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use \App\Libraries\AccountTotals;

class AccountTotalTest extends TestCase
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

        $accountTotals = new AccountTotals($user);
        $accountTotals->calculate();

        $this->assertEquals(0, $accountTotals->getDaysMakingUrlsLittle());
        $this->assertEquals(2, $accountTotals->getUrlsMade());
        $this->assertEquals(5, $accountTotals->getUrlsClickedOn());
    }
}
