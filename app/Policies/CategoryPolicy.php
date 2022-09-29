<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can upload to the category.
     * 
     * @param User $user
     * @param Category $category
     * 
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function authorize_upload_to_category(User $user, Category $category)
    {
        return Category::checkPermission($user, $category, User::PERMISSIONS['upload']);
    }

    /**
     * Determine whether the user can download from the category.
     * 
     * @param User $user
     * @param Category $category
     * 
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function authorize_download_from_category(User $user, Category $category)
    {
        return Category::checkPermission($user, $category, User::PERMISSIONS['download']);
    }

}
