<?php

namespace Systream\FeatureSwitch\Feature\Switcher;


use Systream\FeatureSwitch\Feature\CookieWrapper;
use Systream\FeatureSwitch\Feature\FeatureInterface;
use Systream\FeatureSwitch\Feature\FeatureSwitcherInterface;

class AB implements FeatureSwitcherInterface
{
	const EXPIRE = 15552000; // ~6 months

	/**
	 * @var null|int
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
			$cookieWrapper->set($featureCookieKey, $cookieResult, self::EXPIRE);
		}
		return filter_var($cookieResult, FILTER_VALIDATE_BOOLEAN);
	}

	/**
	 * @return bool|int
	 */
	protected function getRandomState()
	{
		$state = $this->lastState === null ? $this->getRandomStateByMicroTime() : !$this->lastState;
		$this->lastState = $state;

		return $state ? 'TRUE' : 'FALSE';

	}

	/**
	 * @return int
	 */
	protected function getRandomStateByMicroTime()
	{
		$microTime = microtime(true) * 10000;
		return (bool)($microTime % 2);
	}

}