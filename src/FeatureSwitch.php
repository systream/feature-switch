<?php

namespace Systream;


use Systream\FeatureSwitch\Feature;

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
			$feature->addSwitcher(Feature\Switcher\Simple::on());
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
			throw new \Exception('Thre is already a feature with this key.');
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
			throw new \Exception('Unknown feature.');
		}
		return $this->features[$key]->isEnabled();
	}
}