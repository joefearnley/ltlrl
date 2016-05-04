<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class AccountApiTest extends TestCase
{
    use DatabaseMigrations;

    public function test_account_api_requests_for_auth_users_urls_return_properly()
    {
        $user = factory(App\User::class)->create();

        $url1 = factory(App\Url::class)->create([
            'user_id' => $user->id
        ]);

        $url2 = factory(App\Url::class)->create([
            'user_id' => $user->id
        ]);

        $url3 = factory(App\Url::class)->create([
            'user_id' => $user->id
        ]);

        $this->actingAs($user)
            ->visit('api/account/urls')
            ->seeJson()
            ->seeJsonContains([
                'url' => $url1->url,
                'url' => $url2->url,
                'url' => $url3->url,
                'user_id' => "$user->id"
            ]);
    }

}
