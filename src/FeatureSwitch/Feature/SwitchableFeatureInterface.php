<?php

namespace Systream\FeatureSwitch\Feature;


interface SwitchableFeatureInterface
{
	/**
	 * @return bool
	 */
	public function isEnabled();

	/**
	 * @param FeatureSwitcherInterface $featureSwitcher
	 * @return void
	 */
	public function addSwitcher(FeatureSwitcherInterface $featureSwitcher);
}