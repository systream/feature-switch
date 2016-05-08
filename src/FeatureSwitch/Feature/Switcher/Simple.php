<?php

namespace Systream\FeatureSwitch\Feature\Switcher;


use Systream\FeatureSwitch\Feature\FeatureInterface;
use Systream\FeatureSwitch\Feature\FeatureSwitcherInterface;

class Simple implements FeatureSwitcherInterface
{

	/**
	 * @var bool
	 */
	protected $state;

	/**
	 * Simple constructor.
	 * @param bool $state
	 */
	public function __construct($state = false)
	{
		$this->state = (bool)$state;
	}

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
	public static function enabled()
	{
		return new static(true);
	}

	/**
	 * @return static|Simple
	 */
	public static function disabled()
	{
		return new static(false);
	}

}