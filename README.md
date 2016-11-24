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

This library requires `php 5.6` or higher.

## Usage examples

By default the feature is not enabled.

```php
$feature = new Feature('foo_bar_feature_key');
$feature->isEnabled(); // will return: false

```

If you want to change the feature state, you have to set up one or more switcher.

### Switchers (/ toggles / flippers)

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

#### Writing custom switcher

The only thing you should do that your class need to implement `FeatureSwitcherInterface` interface.

### Add multiple switcher/toggle

```php
$feature = new Feature('foo_bar_feature_key');
$feature->addSwitcher(new AB());
$feature->addSwitcher(new Until(\DateTime::createFromFormat('Y-m-d H:i:s', '2017-08-12 10:00:00')));
$feature->isEnabled();

```

The feature will passed to all of the switcher until one of them return true;
In this case the feature will tested first with AB switcher and if it returns false then it passes to the next time based switcher.

## FeatureSwitch

### Simple feature builder

```php
$feature1 = FeatureSwitch::buildFeature('foo_feature', true); // enabled
$feature2 = FeatureSwitch::buildFeature('another_bar_feature', false); // disabled
```

### Container

```php
$featureSwitch = new FeatureSwitch();
$featureSwitch->addFeature(FeatureSwitch::buildFeature('foo', true));
 
$feature = new Feature('bar2');
$feature->addSwitcher(new AB());

$featureSwitch->addFeature($feature);
```

```php
$featureSwitch->isEnabled('foo'); // true
$featureSwitch->isEnabled('bar2');
```
#### FeatureSwitchArray
This class decorates the ```FeatureSwitch``` with array access support.

You can user FeatureSwitchArray class as Array:
```php
$featureSwitch = new FeatureSwitchArray();

$featureSwitch[] = FeatureSwitch::buildFeature('foo', true);
$featureSwitch->isEnabled('foo'); // returns true
$featureSwitch['foo']->isEnabled();
```

## Test

[![Build Status](https://travis-ci.org/systream/feature-switch.svg?branch=master)](https://travis-ci.org/systream/feature-switch)
