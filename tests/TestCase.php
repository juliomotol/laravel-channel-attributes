<?php

namespace JulioMotol\ChannelAttributes\Tests;

use Illuminate\Support\Facades\Broadcast;
use JulioMotol\ChannelAttributes\Tests\Support\TestingBroadcaster;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function getEnvironmentSetUp($app)
    {
        config([
            'database.default' => 'testing',
            'broadcasting.default' => 'testing',
            'broadcasting.connections.testing' => ['driver' => 'testing'],
        ]);

        Broadcast::resolved(fn ($resolved) => $resolved->extend('testing', fn () => new TestingBroadcaster));
    }
}
