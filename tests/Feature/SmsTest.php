<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SmsTest extends TestCase
{
    /** @test */
    public function phoneNumberIsRequired()
    {
        $this->json('POST', '/sms/send', [])
            ->assertStatus(422)
            ->assertJsonFragment(['The phone field contains an invalid number.']);
    }

    public function create_sms_message_with_no_phone_returns_an_error()
    {
        $this->json('POST', '/sms/send', [ 'phone' => '2324' ])
            ->assertStatus(422)
            ->assertJsonFragment(['The phone field contains an invalid number.']);
    }
}
