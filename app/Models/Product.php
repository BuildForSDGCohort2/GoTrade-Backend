<?php

namespace App\Models;

use App\Models\User;
use App\Models\ProductCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\UploadedFile;

/**
 * Class Product
 *
 * @package App\Models
 * @property string $name
 * @property string $sku
 * @property string $slug
 * @property $amount
 * @property $discount
 * @property integer $quantity
 * @property $short_description
 * @property $long_description
 * @property int $id
 * @property string $status
 * @property integer $category_id
 * @property integer $own_by
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereOwnBy($value)
 */


class Product extends Model
{
    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'products';

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @var string
     */
    protected $dateFormat = 'U';

    protected $fillable = [
        'name', 
        'sku', 
        'slug', 
        'amount', 
        'discount',
        'short_description',
        'long_description',
    ];

    /**
     * returns Product By Id.
     *
     * @param $id
     *
     * @return mixed
     */
    public static function get($id)
    {
        return Product::find($id);
    }

     /**
     * @return \Illuminate\Http\Response
     */
    public static function getAllProducts()
    {
        return Product::all();
    }

    /**
     * Relation with product category model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'id');
    }

    /**
     * Relation with user table to get user data.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'own_by', 'id');
    }

    /**
     * Get All Products by User ID
     *
     * @param $id
     * @return mixed
     */
    public static function getProductByUserId($id)
    {
        $products = self::whereOwnBy($id)->get();
        return $products;
    }

    /**
     * @param $status
     */
    public function updateStatus($status)
    {
        $this->is_active = (string)$status;
        $this->save();
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:2|max:32',
            'sku' => 'required|string|max:32',
            'slug' => 'required|string|max:128',
            'amount' => 'required',
            'quantity' => 'required',
            'short_description' => 'required|string|max:100',
            'long_description' => 'required|string|max:255',
            'category_id' => 'required',
            'image' => 'nullable|image|dimensions:max_width=100,max_height=100|max:10|mimes:jpeg,png,bmp,jpg',
        ];
    }

    /**
     * Add|edit Product.
     *
     * @param $id
     * @param  $userId
     *
     * @return Product|null
     */
    public static function edit()
    {

        $user = Auth::user();
        $postData = request()->except(['id']);
        unset($postData['image']);
        if ($user instanceof User && $user->role !== \UserType::CUSTOMER) {

            $this->name = $postData['name'];
            $this->sku = $postData['sku'];
            $this->slug = $postData['slug'];
            $this->amount = $postData['amount'];
            $this->discount = $postData['discount'];
            $this->quantity = $postData['quantity'];
            $this->short_description = $postData['short_description'];
            $this->long_description = $postData['long_description'];
            $this->category_id = $postData['category_id'];
            $this->own_by = $user->id;
            
            $this->save();
            $image = request()->file('image');
            $productMediaId = ProductMedia::getById($this->id);
            if ($image instanceof UploadedFile) {
                if (isset($this->id)) {
                    $productMedia = ProductMedia::deleteProductFileById($this->id);

                }
                $file = uploadProductFile($image, \FileType::IMAGE);
                if ($file) {
                    $productMedia = ProductMedia::updateProductImageById($productMediaId->id);
                }
            }

            return $product;
        }

        return null;
    }

    public static function getProductCountByCategoryId(int $id)
    {
        return Product::where('category_id',$id)->select('category_id')->count();
    }
}
