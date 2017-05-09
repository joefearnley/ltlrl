<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Click;
use App\Url;

class AccountApiTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function account_api_requests_for_auth_users_urls_return_properly()
    {
        $user = factory(User::class)->create();

        $url1 = factory(Url::class)->create([ 'user_id' => $user->id ]);
        $url2 = factory(Url::class)->create([ 'user_id' => $user->id ]);
        $url3 = factory(Url::class)->create([ 'user_id' => $user->id ]);

        $this->actingAs($user)
            ->get('api/account/urls')
            ->assertStatus(200)
            ->assertJsonFragment([
                'url' => $url1->url,
                'link' => $url1->link(),
                'user_id' => "$user->id"
            ])
            ->assertJsonFragment([
                'url' => $url2->url,
                'link' => $url2->link(),
                'user_id' => "$user->id"
            ])
            ->assertJsonFragment([
                'url' => $url3->url,
                'link' => $url3->link(),
                'user_id' => "$user->id"
            ]);
    }

    /** @test */
    public function account_api_requests_for_auth_users_urls_shows_clicks()
    {
        $user = factory(User::class)->create();

        $url = factory(Url::class)->create([ 'user_id' => $user->id ]);
        $click1 = factory(Click::class)->create([ 'url_id' => $url->id ]);
        $click2 = factory(Click::class)->create([ 'url_id' => $url->id ]);

        $this->actingAs($user)
            ->get('api/account/urls')
            ->assertStatus(200)
            ->assertJsonFragment([
                'url' => $url->url,
                'link' => $url->link(),
                'user_id' => "$user->id"
            ])
            ->assertJsonFragment([
                'click_count' => 2
            ])
            ->assertJsonFragment([
                'id' => $click1->id,
                'url_id' => "$url->id"
            ])
            ->assertJsonFragment([
                'id' => $click2->id,
                'url_id' => "$url->id"
            ]);
    }

    /** @test */
    public function update_personal_information_requires_name_field()
    {
        $user = factory(User::class)->create();

        $postData = [
            'id' => $user->id,
            'name' => '',
            'email' => 'john.fearnley@gmail.com'
        ];

        $this->actingAs($user)
            ->json('POST', 'api/account/update-personal-info', $postData)
            ->assertStatus(422)
            ->assertJsonFragment(['The name field is required.']);
    }

    /** @test */
    public function update_personal_information_requires_email_field()
    {
        $user = factory(User::class)->create();

        $postData = [
            'id' => $user->id,
            'name' => 'John Fearnley',
            'email' => ''
        ];

        $this->actingAs($user)
            ->json('POST', 'api/account/update-personal-info', $postData)
            ->assertStatus(422)
            ->assertJsonFragment(['The email field is required.']);
    }

    /** @test */
    public function update_personal_information_requires_valid_email()
    {
        $user = factory(User::class)->create();

        $postData = [
            'id' => $user->id,
            'name' => 'John Fearnley',
            'email' => 'asfdasfsd'
        ];

        $this->actingAs($user)
            ->json('POST', 'api/account/update-personal-info', $postData)
            ->assertStatus(422)
            ->assertJsonFragment(['The email must be a valid email address.']);
    }

    /** @test */
    public function update_personal_information()
    {
        $user = factory(User::class)->create([
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
            ->assertStatus(200)
            ->assertJsonFragment([
                'success' => true
            ])
            ->assertJsonFragment([
                'name' => 'John Fearnley',
                'email' => 'john.fearnley@gmail.com'
            ]);

            $this->assertDatabaseHas('users', [
                'name' => 'John Fearnley',
                'email' => 'john.fearnley@gmail.com'
            ]);
    }

    /** @test */
    public function update_password()
    {
        $user = factory(User::class)->create();
        $oldPassword = $user->password;

        $postData = [
            'id' => $user->id,
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ];

        $this->actingAs($user)
            ->post('api/account/update-password', $postData)
            ->assertStatus(200)
            ->assertJsonFragment([
                'success' => true
            ]);

        $updatedUser = User::find($user->id);

        $this->assertNotEquals($oldPassword, $updatedUser->password);
    }

    /** @test */
    public function update_password_has_to_be_6_characters()
    {
        $user = factory(User::class)->create();

        $postData = [
            'password' => 'secre',
            'password_confirmation' => 'secre'
        ];

        $this->actingAs($user)
            ->json('POST', 'api/account/update-password', $postData)
            ->assertStatus(422)
            ->assertJsonFragment(['The password must be at least 6 characters.']);
    }

    /** @test */
    public function update_password_field_is_required()
    {
        $user = factory(User::class)->create();

        $postData = [
            'password' => '',
        ];

        $this->actingAs($user)
            ->json('POST', 'api/account/update-password', $postData)
            ->assertStatus(422)
            ->assertJsonFragment(['The password field is required.']);
    }

    /** @test */
    public function update_password_confirmation_matches_password()
    {
        $user = factory(User::class)->create();

        $postData = [
            'password' => 'secret',
            'password_confirmation' => 'secre'
        ];

        $this->actingAs($user)
            ->json('POST', 'api/account/update-password', $postData)
            ->assertStatus(422)
            ->assertJsonFragment(['The password confirmation does not match.']);
    }

    /** @test */
    public function get_account_info()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get('api/account/info')
            ->assertStatus(200)
            ->assertJsonFragment([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email
            ]);
    }

    /** @test */
    public function error_is_thrown_when_getting_account_info_if_user_is_not_logged_in()
    {
        $response = $this->call('GET', 'api/account/info');

        $this->assertEquals(302, $response->status());
    }
}
