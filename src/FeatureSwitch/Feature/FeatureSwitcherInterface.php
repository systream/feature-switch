<?php

namespace Systream\FeatureSwitch\Feature;


interface FeatureSwitcherInterface
{
	/**
	 * @param FeatureInterface $feature
	 * @return bool
	 */
	public function isEnabled(FeatureInterface $feature);
}