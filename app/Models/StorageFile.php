<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StorageFile extends Model
{
    /**
     * @var string
     */
    protected $table = 'storage_files';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'file_type',
        'file_name',
        'file_extension',
        'file_mime'
    ];

}
