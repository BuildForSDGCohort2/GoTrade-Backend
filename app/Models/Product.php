<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'sku',
        'slug',
        'amount',
        'discount',
        'quantity',
        'status',
        'short_description',
        'long_description',
        'category_id'
    ];
    
    public function category()
    {
        return $this->belongsTo('App\Models\ProductCategory', 'category_id');
    }
    
    public function owner()
    {
        return $this->belongsTo('App\Models\User', 'own_by');
    }
}
