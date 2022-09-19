<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Category;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('authorize_upload_to_category', function ($user, $category) {
            // to some unexplained reasons, laravel switches the boolean values, so negation is necessary
            return !$this->checkPermission($user, $category, User::PERMISSIONS['upload']);
        });

        Gate::define('authorize_download_from_category', function ($user, $category) {
            return !$this->checkPermission($user, $category, User::PERMISSIONS['download']);
        });

        Gate::define('authorize_upload_to_root', function ($user) {
            $permissions = $user->permissions;
            //dd(!$permissions);
            if (!$permissions) {
                return false;
            }
            return in_array(User::PERMISSIONS['upload_root'], $permissions);
            return array_search(User::PERMISSIONS['upload_root'], $permissions) !== false;
        });
    }


    /**
     * Check if permission exists
     * 
     * @param mixed $user
     * @param mixed $category
     * @param string $permission
     * 
     * @return bool
     */
    public function checkPermission($user, $category, string $permission): bool
    {
        $record = DB::table('category_user')
            ->where([
                ['user_id', $user->id],
                ['category_id', $category->id],
            ])
            ->first();

        if ($record) {
            $permissions = json_decode($record->permissions);

            // if exists, needs to return false
            // array search returns either the index or the boolean, so strict equality is checked
            return array_search($permission, $permissions) === false;
        } else {
            // not authorized
            return true;
        }
    }
}
