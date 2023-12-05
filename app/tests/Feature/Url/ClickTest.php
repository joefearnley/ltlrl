<?php

namespace Tests\Feature\Url;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Url;

class ClickTest extends TestCase
{
    use RefreshDatabase;

    public function test_click_registers_when_little_url_is_visited(): void
    {
        $user = User::factory()->create();

        $url = Url::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->get($url->little_url);

        $this->assertDatabaseHas('clicks', [
            'url_id' => $url->id,
        ]);

        $url->refresh();

        $this->assertEquals(1, $url->clicks->count());
    }

    public function test_click_registers_multiple_times_when_little_url_is_visited(): void
    {
        $user = User::factory()->create();

        $url = Url::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->get($url->little_url);
        $this->get($url->little_url);
        $this->get($url->little_url);
        $this->get($url->little_url);

        $this->assertDatabaseHas('clicks', [
            'url_id' => $url->id,
        ]);

        $url->refresh();

        $this->assertEquals(4, $url->clicks->count());
    }

    // public function url_click_stats_display_properly()
    // {
    //     $user = Url::factory()->count(5)->create();

    //     factory(User::class)->create();
    //     $url = factory(Url::class)->create([ 'user_id' => $user->id ]);

    //     Url::factory()->count(5)->create([
    //         'user_id' => $this->user->id,
    //     ]);

    //     $oneDaysAgo = Carbon::now()->subDay(1);
    //     $twoDaysAgo = Carbon::now()->subDay(2);
    //     $sevenDaysAgo = Carbon::now()->subDay(7);
    //     $tenDaysAgo = Carbon::now()->subDay(10);

    //     $this->createClicksForStats($url, $twoDaysAgo, $sevenDaysAgo);

    //     $this->get('url/stats/' . $url->id)
    //         ->assertStatus(200)
    //         ->assertJsonFragment([
    //             'date' => $oneDaysAgo->format('m/d'),
    //             'clicks' => 0
    //         ])
    //         ->assertJsonFragment([
    //             'date' => $twoDaysAgo->format('m/d'),
    //             'clicks' => 3
    //         ])
    //         ->assertJsonFragment([
    //             'date' => $sevenDaysAgo->format('m/d'),
    //             'clicks' => 1
    //         ])
    //         ->assertJsonFragment([
    //             'date' => $tenDaysAgo->format('m/d'),
    //             'clicks' => 0
    //         ]);
    // }

    // public function createClicksForStats($url, $twoDaysAgo, $sevenDaysAgo)
    // {
    //     for ($i = 0; $i < 3; $i++) {
    //         factory(Click::class)->create([
    //             'url_id' => $url->id,
    //             'created_at' => $twoDaysAgo->toDateTimeString()
    //         ]);
    //     }

    //     factory(Click::class)->create([
    //         'url_id' => $url->id,
    //         'created_at' => $sevenDaysAgo
    //     ]);
    // }
}
