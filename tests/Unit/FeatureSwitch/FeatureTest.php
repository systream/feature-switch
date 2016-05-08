<?php

namespace Tests\Systream\Unit\FeatureSwitch;


use Systream\FeatureSwitch\Feature;
use Systream\FeatureSwitch\Feature\Switcher\Simple;

class FeatureTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @test
	 */
	public function getKey()
	{
		$key = 'foo';
		$feature = new Feature($key);

		$this->assertEquals(
			$key,
			$feature->getKey()
		);
	}

	/**
	 * @test
	 */
	public function getNameTest()
	{
		$featureName = 'This is the name of the feature';
		$feature = new Feature('fooBar', $featureName);

		$this->assertEquals(
			$featureName,
			$feature->getName()
		);
	}

	/**
	 * @test
	 */
	public function getName_NotSet()
	{
		$feature = new Feature('fooBar2');

		$this->assertEquals(
			'',
			$feature->getName()
		);
	}

	/**
	 * @test
	 */
	public function isFeatureEnabled_defaultNot()
	{
		$feature = new Feature('test');
		$this->assertFalse($feature->isEnabled());
	}

	/**
	 * @test
	 */
	public function isFeatureEnabled_setSimpleSwitcherOn()
	{
		$feature = new Feature('test');
		$feature->addSwitcher(Simple::enabled());
		$this->assertTrue($feature->isEnabled());
	}

	/**
	 * @test
	 */
	public function isFeatureEnabled_setSimpleSwitcherOff()
	{
		$feature = new Feature('test');
		$feature->addSwitcher(Simple::disabled());
		$this->assertFalse($feature->isEnabled());
	}

	/**
	 * @test
	 */
	public function multipleFeatures_allDisabled()
	{
		$feature = new Feature('test');
		$feature->addSwitcher(Simple::disabled());
		$feature->addSwitcher(Simple::disabled());
		$this->assertFalse($feature->isEnabled());
	}

	/**
	 * @test
	 */
	public function multipleFeatures_OneEnabled()
	{
		$feature = new Feature('test');
		$feature->addSwitcher(Simple::disabled());
		$feature->addSwitcher(Simple::enabled());
		$this->assertTrue($feature->isEnabled());
	}

	/**
	 * @test
	 */
	public function multipleFeatures_AllEnabled()
	{
		$feature = new Feature('test');
		$feature->addSwitcher(Simple::enabled());
		$feature->addSwitcher(Simple::enabled());
		$this->assertTrue($feature->isEnabled());
	}

	/**
	 * @test
	 */
	public function noSwitcher()
	{
		$feature = new Feature('test');
		$this->assertFalse($feature->isEnabled());
	}
}
