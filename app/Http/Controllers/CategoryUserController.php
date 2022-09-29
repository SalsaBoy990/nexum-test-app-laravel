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
        $success = Category::attachPermission($user, $category, User::PERMISSIONS['download']);

        if ($success) {
            $this->banner('Letöltési jogosultság hozzáadva.');
        } else {
            $this->banner('Már van a kategóriához letöltési jogosultságod. nem kell újra hozzáadni');
        }

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
        $success = Category::attachPermission($user, $category, User::PERMISSIONS['upload']);

        if ($success) {
            $this->banner('Feltöltési jogosultság hozzáadva.');
        } else {
            $this->banner('Már van a kategóriához feltöltési jogosultságod. nem kell újra hozzáadni');
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
        $success = Category::detachPermission($user, $category, User::PERMISSIONS['upload']);

        if ($success) {
            $this->banner('Feltöltési jogosultság törölve.');
        } else {
            $this->banner('A törölni kívánt feltöltési jogosultság nem létezik.', 'danger');
        }
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
        $success = Category::detachPermission($user, $category, User::PERMISSIONS['download']);
        if ($success) {
            $this->banner('Letöltési jogosultság törölve.');
        } else {
            $this->banner('A törölni kívánt letöltési jogosultság nem létezik.', 'danger');
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
            if (!array_key_exists(User::PERMISSIONS['upload_root'], $permissions)) {

                $permissions[User::PERMISSIONS['upload_root']] = 1;
                $user->update([
                    'permissions' => $permissions
                ]);
            } else {
                // already there, so it needs to be removed
                // unset($permissions[User::PERMISSIONS['upload_root']]);
                $isRootUploadStatus = $permissions[User::PERMISSIONS['upload_root']];
                $permissions[User::PERMISSIONS['upload_root']] = $isRootUploadStatus === 0 ? 1 : 0;

                $user->update([
                    'permissions' => $permissions,
                ]);
                if ($isRootUploadStatus === 0) {
                    $this->banner('Feltöltési jogosultság a gyökérhez hozzáadva.');
                } else {
                    $this->banner('Feltöltési jogosultság a gyökérhez eltávolítva.');
                }

                return redirect()->route('dashboard');
            }
        } else {
            $permissions[User::PERMISSIONS['upload_root']] = 1;
            $user->update([
                'permissions' => $permissions
            ]);
        }
        $this->banner('Feltöltési jogosultság a gyökérhez hozzáadva.');
        return redirect()->route('dashboard');
    }

}
