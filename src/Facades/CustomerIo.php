<?php

namespace JeffersonGoncalves\CustomerIo\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \JeffersonGoncalves\CustomerIo\CustomerIo
 */
class CustomerIo extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \JeffersonGoncalves\CustomerIo\CustomerIo::class;
    }
}
