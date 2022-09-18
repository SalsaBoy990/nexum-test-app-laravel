<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Casts\HtmlSpecialCharsCast;
use App\Models\Document;

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


    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    //
    public function childrenCategories()
    {
        return $this->hasMany(Category::class)->with('categories');
    }
}
