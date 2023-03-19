# Uwazii MOBILE PHP bindings

The Uwazii MOBILE PHP library provides convenient access to the Uwazii API from
applications written in the PHP language. It includes a pre-defined set of
classes for API resources that initialize themselves dynamically from API
responses.

## Requirements

PHP 5.6.0 and later.

## Manual Installation

You can download the [latest release](https://github.com/uwaziimobile/uwazii-php/releases). Then, to use the bindings, include the main file.

```php
require_once '/path/to/uwazii-php/src/UwaziiClient.php';
```

## Dependencies

The bindings require the following extensions in order to work properly:

-   [`curl`](https://secure.php.net/manual/en/book.curl.php), although you can use your own non-cURL client if you prefer
-   [`json`](https://secure.php.net/manual/en/book.json.php)
-   [`mbstring`](https://secure.php.net/manual/en/book.mbstring.php) (Multibyte String)

If you use Composer, these dependencies should be handled automatically. If you install manually, you'll want to make sure that these extensions are available.

## Getting Started

Simple usage looks like:

```php
use Uwazii\UwaziiClient as Uwaziimobile;
$uwazii = new \Uwaziimobile();
$access_token = $uwazii->accessToken(YOUR_USERNAME,YOUR_PASSWORD);
$response = $uwazii->sendMessage($access_token,'SENDERID','PHONE','MESSAGE');

echo $response;
```

## Documentation

See the [Uwazii API docs](https://restapi.uwaziimobile.com/desc/).

