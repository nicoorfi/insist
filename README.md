# Insist

Method wrappers around eventsauce/backoff, that retries callables actions thay may fail.

## Install

Via Composer

```bash
$ composer require nicoorfi/insist
```

## Usage

```php

insist_fibonnaci($actionThatMayFail,
    100000, // initial delay in microseconds, 0.1 seconds
    15, // max number of tries
    2500000, // (optional) max delay in microseconds, default 2.5 seconds
);

insist_linear($actionThatMayFail,
    100000, // initial delay in microseconds, 0.1 seconds
    15, // max number of tries
    2500000, // (optional) max delay in microseconds, default 2.5 seconds
);
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
