<?php

namespace ElvinQulizade\Gdpr\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \ElvinQulizade\Gdpr\Gdpr
 */
class Gdpr extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ElvinQulizade\Gdpr\Gdpr::class;
    }
}
