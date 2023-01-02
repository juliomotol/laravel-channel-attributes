<?php

namespace JulioMotol\ChannelAttributes\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use JulioMotol\ChannelAttributes\ChannelAttributesServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            ChannelAttributesServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
    }
}
