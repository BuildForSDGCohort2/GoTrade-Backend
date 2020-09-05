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

}
