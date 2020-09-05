<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StorageFiles
 *
 * @package App\Models
 * @property int $id
 * @property $file_type
 * @property string $path
 * @property string $file_name
 * @property string $file_extension
 * @property string $file_mime
 */
class StorageFiles extends Model
{
    /**
     * @var string
     */
    protected $table = 'storage_files';

}
