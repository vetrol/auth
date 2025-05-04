<?php

namespace VendorName\Skeleton\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \VendorName\Skeleton\VetrolAuth
 */
class Skeleton extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \VendorName\Skeleton\VetrolAuth::class;
    }
}
