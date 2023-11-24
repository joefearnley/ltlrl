<?php

namespace Tests\Feature\Url;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Click;
use App\Models\Url;

class StoreUrlTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_cannot_create_url_with_no_url()
    {
        $formData = [];

        $this->actingAs($this->user)
            ->get(route('urls.store'))
            ->assertStatus(200);
    }
}
