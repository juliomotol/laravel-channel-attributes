<?php

use App\Broadcasting\BarChannel as TestBenchBarChannel;
use App\Broadcasting\BazChannel as TestBenchBazChannel;
use App\Broadcasting\FooChannel as TestBenchFooChannel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use JulioMotol\ChannelAttributes\ChannelAttributesServiceProvider;
use JulioMotol\ChannelAttributes\Tests\Fixtures\Broadcasting\Directory\BarChannel as FixtureBarChannel;
use JulioMotol\ChannelAttributes\Tests\Fixtures\Broadcasting\Directory\BazChannel as FixtureBazChannel;
use JulioMotol\ChannelAttributes\Tests\Fixtures\Broadcasting\Directory\FooChannel as FixtureFooChannel;

it('can register directory', function () {
    File::makeDirectory(app_path('Broadcasting'), force: true);

    collect(File::allFiles(__DIR__.'/Fixtures/Broadcasting/stubs'))
        ->each(function (SplFileInfo $file) {
            $destination = app_path('Broadcasting').'/'.Str::of($file->getFilename())->replaceLast('.stub', '.php');

            File::copy($file, $destination);

            include $destination;
        });

    config(['channel-attributes.directories' => [app_path('Broadcasting')]]);

    app()->register(ChannelAttributesServiceProvider::class);

    assertRegisteredChannelsCount(3);
    assertChannelRegistered('foo', TestBenchFooChannel::class);
    assertChannelRegistered('bar', TestBenchBarChannel::class);
    assertChannelRegistered('baz', TestBenchBazChannel::class);
});

it('can register directory with custom namespace', function () {
    config(['channel-attributes.directories' => ['JulioMotol\ChannelAttributes\Tests\Fixtures\Broadcasting\Directory' => __DIR__.'/Fixtures/Broadcasting/Directory']]);

    app()->register(ChannelAttributesServiceProvider::class);

    assertRegisteredChannelsCount(3);
    assertChannelRegistered('foo', FixtureFooChannel::class);
    assertChannelRegistered('bar', FixtureBarChannel::class);
    assertChannelRegistered('baz', FixtureBazChannel::class);
});

it('won\'t register directory when disabled', function () {
    config([
        'channel-attributes.enabled' => false,
        'channel-attributes.directories' => ['JulioMotol\ChannelAttributes\Tests\Fixtures\Broadcasting\Directory' => __DIR__.'/Fixtures/Broadcasting/Directory'],
    ]);

    app()->register(ChannelAttributesServiceProvider::class);

    assertRegisteredChannelsCount(0);
});
