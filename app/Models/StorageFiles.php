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

    /**
     * Get file by ID.
     *
     * @param $id
     * @return mixed
     */
    public static function getById($id)
    {
        return StorageFiles::select(['id', 'path', 'file_name', 'file_type', 'file_extension', 'file_mime'
        ])->find($id);
    }

    /**
     * Delete file by Id
     *
     * @param $fileId
     *
     * @throws \Exception
     */
    public static function deleteFileById($fileId)
    {
        deleteFile($id);
    }

    /**
     * Add file and returns object of file instance.
     *
     * @param string $filename
     * @param string $path
     * @param $fileType
     * @param string $fileExtension
     * @param string $fileMime
     *
     * @return StorageFiles
     */
    public static function add(string $filename, string $path, $fileType, $fileExtension, $fileMime)
    {
        $file->file_name = $filename;
        $file->path = $path;
        $file->file_type = $fileType;
        $file->file_extension = $fileExtension;
        $file->file_mime = $fileMime;
        $file->save();

        return $file;
    }

    /**
     * Get file path by ID.
     * 
     * @param int $id
     *
     * @return string|null
     */
    public static function getPathById($id)
    {
        $file = StorageFiles::getById($id);
        if ($file instanceof StorageFiles) {
                return env('MEDIA_BASE_URL') . $file->path;
        }

        return null;
    }

    /**
     * Returns file by `fileType`.
     *
     * @param int $fileType
     *
     * @return mixed
     */
    public static function getByFileType($fileType)
    {
        /** @var StorageFiles $file */
        $file = StorageFiles::select('id', 'file_name', 'file_extension', 'file_mime', 'path')
                                ->where(['file_type' => $fileType]);

        return $file->get();
    }

}
