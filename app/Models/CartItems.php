<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CartItems
 *
 * @package App\Models
 * @property int $id
 * @property $amount
 * @property int $quantity
 * @property int $product_id
 * @property int $own_by
 */
class CartItems extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cart_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['quantity'];

    /**
     * @var
     */
    public $user;

     /**
     * Relation with user table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo('App\Models\User', 'own_by', 'id');
    }

}
