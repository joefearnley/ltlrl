<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Carbon\Carbon;

class ClickTest extends TestCase
{
    use DatabaseMigrations;

    public function test_url_click_stats_display_properly()
    {
        $user = factory(App\User::class)->create();

        $oneDaysAgo = Carbon::now()->subDay(1);
        $twoDaysAgo = Carbon::now()->subDay(2);
        $sevenDaysAgo = Carbon::now()->subDay(7);
        $tenDaysAgo = Carbon::now()->subDay(10);

        $url = factory(App\Url::class)->create([ 'user_id' => $user->id ]);

        $this->createClicksForStats($url, $twoDaysAgo, $sevenDaysAgo);

        $this->json('GET', 'click/stats/' . $url->id)
            ->seeJson([
                'date' => $oneDaysAgo->format('m/d/Y'),
                'clicks' => '0'
            ])
            ->seeJson([
                'date' => $twoDaysAgo->format('m/d/Y'),
                'clicks' => '2'
            ])
            ->seeJson([
                'date' => $sevenDaysAgo->format('m/d/Y'),
                'clicks' => '1'
            ])
            ->seeJson([
                'date' => $tenDaysAgo->format('m/d/Y'),
                'clicks' => '0'
            ]);
    }

    public function createClicksForStats($url, $twoDaysAgo, $sevenDaysAgo)
    {
        factory(App\Click::class)->create([
            'url_id' => $url->id,
            'created_at' => $twoDaysAgo->toDateTimeString()
        ]);

        factory(App\Click::class)->create([
            'url_id' => $url->id,
            'created_at' => $twoDaysAgo->toDateTimeString()
        ]);

        factory(App\Click::class)->create([
            'url_id' => $url->id,
            'created_at' => $sevenDaysAgo
        ]);
    }
}
