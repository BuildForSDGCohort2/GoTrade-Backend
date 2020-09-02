<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Product;
use Carbon\Carbon;

/**
 * Class Users
 *
 * @package App\Models
 * @property string $display_name
 * @property string $first_name
 * @property string $last_name
 * @property string $mobile_number
 * @property $date_of_bith
 * @property string $email
 * @property $address
 * @property integer $country_id
 * @property int $id
 * @property integer $state_id
 * @property integer $city_id
 * @property $gender
 * @property integer $photo_id
 * @property $email_verified_at
 * @property boolean $password
 * @property boolean $is_online
 * @property $role
 * 
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereId($value)
 */

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * @var bool
     */
    public $timestamps = true;  

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'display_name',
        'first_name',
        'last_name',
        'email',
        'password',
        'mobile_number',
        'date_of_bith',
        'address',
        'country_id',
        'state_id',
        'city_id',
        'gender',
        'photo_id',
        'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @var
     */
    public $product;

    /**
     * Relation with product table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'id', 'created_by');
    }

    /**
     * @return User[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getAllUsers()
    {
        return User::all();
    }

    /**
     * returns total user count.
     *
     * @return mixed
     */
    public static function getUserCount()
    {
        return User::where('id', '!=', \UserType::SUPER_ADMIN_ID)->count();
    }

    /**
     * Set product for user.
     *
     * @param mixed $product
     */
    public function setProduct($product): void
    {
        $this->product = $product;
    }

    /**
     * Returns user by email.
     *
     * @param $email
     *
     * @return mixed
     */
    public static function getByEmail($email)
    {
        return User::where(['email' => $email])->first();
    }

    /**
     * returns list of emails which are like $email
     *
     * @param $email
     * @return mixed
     */
    public static function getEmails($email)
    {
        return User::select('email')->where('type', '!=', \UserType::SUPER_ADMIN)->where('email', 'like',
            $email . '%')->get();
    }

    /**
     * returns user by ID.
     *
     * @param $id
     *
     * @return mixed
     */
    public static function get($id)
    {
        return User::find($id);
    }
    /**
     * returns user(Revoke token).
     *
     *
     * @return mixed
     */
    public static function revokeUserToken()
    {
        $user = Auth::user();
        // Revoke token...
        $user->tokens()->where('tokenable_id', $user->id)->delete();

        return $user;
    }

    /**
     * Add/update user.
     *
     * @throws \Exception
     */
    public function edit()
    {
        $postData = request();
        unset($postData['product_photo']);

        $this->forceFill($postData);
        $profilePhoto = request()->file('profile_photo');
        // Check if UploadFile is valid
        if ($profilePhoto && !(request()->file('product_photo')->isValid())) {
            return $profilePhoto;
        }else{
            if ($profilePhoto instanceof UploadedFile) {
                if (isset($this->photo_id)) {
                    deleteFile($this->photo_id);
                }
                $file = uploadFile($profilePhoto, \FileType::IMAGE);
                if ($file) {
                    $this->photo_id = $file->id;
                }
            }
            $this->save();
        }
    }

    /**
     * Update password.
     *
     * @param $password
     */
    public function updatePassword($password)
    {
        $this->password = Hash::make($password);
        $this->save();
    }

    /**
     * Returns Authenticated User Details
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserdetails()
    {
        $user = Auth::user();
        if ($user) {
            return $user->toArray();
        }

        return null;
    }
    
}
