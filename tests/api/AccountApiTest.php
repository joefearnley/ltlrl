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
                'link' => $url1->link(),
                'url' => $url2->url,
                'link' => $url2->link(),
                'url' => $url3->url,
                'link' => $url3->link(),
                'user_id' => "$user->id"
            ]);
    }

}
