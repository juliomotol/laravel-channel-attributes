<?php

namespace JulioMotol\ChannelAttributes\Tests\Fixtures\Broadcasting;

use JulioMotol\ChannelAttributes\Attributes\Channel;

#[Channel('with-options', ['guard' => 'web'])]
class WithOptionsChannel
{
}
