<?php

namespace Systream;


use Systream\FeatureSwitch\Feature;
use Systream\FeatureSwitch\Feature\Switcher\Simple;

class FeatureSwitch
{
	/**
	 * @var Feature\SwitchableFeatureInterface[]
	 */
	protected $features = array();

	/**
	 * @param string $key
	 * @param bool $status
	 * @return Feature
	 */
	public static function buildFeature($key, $status)
	{
		$feature = new Feature($key);

		if ($status) {
			$feature->addSwitcher(Simple::on());
		}

		return $feature;
	}

	/**
	 * @param Feature\SwitchableFeatureInterface $feature
	 * @throws \RuntimeException
	 */
	public function addFeature(Feature\SwitchableFeatureInterface $feature)
	{
		if (isset($this->features[$feature->getKey()])) {
			throw new \RuntimeException(sprintf('There are already a feature with this key: %s', $feature->getKey()));
		}
		
		$this->storeFeature($feature);
	}

	/**
	 * @param string $key
	 * @return bool
	 * @throws \RuntimeException
	 */
	public function isEnabled($key)
	{
		if (!isset($this->features[$key])) {
			throw new \RuntimeException(sprintf('Unknown feature: %s', $key));
		}
		return $this->features[$key]->isEnabled();
	}

	/**
	 * @param Feature\SwitchableFeatureInterface $feature
	 */
	protected function storeFeature(Feature\SwitchableFeatureInterface $feature)
	{
		$this->features[$feature->getKey()] = $feature;
	}
}