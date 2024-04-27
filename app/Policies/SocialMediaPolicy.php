<?php

namespace App\Policies;

use App\Models\SocialMedia;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SocialMediaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->authorized('list social_media');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SocialMedia $socialMedia): bool
    {
        return $user->authorized('view social_media');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->authorized('create social_media');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SocialMedia $socialMedia): bool
    {
        return $user->authorized('update social_media');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SocialMedia $socialMedia): bool
    {
        return $user->authorized('delete social_media');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SocialMedia $socialMedia): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SocialMedia $socialMedia): bool
    {
        //
    }
}
