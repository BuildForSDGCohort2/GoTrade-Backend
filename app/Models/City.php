<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\City
 *
 * @property int $id
 * @property string $name
 * @property string $country
 * @property integer $state_id
 * 
 */

class City extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','state_id'
    ];

    /**
     * @param $id
     * @return mixed
     */
    public static function get($id)
    {
        return City::find($id);
    }

    /**
     * Get user city by User ID.
     *
     * @param $userId
     * @return mixed
     */
    public static function getCityByUserId($userId)
    {
        return City::query()->selectRaw("cities.name, cities.state_id")
                            ->join('users', 'cities.state_id', '=', 'users.state_id')
                            ->where('users.id', $userId);
    }

    /**
     * Check if City exists in State table.
     *
     * @param $cityId
     * @param $stateId
     * @return bool
     */
    public static function isCityExistInState($cityId, $stateId)
    {
        $stateCity = DB::table('cities')
                        ->where(['state_id' => $stateId, 'id' => $cityId])->pluck('id')->toArray();

        return in_array($cityId, $stateCity);
    }

    /**
     * Returns City name by City ID.
     *
     * @param $city
     * @return mixed|null
     */
    public static function getCityNameById($cityId)
    {
        $city = DB::table('cities')->where(['id' => $cityId])->first();
        if ($city) {
            return $city->name;
        }

        return null;
    }

     /**
     * Update address.
     *
     * @param $cityId
     * @param $countryId
     */
    public function addCity($city, $stateId)
    {
        $this->name = $city;
        $this->state_id = $stateId;
        $this->save();
    }
    /**
    * Returns array of rules related to Address.
    *
    * @return array
    */
   public function rules()
   {
       return [
           'name' => 'required|string',
           'state_id' => 'required|string',
       ];
   }

    /**
     * Returns City by Name
     *
     * @param $city
     * @return mixed|null
     */
    public static function getCityIdByName($city)
    {
        $city = DB::table('cities')->where(['name' => $city])->first();
        if ($city) {
            return $city->name;
        }

        return null;
    }
}
