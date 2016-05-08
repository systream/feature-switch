<?php

namespace Systream\FeatureSwitch\Feature;


interface FeatureInterface
{
	/**
	 * @return string
	 */
	public function getKey();
}