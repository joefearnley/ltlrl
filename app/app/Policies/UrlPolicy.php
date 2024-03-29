<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Url;

class UrlPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the url index can be viewed by the user.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine if the given url can be viewed by the user.
     */
    public function view(User $user, Url $url): bool
    {
        return $user->id === $url->user_id;
    }

    /**
     * Determine if the given url can be edited by the user.
     */
    public function update(User $user, Url $url): bool
    {
        return $user->id === $url->user_id;
    }

     /**
     * Determine if the given url can be deleted by the user.
     */
    public function delete(User $user, Url $url): bool
    {
        return $user->id === $url->user_id;
    }
}
