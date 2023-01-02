<?php

namespace JulioMotol\ChannelAttributes;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use JulioMotol\ChannelAttributes\Commands\ChannelAttributesCommand;

class ChannelAttributesServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-channel-attributes')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-channel-attributes_table')
            ->hasCommand(ChannelAttributesCommand::class);
    }
}
