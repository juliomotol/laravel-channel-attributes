<?php

namespace JulioMotol\ChannelAttributes\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \JulioMotol\ChannelAttributes\ChannelAttributes
 */
class ChannelAttributes extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \JulioMotol\ChannelAttributes\ChannelAttributes::class;
    }
}
