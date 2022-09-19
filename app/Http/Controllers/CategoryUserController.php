<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use App\Support\InteractsWithBanner;


class CategoryUserController extends Controller
{
    use InteractsWithBanner;

    /**
     * @param Category $category
     * @param User $user
     * 
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function attachDownloadPermission(Category $category, User $user)
    {
        Category::attachPermission($user, $category, User::PERMISSIONS['download']);
        $this->banner('Letöltési jogosultság hozzáadva.');
        return redirect()->route('dashboard');
    }

    /**
     * @param Category $category
     * @param User $user
     * 
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function attachUploadPermission(Category $category, User $user)
    {
        Category::attachPermission($user, $category, User::PERMISSIONS['upload']);
        $this->banner('Feltöltési jogosultság hozzáadva.');
        return redirect()->route('dashboard');
    }


    /**
     * @param Category $category
     * @param User $user
     * 
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function detachDownloadPermission(Category $category, User $user)
    {
        $attachedRecord = Category::getPermission($category, $user);

        $success = Category::detachPermission($user, $category, $attachedRecord, User::PERMISSIONS['download']);
        if ($success) {
            $this->banner('Letöltési jogosultság törölve.');
        } else {
            $this->banner('A törölni kívánt letöltési jogosultság nem létezik.', 'danger');
        }
        return redirect()->route('dashboard');
    }


    /**
     * @param Category $category
     * @param User $user
     * 
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function detachUploadPermission(Category $category, User $user)
    {
        $attachedRecord = Category::getPermission($category, $user);

        $success = Category::detachPermission($user, $category, $attachedRecord, User::PERMISSIONS['upload']);
        if ($success) {
            $this->banner('Feltöltési jogosultság törölve.');
        } else {
            $this->banner('A törölni kívánt feltöltési jogosultság nem létezik.', 'danger');
        }
        return redirect()->route('dashboard');
    }


    /**
     * Turn on/off upload permission for the root of the categories
     * 
     * @param User $user
     * 
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function toggleCategoryRootUploadPermission(User $user)
    {
        $permissions = $user->permissions;

        if ($permissions) {
            // it can contain other permissions as well (for future usage), so make sure to have the
            // permission in the array
            if (array_search(User::PERMISSIONS['upload_root'], $permissions) === false) {
                array_push($permissions, User::PERMISSIONS['upload_root']);
                $user->update([
                    'permissions' => $permissions
                ]);
            } else {
                // already there, so it needs to be removed
                $permissionId = array_search(User::PERMISSIONS['upload_root'], $permissions);
                unset($permissions[$permissionId]);

                $user->update([
                    'permissions' => count($permissions) === 0 ? null : $permissions,
                ]);
                $this->banner('Feltöltési jogosultság a gyökérhez eltávolítva.');
                return redirect()->route('dashboard');
            }
        } else {
            $user->update([
                'permissions' => ['upload_root']
            ]);
        }
        $this->banner('Feltöltési jogosultság a gyökérhez hozzáadva.');
        return redirect()->route('dashboard');
    }
}
