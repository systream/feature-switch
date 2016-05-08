<?php


namespace Tests\Systream\Unit\FeatureSwitch\Feature\Switcher;


use Systream\FeatureSwitch\Feature\Switcher\Until;

class UntilTest extends AbstractTest
{

	/**
	 * @test
	 */
	public function timeNotReached_default()
	{
		$this->assertUntilFeature(time()+5, false);
	}

	/**
	 * @test
	 */
	public function timeReached_default()
	{
		$this->assertUntilFeature(time() - 10, true);
	}

	/**
	 * @test
	 */
	public function timeNotReached_Enabled()
	{
		$this->assertUntilFeature(time() + 10, false, true);
	}

	/**
	 * @test
	 */
	public function timeReached_Enabled()
	{
		$this->assertUntilFeature(time() - 10, true, true);
	}

	/**
	 * @test
	 */
	public function timeNotReached_Disabled()
	{
		$this->assertUntilFeature(time() + 10, true, false);
	}

	/**
	 * @test
	 */
	public function timeReached_Disabled()
	{
		$this->assertUntilFeature(time() - 10, false, false);
	}

	/**
	 * @test
	 */
	public function onTime()
	{
		$this->assertUntilFeature(time(), true);
	}

	/**
	 * @param int $timeStamp
	 * @param bool $expected
	 * @param null|bool $state
	 */
	protected function assertUntilFeature($timeStamp, $expected, $state = null)
	{
		$dateTime = new \DateTime();
		$dateTime->setTimestamp($timeStamp);
		$featureSwitch = new Until($dateTime);
		if ($state !== null) {
			$featureSwitch->setState($state);
		}

		$this->assertEquals($expected,
			$featureSwitch->isEnabled($this->getFeatureMock())
		);
	}
}
