<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductCategory;

/**
 * App\Models\ProductCategory
 *
 * @property int $id
 * @property string $name
 * @property int $created_by
 * @property int $updated_by
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product getProductCountByCategoryId($value)
 */
class ProductCategory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','created_by','updated_by'
    ];

    /**
     * return Product category object by Id.
     *
     * @param $id
     *
     * @return mixed
     */
    public static function get($id)
    {
        return ProductCategory::find($id);
    }

    /**
     * return Product category name by ID.
     *
     * @param $category
     *
     * @return string|null
     */
    public static function getCategoryNameById($category)
    {
        $category = ProductCategory::select(['name'])->find($category);
        if ($category instanceof ProductCategory) {
            $categoryName = $category->name;
            return $categoryName;
        }

        return null;
    }

    /**
     * @throws \Exception
     */
    public function edit(Request $request)
    {
        $this->name = $request->input('name');
        $this->created_by = Auth::user()->id;
        $this->updated_by = Auth::user()->id;;
        $this->save();
    }

     /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:2|max:100|unique:name',
            //'image' => 'nullable|image|dimensions:max_width=100,max_height=100|max:10|mimes:jpeg,png,bmp,jpg',
        ];
    }

    /**
     * @return ProductCategory[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function search()
    {
        return ProductCategory::select(['id', 'name'])->get();
    }

    /**
     * Check if product category is assigned.
     *
     * @return mixed
     */
    public function checkIfAssigned()
    {
        return Product::getProductCountByCategoryId($this->id);
    }
}
