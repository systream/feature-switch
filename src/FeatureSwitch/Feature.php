<?php

namespace Systream\FeatureSwitch;


use Systream\FeatureSwitch\Feature\FeatureInterface;
use Systream\FeatureSwitch\Feature\FeatureSwitcherInterface;
use Systream\FeatureSwitch\Feature\SwitchableFeatureInterface;

class Feature implements FeatureInterface, SwitchableFeatureInterface
{
	/**
	 * @var string
	 */
	protected $key;

	/**
	 * @var FeatureSwitcherInterface[]
	 */
	protected $featureSwitcher = array();

	/**
	 * Feature constructor.
	 * @param string $key
	 */
	public function __construct($key)
	{
		$this->key = $key;
	}

	/**
	 * @return string
	 */
	public function getKey()
	{
		return $this->key;
	}

	/**
	 * @return bool
	 */
	public function isEnabled()
	{
		foreach ($this->featureSwitcher as $featureSwitcher) {
			if ($featureSwitcher->isEnabled($this)) {
				return true;
			}
		}

		return false;
	}

	/**
	 * @param FeatureSwitcherInterface $featureSwitcher
	 */
	public function addSwitcher(FeatureSwitcherInterface $featureSwitcher)
	{
		$this->featureSwitcher[] = $featureSwitcher;
	}
}