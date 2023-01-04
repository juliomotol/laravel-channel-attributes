# Laravel Channel Attributes

[![Latest Version on Packagist](https://img.shields.io/packagist/v/juliomotol/laravel-channel-attributes.svg?style=flat-square)](https://packagist.org/packages/juliomotol/laravel-channel-attributes)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/juliomotol/laravel-channel-attributes/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/juliomotol/laravel-channel-attributes/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/juliomotol/laravel-channel-attributes/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/juliomotol/laravel-channel-attributes/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/juliomotol/laravel-channel-attributes.svg?style=flat-square)](https://packagist.org/packages/juliomotol/laravel-channel-attributes)

Automatically register channel routes using annotations/attributes!

This package is inspired by [`spatie/laravel-route-attributes`](https://github.com/spatie/laravel-route-attributes).

> Already using `spatie/laravel-route-attributes`? Congrats, time to ditch that `./routes` directory! (Assuming you're not using the `console.php`)

```php
use JulioMotol\ChannelAttributes\Attributes\Channel;

#[Channel('foo')]
class FooChannel
{
    //
}
```

This will be registered like:

```
Broadcast::channel('foo', FooChannel::class);
```

## Installation

You can install the package via composer:

```bash
composer require juliomotol/laravel-channel-attributes
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-channel-attributes-config"
```

This is the contents of the published config file:

```php
return [
    /*
     *  Automatic registration of channels will only happen if this setting is `true`
     */
    'enabled' => true,

    /*
     * Channels in these directories that have channel attributes will automatically be registered.
     * You can specify a different namespace other than `\App` by providing a different key.
     *
     * e.g ['\Domain\Post\Broadcasting' => base_path('domain/Post/Broadcasting')]
     */
    'directories' => [
        app_path('Broadcasting'),
    ],
];
```

## Usage

To add a channel to be registered automatically, simply add the `JulioMotol\ChannelAttributes\Attributes\Channel` to a channel class

<table>
<tr>
<td>Code</td>
<td>Will be interpreted as:</td>
</tr>
<tr>
<td>

```php
use JulioMotol\ChannelAttributes\Attributes\Channel;

#[Channel('foo')]
class FooChannel
{
    //
}
```

</td>
<td>

```
Broadcast::channel('foo', FooChannel::class);
```

</td>
</tr>
</table>

You can add options to channel by doing:

<table>
<tr>
<td>Code</td>
<td>Will be interpreted as:</td>
</tr>
<tr>
<td>

```php
use JulioMotol\ChannelAttributes\Attributes\Channel;

#[Channel('foo', ['guard' => 'web'])]
class FooChannel
{
    //
}
```

</td>
<td>

```
Broadcast::channel('foo', FooChannel::class, ['guard' => 'web']);
```

</td>
</tr>
</table>

You can create a channel for a model by doing:

<table>
<tr>
<td>Code</td>
<td>Will be interpreted as:</td>
</tr>
<tr>
<td>

```php
use JulioMotol\ChannelAttributes\Attributes\Channel;
use App\Models\Post;

#[Channel(Post::class)]
class FooChannel
{
    //
}
```

</td>
<td>

```
Broadcast::channel(Post::class, FooChannel::class);
```

</td>
</tr>
</table>

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Julio Motol](https://github.com/juliomotol)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
