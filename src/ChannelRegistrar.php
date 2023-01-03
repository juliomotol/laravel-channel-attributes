<?php

namespace JulioMotol\ChannelAttributes;

use Illuminate\Broadcasting\Broadcasters\Broadcaster;
use Illuminate\Contracts\Broadcasting\HasBroadcastChannel;
use Illuminate\Support\Str;
use JulioMotol\ChannelAttributes\Attributes\Channel;
use ReflectionClass;
use SplFileInfo;
use Symfony\Component\Finder\Finder;

class ChannelRegistrar
{
    protected string $basePath;

    protected string $rootNamespace;

    public function __construct(
        private Broadcaster $broadcaster
    ) {
    }

    public function useBasePath(string $basePath): self
    {
        $this->basePath = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $basePath);

        return $this;
    }

    public function useRootNamespace(string $rootNamespace): self
    {
        $this->rootNamespace = rtrim(str_replace('/', '\\', $rootNamespace), '\\').'\\';

        return $this;
    }

    public function registerDirectory(string $directory): void
    {
        $files = (new Finder())->files()
            ->name('*.php')
            ->in($directory)
            ->sortByName();

        collect($files)
            ->map(fn (SplFileInfo $file) => $this->fullQualifiedClassNameFromFile($file))
            ->each(fn (string $path) => $this->registerChannel($path));
    }

    protected function fullQualifiedClassNameFromFile(SplFileInfo $file): string
    {
        $class = Str::of($file->getRealPath())
            ->replaceFirst($this->basePath, '')
            ->trim(DIRECTORY_SEPARATOR)
            ->replaceLast('.php', '')
            ->replace(
                [DIRECTORY_SEPARATOR, 'App\\'],
                ['\\', app()->getNamespace()]
            );

        return $this->rootNamespace.$class;
    }

    public function registerChannel(string|object $channel): void
    {
        if (is_string($channel) && ! class_exists($channel)) {
            return;
        }

        $class = new ReflectionClass($channel);

        if (! $channelAttribute = $this->getChannelAttribute($class)) {
            return;
        }

        $channelRoute = class_exists($channelAttribute->channel) && is_a($channelAttribute->channel, HasBroadcastChannel::class, true)
            ? (new $channelAttribute->channel)->broadcastChannelRoute()
            : $channelAttribute->channel;

        $this->broadcaster->channel($channelRoute, $class->getName());
    }

    /** @param  ReflectionClass<object>  $class */
    protected function getChannelAttribute(ReflectionClass $class): ?Channel
    {
        $attributes = $class->getAttributes(Channel::class);

        if (! count($attributes)) {
            return null;
        }

        return $attributes[0]->newInstance();
    }
}
