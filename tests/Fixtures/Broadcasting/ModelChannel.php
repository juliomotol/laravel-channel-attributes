<?php

namespace JulioMotol\ChannelAttributes\Tests\Fixtures\Broadcasting;

use JulioMotol\ChannelAttributes\Attributes\Channel;
use JulioMotol\ChannelAttributes\Tests\Fixtures\Models\Post;

#[Channel(Post::class)]
class ModelChannel
{
}
