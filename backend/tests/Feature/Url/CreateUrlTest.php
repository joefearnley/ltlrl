<?php

namespace Tests\Feature\Url;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Url;

class CreateUrlTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_access_create_url_endpoint_unauthorized(): void
    {
        $postData = [];

        $response = $this->post(route('urls.store'), $postData);
        $response->dump();


            // ->assertStatus(422)
            // ->assertJsonFragment(['The url field is required.']);


    }
}
