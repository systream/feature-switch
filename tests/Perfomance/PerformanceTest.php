<?php

namespace Tests\Systream\Performance;


use Systream\FeatureSwitch;

class PerformanceTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @test
	 * @return FeatureSwitch
	 */
	public function add100Feature()
	{
		$startTime = microtime(true);
		$featureSwitch = new FeatureSwitch();

		$count = 100;
		for ($x = 0; $x <= $count; $x++) {
			$featureSwitch->addFeature(FeatureSwitch::buildFeature('feature_name_' . $x, (bool)rand(0, 1)));
		}

		$this->assertLessThan(0.01, microtime(true) - $startTime); // 10 ms

		return $featureSwitch;
	}

	/**
	 * @test
	 * @depends add100Feature
	 */
	public function isEnabled1000Times()
	{
		$featureSwitch = $this->add100Feature();

		$startTime = microtime(true);
		for ($x = 0; $x < 1000; $x++) {
			$featureSwitch->isEnabled('feature_name_' . rand(0, 100));
		}

		$this->assertLessThan(0.01, microtime(true) - $startTime); // 10 ms
	}

}