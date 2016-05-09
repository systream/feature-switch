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
	protected $featureSwitchers = array();

	/**
	 * @var bool
	 */
	protected $isEnabledCache = null;

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
		if ($this->isEnabledCache !== null) {
			return $this->isEnabledCache;
		}

		foreach ($this->featureSwitchers as $featureSwitcher) {
			if ($featureSwitcher->isEnabled($this)) {
				$this->isEnabledCache = true;
				return true;
			}
		}

		$this->isEnabledCache = false;
		return false;
	}

	/**
	 * @param FeatureSwitcherInterface $featureSwitcher
	 */
	public function addSwitcher(FeatureSwitcherInterface $featureSwitcher)
	{
		$this->featureSwitchers[] = $featureSwitcher;
		$this->isEnabledCache = null;
	}
}