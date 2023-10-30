<?php

namespace Tests\Feature\Url;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Url;

class ClickTest extends TestCase
{
    use RefreshDatabase;

    public function test_clicking_on_little_url_redirects_user(): void
    {
        $user = User::factory()->create();
        $url = Url::factory()->create([
            'user_id' => $user->id,
        ]);

        // dd($url->key);

        $this->get('/' . $url->key)
            ->assertStatus(302)
            ->assertRedirect($url->url);
    }

    public function test_clicking_on_url_creates_click_record(): void
    {
        $user = User::factory()->create();
        $url = Url::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->get('/' . $url->key)
            ->assertStatus(302)
            ->assertRedirect($url->url);

        $user = User::factory()->create();
        $url = Url::factory()->count(3)->create([
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('clicks', [
            'url_id' => $url->id,
        ]);
    }

    // public function url_click_stats_display_properly()
    // {
    //     $user = factory(User::class)->create();
    //     $url = factory(Url::class)->create([ 'user_id' => $user->id ]);

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
}
