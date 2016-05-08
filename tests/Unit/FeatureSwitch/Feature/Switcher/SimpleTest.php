<?php

namespace Tests\Systream\Unit\FeatureSwitch\Feature\Switcher;


use Systream\FeatureSwitch\Feature\Switcher\Simple;

class SimpleTest extends AbstractTest
{
	/**
	 * @test
	 */
	public function toggleDefaultDisabled()
	{
		$toggle = new Simple();
		$this->assertFalse(
			$toggle->isEnabled($this->getFeatureMock())
		);
	}

	/**
	 * @test
	 */
	public function toggleEnabled()
	{
		$toggle = new Simple();
		$toggle->enable();
		$this->assertTrue(
			$toggle->isEnabled($this->getFeatureMock())
		);
	}

	/**
	 * @test
	 */
	public function toggleDisabled()
	{
		$toggle = new Simple();
		$this->assertFalse(
			$toggle->isEnabled($this->getFeatureMock())
		);
	}

	/**
	 * @test
	 */
	public function staticHelperEnabled()
	{
		$switcher = new Simple();
		$switcher->enable();
		$this->assertEquals(
			$switcher,
			Simple::on()
		);
	}

	/**
	 * @test
	 */
	public function staticHelperDisabled()
	{
		$this->assertEquals(
			new Simple(),
			Simple::off()
		);
	}
}
