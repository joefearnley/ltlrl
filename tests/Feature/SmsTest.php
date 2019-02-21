<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SmsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function phone_number_is_required()
    {
        $this->post('/sms/send', [])
            ->assertStatus(422)
            ->assertJsonFragment(['The phone field contains an invalid number.']);
    }

    public function create_sms_message_with_invalid_phone_returns_an_error()
    {
        $this->json('POST', '/sms/send', [ 'phone' => '2324' ])
            ->assertStatus(422)
            ->assertJsonFragment(['The phone field contains an invalid number.']);
    }
}
