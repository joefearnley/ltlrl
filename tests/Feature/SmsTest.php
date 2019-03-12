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
        $this->post('/sms/send', ['phone' => ''])
            ->assertStatus(422)
            ->assertSee(['The phone field contains an invalid number.']);
    }

    /** @test */
    public function create_sms_message_with_invalid_phone_returns_an_error()
    {
        $response = $this->post('/sms/send', [ 'phone' => '2324' ])
            ->assertStatus(422);
//            ->assertJsonFragment(['The phone field contains an invalid number.']);
    }
}
