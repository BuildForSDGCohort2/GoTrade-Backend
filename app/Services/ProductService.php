<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

use App\Models\Product;

/**
 * Description of ProductService
 *
 * @author afolabi
 */
class ProductService {

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
}