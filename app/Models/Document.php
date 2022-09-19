<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use App\Casts\HtmlSpecialCharsCast;
use Carbon\Carbon;

class Document extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'original_filename',
        'view_name',
        'file_path',
        'version',
        'user_id',
        'category_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'view_name' => HtmlSpecialCharsCast::class,
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'last_modified',
        'file_size',
        'file_link',
    ];


    /**
     * Accessor for last modified date
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function getLastModifiedAttribute()
    {
        // Storage::lastModified returns unix timestamp
        return Carbon::createFromTimestamp(Storage::lastModified($this->file_path));
    }

    /**
     * Accessor for filesize
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function getFileSizeAttribute()
    {
        // return in KB, because Storage::size returns size in bytes
        return round(Storage::size($this->file_path) / 1024) . " KB";
    }


    /**
     * Accessor for file download link
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function getFileLinkAttribute()
    {
        return Storage::url($this->file_path);
    }


    /**
     * Category belongs to category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }


    // TODO: make a version handling system
    // this method will be useful to incrementing version number
    public static function incrementVersion(string $oldVersion): string
    {
        if ($oldVersion) {
            // "1.0"
            $versionNumber = intval(explode('.', $oldVersion)[0]);
            $versionNumber++;

            $newVersion = $versionNumber + '.0';
            return $newVersion;
        }
        return '';
    }


    /**
     * Handle file upload
     * 
     * @param mixed $file
     * @param array $data
     * 
     * @return bool
     */
    public static function uploadFile($file, &$data): bool
    {
        if ($file !== null) {
            if ($file->isValid()) {
                $data['original_filename'] = $file->getClientOriginalName();
                $fileName = time() . '-' . $data['original_filename'];

                $filePath = $file->storeAs('public/uploads', $fileName);
                if (!$filePath) {
                    return false;
                }
                $data['file_path'] = $filePath;
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
