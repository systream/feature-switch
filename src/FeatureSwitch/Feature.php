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
	 * @var string
	 */
	protected $name;

	/**
	 * @var FeatureSwitcherInterface[]
	 */
	protected $featureSwitcher = array();

	/**
	 * Feature constructor.
	 * @param string $key
	 * @param string $name
	 */
	public function __construct($key, $name = '')
	{
		$this->key = $key;
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getKey()
	{
		return $this->key;
	}

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