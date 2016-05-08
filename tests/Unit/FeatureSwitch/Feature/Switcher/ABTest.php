<?php

namespace Tests\Systream\Unit\FeatureSwitch\Feature\Switcher;


use Systream\FeatureSwitch\Feature\Switcher\AB;

class ABTest extends AbstractTest
{

	protected function setUp()
	{
		parent::setUp();
		$_COOKIE = array();
	}

	/**
	 * @test
	 * @runInSeparateProcess
	 */
	public function RoundRobin_halfOfUsersHasEnabled()
	{
		$featureSwitch = new AB();
		$_COOKIE = array();
		$featureEnabledCount = 0;
		for ($x = 0; $x < 10; $x++) {
			$_COOKIE = array();
			if ($featureSwitch->isEnabled($this->getFeatureMock())) {
				$featureEnabledCount++;
			}
			usleep(1);
		}

		if ($featureEnabledCount < 3) {
			$this->fail('Feature is enabled less than the 30% of visitors. Current: ' . $featureEnabledCount . '0%');
		}

		if ($featureEnabledCount > 7) {
			$this->fail('Feature is enabled more than the 70% of visitors. Current: ' . $featureEnabledCount . '0%');
		}
	}

	/**
	 * @test
	 * @runInSeparateProcess
	 */
	public function giveTheSameStatusToSameUser()
	{
		$featureSwitch = new AB();
		$feature = $this->getFeatureMock();
		$featureState = $featureSwitch->isEnabled($feature);
		$this->assertEquals($featureState, $featureSwitch->isEnabled($feature));

		$savedCookies = $_COOKIE;

		// generate other feature switch state
		$featureState2 = $featureState;
		while ($featureState2 == $featureState) {
			$_COOKIE = array();
			$featureState2 = $featureSwitch->isEnabled($feature);
		}

		$this->assertNotEquals($featureState, $featureState2);

		$_COOKIE = $savedCookies;
		$this->assertEquals($featureState, $featureSwitch->isEnabled($feature));
	}

	/**
	 * @test
	 * @runInSeparateProcess
	 */
	public function differentFeatureHasStateStorage()
	{
		$featureSwitch = new AB();
		$feature1 = $this->getFeatureMock('foo');
		$feature2 = $this->getFeatureMock('bar');

		$sameCount = 0;

		for ($x = 0; $x < 10; $x++) {
			$_COOKIE = array();
			$featureState1 = $featureSwitch->isEnabled($feature1);
			$featureState2 = $featureSwitch->isEnabled($feature2);

			if ($featureState1 == $featureState2) {
				$sameCount++;
			}
		}

		if ($sameCount == 10) {
			$this->fail('It seems that ab feature uses the same state storage');
		}
		
	}

}
