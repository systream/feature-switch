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
	 * @throws \Exception
	 */
	public function addFeature(Feature\SwitchableFeatureInterface $feature)
	{
		if (isset($this->features[$feature->getKey()])) {
			throw new \Exception(sprintf('There are already a feature with this key: %s', $feature->getKey()));
		}
		$this->features[$feature->getKey()] = $feature;
	}

	/**
	 * @param string $key
	 * @return bool
	 * @throws \Exception
	 */
	public function isEnabled($key)
	{
		if (!isset($this->features[$key])) {
			throw new \Exception(sprintf('Unknown feature: %s', $key));
		}
		return $this->features[$key]->isEnabled();
	}
}