<?php

/**
 * Class UserType
 *
 * @package App\Http
 */
final class UserType
{

    const SUPER_ADMIN_ID = 1;

    const CUSTOMER = 'customer';
    const TRADER = 'trader';
    const SUPER_ADMIN = 'admin';

    /**
     * @return array
     */
    public static function getAll()
    {
        return [self::CUSTOMER => UserType::getValue(self::CUSTOMER), self::TRADER => UserType::getValue(self::TRADER)];
    }
}

/**
 * Class FileType
 */
final class FileType
{
    const IMAGE = 'image';
    const VIDEO = 'video';
    
    /**
     * Returns respective value.
     *
     * @param      $x
     *
     *
     * @return null
     */
    public static function getValue($x)
    {
        $value = null;
        switch ($x) {
            case 'image':
                $value = generateSlug('image');
                break;
            case 'video':
                $value = generateSlug('video');
                break;
        }

        return $value;
    }
}
