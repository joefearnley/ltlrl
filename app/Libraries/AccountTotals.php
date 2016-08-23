<?php

namespace App\Libraries;

use App\User;
use Carbon\Carbon;

class AccountTotals
{
    /**
     * User who's account these totals are assocated with.
     *
     * @var User
     */
    private $user;

    /**
     * The number of days the account has been making urls.
     *
     * @var
     */
    private $daysMakingUrlsLittle;

    /**
     * The number of urls the account has make
     *
     * @var
     */
    private $urlsMade;

    /**
     * The total number of urls that have been clicked on.
     *
     * @var
     */
    private $urlsClickedOn;

    /**
     * Create a new AccountTotals instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Calculate the totals for account.
     */
    public function calculate()
    {
        $this->daysMakingUrlsLittle = Carbon::now()->diffInDays($this->user->created_at);

        $this->urlsMade = $this->user->urls->count();

        $this->urlsClickedOn = $this->user->urls->map(function($url) {
            return $url->clicks->count();
        })->sum();
    }

    /**
     * Get the daysMakingUrlsLittle property.
     *
     * @return mixed
     */
    public function getDaysMakingUrlsLittle()
    {
        return $this->daysMakingUrlsLittle;
    }

    /**
     * Get the urlsMade property.
     *
     * @return mixed
     */
    public function getUrlsMade()
    {
        return $this->urlsMade;
    }

    /**
     * Get the urlsClickedOn property.
     *
     * @return mixed
     */
    public function getUrlsClickedOn()
    {
        return $this->urlsClickedOn;
    }
}
