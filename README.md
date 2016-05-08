# Feature switch

## Installation

You can install this package via [packagist.org](https://packagist.org/packages/systream/feature-switch) with [composer](https://getcomposer.org/).

`composer require systream/feature-switch`

composer.json:

```json
"require": {
    "systream/feature-switch": "1.*"
}
```

This library requires `php 5.6` or higher. PHP7 and HHVM is also supported and tested.

## Usage examples

By default the feature is not enabled.

```php
$feature = new Feature('foo_bar_feature_key');
$feature->isEnabled(); // will return: false

```

You have to set up switchers.

### Switchers / toggles

#### Simple

You can easily switch on a feature:

```php
$feature = new Feature('foo_bar_feature_key');
$feature->addSwitcher(Simple::on());
$feature->isEnabled(); // will return: true

```

#### A/B testing

This will enable the feature approximately 50% of the visitors.
The feature status is tracking by cookie, so if the visitor returns, the same state of the feature will be shown.

```php
$feature = new Feature('foo_bar_feature_key');
$feature->addSwitcher(new AB());
$feature->isEnabled();

```

#### Time based switching

With this library you can set up a time based feature toggle too.
For example you cool new feature will be available for every visitor after a point in time.

```php
$feature = new Feature('foo_bar_feature_key');
$feature->addSwitcher(new Until(\DateTime::createFromFormat('Y-m-d H:i:s', '2017-08-12 10:00:00')));
$feature->isEnabled(); // brefore 2017-08-12 10:00:00 it's return false, after will return true

```

If you want to disable a feature after a date:

```php
$feature = new Feature('foo_bar_feature_key');
$feature->addSwitcher(new Until(\DateTime::createFromFormat('Y-m-d H:i:s', '2017-08-12 10:00:00'), false));
$feature->isEnabled(); // brefore 2017-08-12 10:00:00 it's return true, after will return false

```

#### Callback

For custom cases:

```php
$feature = new Feature('foo_bar_feature_key');
$feature->addSwitcher(
	new Callback(function() {
		/* do custom logic */
		return true;
	})
);
$feature->isEnabled();

```

### Add multiple switcher/toggle

```php
$feature = new Feature('foo_bar_feature_key');
$feature->addSwitcher(new AB());
$feature->addSwitcher(new Until(\DateTime::createFromFormat('Y-m-d H:i:s', '2017-08-12 10:00:00')));
$feature->isEnabled();

```

The feature will passed to all of the switcher until one of them return true;
In this case the feature will tested first with AB switcher and if it returns false then it passes to the next time based switcher.

## Test

[![Build Status](https://travis-ci.org/systream/feature-switch.svg?branch=master)](https://travis-ci.org/systream/feature-switch)