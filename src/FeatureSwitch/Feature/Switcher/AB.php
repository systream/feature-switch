<?php

namespace Systream\FeatureSwitch\Feature\Switcher;


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
		if (!isset($_COOKIE[$featureCookieKey])) {

			$_COOKIE[$featureCookieKey] = $this->getRandomState();
			setcookie($featureCookieKey, $_COOKIE[$featureCookieKey], time() + self::EXPIRE);
		}
		return $_COOKIE[$featureCookieKey];
	}

	/**
	 * @return bool|int
	 */
	protected function getRandomState()
	{
		$state = $this->lastState === null ? $this->getRandomStateByMicroTime() : !$this->lastState;
		$this->lastState = $state;
		return $state;

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