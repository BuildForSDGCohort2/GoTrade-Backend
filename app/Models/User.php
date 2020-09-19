<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'display_name',
        'first_name',
        'last_name',
        'mobile_number',
        'date_of_bith',
        'email',
        'password',
        'address',
        'country_id',
        'state_id',
        'city_id',
        'gender',
        'photo_id',
        'is_active',
        'is_online',
        'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    public function products()
    {
        return $this->hasMany('App\Models\Product', 'own_by');
    }

    /**
     * Relation with cart_items table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cartItem()
    {
        return $this->hasMany('App\Models\CartItems', 'own_by');
    }

    /**
     * Relation with order table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function order()
    {
        return $this->hasMany('App\Models\Order', 'own_by');
    }
}
