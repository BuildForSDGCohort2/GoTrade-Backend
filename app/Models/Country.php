<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\Country
 *
 * @property int $id
 * @property string $name
 * 
 */
class Country extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'countries';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Returns Country Id by name.
     *
     * @param $country
     * @return mixed|null
     */
    public static function getCountryIdByName($country)
    {
        $country = DB::table('countries')->where(['name' => $country])->first();

        if ($country) {
            return $country->id;
        }

        return null;
    }

    /**
     * Returns Country name by country ID.
     *
     * @param $country
     * @return mixed|null
     */
    public static function getCountryNameById($country)
    {
        $country = DB::table('countries')->where(['id' => $country])->first();

        if ($country) {
            return $country->name;
        }

        return null;
    }

}
