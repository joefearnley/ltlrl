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

    public function test_update_personal_information_requires_name_field()
    {
        $user = factory(App\User::class)->create();

        $postData = [
            'id' => $user->id,
            'name' => '',
            'email' => 'john.fearnley@gmail.com'
        ];

        $this->actingAs($user)
            ->json('POST', 'api/account/update-personal-info', $postData)
            ->see('The name field is required.');
    }

    public function test_update_personal_information_requires_email_field()
    {
        $user = factory(App\User::class)->create();

        $postData = [
            'id' => $user->id,
            'name' => 'John Fearnley',
            'email' => ''
        ];

        $this->actingAs($user)
            ->json('POST', 'api/account/update-personal-info', $postData)
            ->see('The email field is required.');
    }

    public function test_update_personal_information_requires_valid_email()
    {
        $user = factory(App\User::class)->create();

        $postData = [
            'id' => $user->id,
            'name' => 'John Fearnley',
            'email' => 'asfdasfsd'
        ];

        $this->actingAs($user)
            ->json('POST', 'api/account/update-personal-info', $postData)
            ->see('The email must be a valid email address.');
    }

    public function test_update_personal_information()
    {
        $user = factory(App\User::class)->create([
            'name' => 'Joe Fearnley',
            'email' => 'joe.fearnley@gmail.com'
        ]);

        $postData = [
            'id' => $user->id,
            'name' => 'John Fearnley',
            'email' => 'john.fearnley@gmail.com'
        ];

        $this->actingAs($user)
            ->json('POST', 'api/account/update-personal-info', $postData)
            ->seeJson([
                'success' => true
            ])
            ->seeJson([
                'name' => 'John Fearnley',
                'email' => 'john.fearnley@gmail.com'
            ]);

        $this->seeInDatabase('users', [
            'name' => 'John Fearnley',
            'email' => 'john.fearnley@gmail.com'
        ]);
    }

}
