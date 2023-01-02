<?php

namespace JulioMotol\ChannelAttributes\Commands;

use Illuminate\Console\Command;

class ChannelAttributesCommand extends Command
{
    public $signature = 'laravel-channel-attributes';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
