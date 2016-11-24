<?php

namespace Systream\FeatureSwitch\Feature\Switcher;


use Systream\FeatureSwitch\Feature\CookieWrapper;
use Systream\FeatureSwitch\Feature\FeatureInterface;
use Systream\FeatureSwitch\Feature\FeatureSwitcherInterface;

class AB implements FeatureSwitcherInterface
{
	const EXPIRE = 23328000; // ~9 months

	/**
	 * @var null|bool
	 */
	private $lastState = null;

	/**
	 * @param FeatureInterface $feature
	 * @return bool
	 */
	public function isEnabled(FeatureInterface $feature)
	{
		$featureCookieKey = md5($feature->getKey());
		$cookieWrapper = new CookieWrapper();
		$cookieResult = $cookieWrapper->get($featureCookieKey);
		if ($cookieResult === null) {
			$cookieResult = $this->getRandomState();
			$cookieWrapper->set($featureCookieKey, $cookieResult, static::EXPIRE);
		}
		return filter_var($cookieResult, FILTER_VALIDATE_BOOLEAN);
	}

	/**
	 * @return string
	 */
	protected function getRandomState()
	{
		$state = $this->lastState === null ? $this->getRandomStateByMicroTime() : !$this->lastState;
		$this->lastState = $state;

		return $state ? 'TRUE' : 'FALSE';

	}

	/**
	 * @return bool
	 */
	protected function getRandomStateByMicroTime()
	{
		return (bool)(microtime(true) % 2);
	}

}