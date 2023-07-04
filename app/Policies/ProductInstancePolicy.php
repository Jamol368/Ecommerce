<?php

namespace App\Policies;

use App\Models\ProductInstance;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductInstancePolicy
{
    /**
     * Perform pre-authorization checks.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ProductInstance $productInstance): bool
    {
        return $user->hasRole('vendor') && $user->id == $productInstance->product->vendor->user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ProductInstance $productInstance): bool
    {
        return $user->hasRole('vendor') && $user->id == $productInstance->product->vendor->user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProductInstance $productInstance): bool
    {
        return $user->hasRole('vendor') && $user->id == $productInstance->product->vendor->user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ProductInstance $productInstance): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ProductInstance $productInstance): bool
    {
        return false;
    }
}
