<?php

namespace Systream\FeatureSwitch\Feature\Switcher;


use Systream\FeatureSwitch\Feature\FeatureInterface;
use Systream\FeatureSwitch\Feature\FeatureSwitcherInterface;

class Callback implements FeatureSwitcherInterface
{
	/**
	 * @var \Closure
	 */
	protected $closure;

	/**
	 * Callback constructor.
	 * @param \Closure $closure
	 */
	public function __construct(\Closure $closure)
	{
		$this->closure = $closure;
	}

	/**
	 * @param FeatureInterface $feature
	 * @return bool
	 */
	public function isEnabled(FeatureInterface $feature)
	{
		$closure = $this->closure;
		return (bool)$closure($feature);
	}
}