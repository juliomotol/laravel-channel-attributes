<?php

use Illuminate\Contracts\Broadcasting\HasBroadcastChannel;
use Illuminate\Support\Facades\Broadcast;
use function PHPUnit\Framework\assertTrue;

function assertRegisteredChannelsCount(int $expected): void
{
    $registeredChannels = Broadcast::driver('testing')->getChannels();

    expect($registeredChannels)->toHaveCount($expected);
}

function assertChannelRegistered(string $route, string $channel, array $options = [])
{
    $route = class_exists($route) && is_a($route, HasBroadcastChannel::class, true)
            ? (new $route)->broadcastChannelRoute()
            : $route;

    $channelRegistered = (function ($route, $channel, $options) {
        $matchedChannel = Broadcast::driver('testing')->getChannels()[$route] ?? null;
        $matchedChannelOption = Broadcast::driver('testing')->getChannelOptions()[$route] ?? null;

        if ($matchedChannel !== $channel) {
            return false;
        }

        if ($matchedChannelOption === null || count(array_diff($matchedChannelOption, $options)) > 0) {
            return false;
        }

        return true;
    })($route, $channel, $options);

    assertTrue($channelRegistered, 'The expected channel was not registered');
}
