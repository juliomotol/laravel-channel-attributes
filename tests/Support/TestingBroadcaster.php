<?php

namespace JulioMotol\ChannelAttributes\Tests\Support;

use Illuminate\Broadcasting\Broadcasters\NullBroadcaster;

class TestingBroadcaster extends NullBroadcaster
{
    public function getChannels(): array
    {
        return $this->channels;
    }

    public function getChannelOptions(): array
    {
        return $this->channelOptions;
    }
}
