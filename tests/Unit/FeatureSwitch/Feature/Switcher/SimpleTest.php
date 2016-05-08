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
		$toggle = new Simple(true);
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
	 * @param mixed $value
	 * @param bool $expected
	 *
	 * @test
	 * @dataProvider specialSwitchValues
	 */
	public function assetSwitch($value, $expected)
	{
		$toggle = new Simple($value);
		$this->assertEquals($expected, $toggle->isEnabled($this->getFeatureMock()));
	}

	/**
	 * @test
	 */
	public function staticHelperEnabled()
	{
		$this->assertEquals(
			new Simple(true),
			Simple::enabled()
		);
	}

	/**
	 * @test
	 */
	public function staticHelperDisabled()
	{
		$this->assertEquals(
			new Simple(false),
			Simple::disabled()
		);
	}

	/**
	 * @return array
	 */
	public function specialSwitchValues()
	{
		return array(
			array(1, true),
			array(0, false),
			array(array(), false),
			array(array('foo', 'bar'), true),
			array('foo', true),
			array(null, false),
		);
	}
}
