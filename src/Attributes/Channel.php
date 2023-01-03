<?php

namespace JulioMotol\ChannelAttributes\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Channel
{
    public function __construct(
        public readonly string $channel,
        public readonly array $options = [],
    ) {
    }
}
