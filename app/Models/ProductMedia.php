<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductMedia
 *
 * @package App\Models
 * @property int $id
 * @property int $file_id
 * @property int $product_id
 * @property boolean $is_default
 */
class ProductMedia extends Model
{
    /**
     * @var string
     */
    protected $table = 'product_medias';

    /**
     * Get file by ID.
     *
     * @param $id
     * @return mixed
     */
    public static function getById($productId)
    {
        return ProductMedia::select(['id', 'file_id', 'product_id'])->find($productId);
    }

    /**
     * Update Media by productId
     *
     * @param $productId
     *
     * @throws \Exception
     */
    public static function updateProductImageById($productId)
    {
        $this->product_id = $productId;
        $this->save();
    }

    /**
     * Delete file by Id
     *
     * @param $fileId
     *
     * @throws \Exception
     */
    public static function deleteProductFileById($fileId)
    {
        deleteProductFile($fileId);
    }

    /**
     * Add file and returns object of file instance.
     *
     * @param int $fileId
     * @param int $productId
     * @param int $path
     *
     * @return ProductMedia
     */
    public static function add(int $fileId, int $productId, $path)
    {
        $this->file_id = $fileId;
        $this->product_id = $productId;
        $this->path = $path;
        $this->save();

        return $fileId;
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
        $file = ProductMedia::getById($id);
        if ($file instanceof ProductMedia) {
                return env('MEDIA_BASE_URL') . $file->path;
        }

        return null;
    }

}
