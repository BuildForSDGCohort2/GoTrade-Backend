<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StorageFiles
 *
 * @package App\Models
 * @property int $id
 * @property $order_no
 * @property $address
 * @property int $country_id
 * @property int $state_id
 * @property int $city_id
 * @property int $own_by
 * @property $ip_address
 * @property int $status

 */
class Order extends Model
{
    /**
     * @var string
     */
    protected $table = 'orders';

}
