<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\User;

class AccountApiTest extends TestCase
{
    use DatabaseMigrations;

    public function test_account_api_requests_for_auth_users_urls_return_properly()
    {
        $user = factory(App\User::class)->create();

        $url1 = factory(App\Url::class)->create([ 'user_id' => $user->id ]);
        $url2 = factory(App\Url::class)->create([ 'user_id' => $user->id ]);
        $url3 = factory(App\Url::class)->create([ 'user_id' => $user->id ]);

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

    public function test_account_api_requests_for_auth_users_urls_shows_clicks()
    {
        $user = factory(App\User::class)->create();

        $url = factory(App\Url::class)->create([ 'user_id' => $user->id ]);
        $click1 = factory(App\Click::class)->create([ 'url_id' => $url->id ]);
        $click2 = factory(App\Click::class)->create([ 'url_id' => $url->id ]);

        $this->actingAs($user)
            ->visit('api/account/urls')
            ->seeJson()
            ->seeJsonContains([
                'url' => $url->url,
                'link' => $url->link(),
                'user_id' => "$user->id"
            ])
            ->seeJsonContains([
                'click_count' => 2
            ])
            ->seeJsonContains([
                'id' => $click1->id,
                'url_id' => "$url->id"
            ])
            ->seeJsonContains([
                'id' => $click2->id,
                'url_id' => "$url->id"
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
            ->post('api/account/update-personal-info', $postData)
            ->seeJson([
                'success' => true
            ])
            ->seeJson([
                'name' => 'John Fearnley',
                'email' => 'john.fearnley@gmail.com'
            ])
            ->seeInDatabase('users', [
                'name' => 'John Fearnley',
                'email' => 'john.fearnley@gmail.com'
            ]);
    }

    public function test_update_password()
    {
        $user = factory(App\User::class)->create();
        $oldPassword = $user->password;

        $postData = [
            'id' => $user->id,
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ];

        $this->actingAs($user)
            ->post('api/account/update-password', $postData)
            ->seeJson([
                'success' => true
            ]);

        $updatedUser = User::find($user->id);

        $this->assertNotEquals($oldPassword, $updatedUser->password);
    }

    public function test_update_password_has_to_be_6_characters()
    {
        $user = factory(App\User::class)->create();

        $postData = [
            'password' => 'secre',
            'password_confirmation' => 'secre'
        ];

        $this->actingAs($user)
            ->json('POST', 'api/account/update-password', $postData)
            ->see('The password must be at least 6 characters.');
    }

    public function test_update_password_field_is_required()
    {
        $user = factory(App\User::class)->create();

        $postData = [
            'password' => '',
        ];

        $this->actingAs($user)
            ->json('POST', 'api/account/update-password', $postData)
            ->see('The password field is required.');
    }

    public function test_update_password_confirmation_matches_password()
    {
        $user = factory(App\User::class)->create();

        $postData = [
            'password' => 'secret',
            'password_confirmation' => 'secre'
        ];

        $this->actingAs($user)
            ->json('POST', 'api/account/update-password', $postData)
            ->see('The password confirmation does not match.');
    }

    public function test_get_account_info()
    {
        $user = factory(App\User::class)->create();

        $this->actingAs($user)
            ->get('api/account/info')
            ->seeJson([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email
            ]);
    }

    public function test_error_is_thrown_when_getting_account_info_if_user_is_not_logged_in()
    {
        $response = $this->call('GET', 'api/account/info');

        $this->assertEquals(302, $response->status());
    }
}
