<?php

namespace App\Models;

use App\Casts\HtmlSpecialCharsCast;
use App\Models\Document;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'category_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'name' => HtmlSpecialCharsCast::class,
    ];


    /**
     * Category has many categories
     * 
     * @return @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    /**
     * Category has many documents
     * 
     * @return @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Category has children categories
     * 
     * @return @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childrenCategories()
    {
        return $this->hasMany(Category::class)->with('categories');
    }

    /**
     * Category belongs to many users
     * this will be used for authorization
     * 
     * @return @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }


    /**
     * Get the permission from the pivot table
     * 
     * @param Category $category
     * @param User $user
     * 
     * @return \Illuminate\Database\Eloquent\Model|object|static|null
     */
    public static function getPermission(Category $category, User $user)
    {
        $attachedRecord = DB::table('category_user')
        ->where('category_id', $category->id)
            ->where('user_id', $user->id)
            ->first();

        return $attachedRecord;
    }


    /**
     * Attach permissions
     * 
     * @param mixed $user
     * @param mixed $category
     * @param string $permission
     * 
     * @return [type]
     */
    public static function attachPermission($user, $category, string $permission)
    {
        $attachedRecord = Category::getPermission($category, $user);

        // if already exits, making sure to update the permissions column if needed
        if ($attachedRecord) {
            $oldPermissions = json_decode($attachedRecord->permissions);

            if (!in_array($permission, $oldPermissions)) {
                array_push($oldPermissions, $permission);
                DB::table('category_user')
                ->where('category_id', $category->id)
                    ->where('user_id', $user->id)
                    ->update(['permissions' => json_encode($oldPermissions)]);
            }
            
        } else {
            $permissions = [$permission];
            $category->users()->attach($user->id, ['permissions' => json_encode($permissions)]);
        }
        return;
    }


    /**
     * Detach permissions
     * 
     * @param User $user
     * @param Category $category
     * @param mixed $attachedRecord
     * @param string $permission
     * 
     * @return bool
     */
    public static function detachPermission(User $user, Category $category, $attachedRecord, string $permission): bool {
        // if already exits, making sure to delete the appropriate permission
        if ($attachedRecord) {
            $permissions = json_decode($attachedRecord->permissions);

            // all permissions should be checked here
            if (in_array(User::PERMISSIONS['download'], $permissions) && in_array(User::PERMISSIONS['upload'], $permissions)) {
                unset($permissions[in_array($permission, $permissions)]);

                DB::table('category_user')
                    ->where('category_id', $category->id)
                    ->where('user_id', $user->id)
                    ->update(['permissions' => json_encode($permissions)]);
            } else {
                $category->users()->detach($user->id);
            }
            return true;
        } else {
            return false;
        }
    }

}
