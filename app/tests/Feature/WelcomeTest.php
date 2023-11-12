<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WelcomeTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_welcome_page_displays_correctly(): void
    {
        $this->get(route('welcome'))
            ->assertStatus(200)
            ->assertSee('Log in')
            ->assertSee('Register')
            ->assertSee('enter a URL and...')
            ->assertSee('Make Url Little')
            ->assertSee('ltlrl');
    }
}
