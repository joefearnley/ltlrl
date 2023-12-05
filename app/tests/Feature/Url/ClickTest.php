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
}
