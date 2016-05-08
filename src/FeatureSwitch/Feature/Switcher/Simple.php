<?php

namespace Systream\FeatureSwitch\Feature\Switcher;


use Systream\FeatureSwitch\Feature\FeatureInterface;
use Systream\FeatureSwitch\Feature\FeatureSwitcherInterface;

class Simple implements FeatureSwitcherInterface
{
	/**
	 * @var bool
	 */
	protected $state = false;

	/**
	 * @param FeatureInterface $feature
	 * @return bool
	 */
	public function isEnabled(FeatureInterface $feature)
	{
		return $this->state;
	}

	/**
	 * @return static|Simple
	 */
	public static function on()
	{
		$static = new static();
		$static->enable();
		return $static;
	}

	/**
	 * @return static|Simple
	 */
	public static function off()
	{
		return new static();
	}

	/**
	 * Set switcher to result always enabled
	 */
	public function enable()
	{
		$this->state = true;
	}

}