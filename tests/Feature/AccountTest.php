<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Url;
use App\Click;

class AccountTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_needs_to_be_logged_in_to_view_account_section()
    {
        $this->get('/account')->assertSee('Redirecting to');
    }

    /** @test */
    public function index_page_shows_properly()
    {
        $user = factory(User::class)->create();

        $url1 = factory(Url::class)->create([ 'user_id' => $user->id ]);
        $url2 = factory(Url::class)->create([ 'user_id' => $user->id ]);

        factory(Click::class)->create([ 'url_id' => $url1->id ]);
        factory(Click::class)->create([ 'url_id' => $url1->id ]);
        factory(Click::class)->create([ 'url_id' => $url2->id ]);
        factory(Click::class)->create([ 'url_id' => $url2->id ]);
        factory(Click::class)->create([ 'url_id' => $url2->id ]);

        $this->actingAs($user)
            ->get('/account')
            ->assertSee('Account Overview')
            ->assertSee('1')
            ->assertSee('Days Making Urls Little')
            ->assertSee('3')
            ->assertSee('Urls Made Little')
            ->assertSee('5')
            ->assertSee('Urls Clicked On')
            ->assertSee('Settings')
            ->assertSee('Account Overview');
    }

    /** @test */
    public function urls_page_shows_properly()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get('/account/urls')
            ->assertSee('Urls');
    }

    /** @test */
    public function settings_page_shows_properly()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get('/account/settings')
            ->assertSee('Account Settings')
            ->assertSee('Personal Information')
            ->assertSee('Update Password');
    }
}
