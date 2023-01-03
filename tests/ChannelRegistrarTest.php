<?php

use Illuminate\Broadcasting\BroadcastManager;
use JulioMotol\ChannelAttributes\ChannelRegistrar;
use JulioMotol\ChannelAttributes\Tests\Fixtures\Broadcasting\Directory\BarChannel;
use JulioMotol\ChannelAttributes\Tests\Fixtures\Broadcasting\Directory\BazChannel;
use JulioMotol\ChannelAttributes\Tests\Fixtures\Broadcasting\Directory\FooChannel;
use JulioMotol\ChannelAttributes\Tests\Fixtures\Broadcasting\ModelChannel;
use JulioMotol\ChannelAttributes\Tests\Fixtures\Broadcasting\SimpleChannel;
use JulioMotol\ChannelAttributes\Tests\Fixtures\Broadcasting\VanillaChannel;
use JulioMotol\ChannelAttributes\Tests\Fixtures\Broadcasting\WithOptionsChannel;
use JulioMotol\ChannelAttributes\Tests\Fixtures\Models\Post;

beforeEach(function () {
    $this->channelRegistrar = (new ChannelRegistrar(app(BroadcastManager::class)->driver()))
        ->useBasePath(__DIR__)
        ->useRootNamespace('JulioMotol\ChannelAttributes\Tests\\');
});

it('can register directory', function () {
    $this->channelRegistrar->registerDirectory(__DIR__.'/Fixtures/Broadcasting/Directory');

    assertRegisteredChannelsCount(3);

    assertChannelRegistered('foo', FooChannel::class);
    assertChannelRegistered('bar', BarChannel::class);
    assertChannelRegistered('baz', BazChannel::class);
});

it('can register simple channel', function () {
    $this->channelRegistrar->registerChannel(SimpleChannel::class);

    assertChannelRegistered('simple', SimpleChannel::class);
});

it('can register channel with options', function () {
    $this->channelRegistrar->registerChannel(WithOptionsChannel::class);

    assertChannelRegistered('with-options', WithOptionsChannel::class, ['guard' => 'web']);
});

it('can register model broadcast channel', function () {
    $this->channelRegistrar->registerChannel(ModelChannel::class);

    assertChannelRegistered(Post::class, ModelChannel::class);
});

it('does nothing when channel class doesnt exists', function () {
    $this->channelRegistrar->registerChannel(NonExistentChannel::class);

    assertRegisteredChannelsCount(0);
});

it('does nothing when channel class doesnt have a Channel attribute', function () {
    $this->channelRegistrar->registerChannel(VanillaChannel::class);

    assertRegisteredChannelsCount(0);
});
