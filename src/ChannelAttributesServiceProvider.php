<?php

namespace JulioMotol\ChannelAttributes;

use Illuminate\Broadcasting\BroadcastManager;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ChannelAttributesServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-channel-attributes')
            ->hasConfigFile();
    }

    public function packageBooted(): void
    {
        $this->registerChannels();
    }

    protected function registerChannels(): void
    {
        if (! $this->shouldRegisterChannels()) {
            return;
        }

        $channelRegistrar = new ChannelRegistrar(app(BroadcastManager::class)->driver());

        foreach ($this->getChannelDirectories() as $namespace => $directory) {
            is_string($namespace)
                ? $channelRegistrar
                ->useRootNamespace($namespace)
                ->useBasePath($directory)
                ->registerDirectory($directory)
                : $channelRegistrar
                ->useRootNamespace(app()->getNamespace())
                ->useBasePath(app()->path())
                ->registerDirectory($directory);
        }
    }

    protected function shouldRegisterChannels(): bool
    {
        return config('channel-attributes.enabled', true);
    }

    private function getChannelDirectories(): array
    {
        return config('channel-attributes.directories');
    }
}
