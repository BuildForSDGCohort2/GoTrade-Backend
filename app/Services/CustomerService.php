<?php
namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use App\Models\User;

/**
 * Description of CustomerService
 *
 * @author afolabi
 */
class CustomerService
{

    const PENDING = 0;

    const ACTIVE = 1;

    const RESERVED = 2;

    const SUSPENDED = 3;

    public static function getStatusMessage($status = 0)
    {
        switch ($status) {
            case self::PENDING:
                return "PENDING";
            case self::ACTIVE:
                return "ACTIVE";
            case self::RESERVED:
                return "RESERVED";
            case self::SUSPENDED:
                return "SUSPENDED";
        }
    }
    
    public static function getStatusColor($status = 0)
    {
        switch ($status) {
            case self::PENDING:
                return "bg-warning";
            case self::ACTIVE:
                return "bg-success";
            case self::SUSPENDED:
                return "bg-danger";
        }
    }   

    public static function generate_digits($length)
    {
        $id = "";
        for ($i = 0; $i < $length; $i ++) {
            $id = $id . chr(mt_rand(48, 57));
        }
        return $id;
    }
    
    public static function gerenateCustomerID()
    {
        $id = 'GT00' . date('Ym') . self::generate_digits(4);
        while (User::where('customer_id', $id)->get()->count() > 0) {
            $id = 'GT00' . date('Ym') . self::generate_digits(4);
        }
        return $id;
    }
}