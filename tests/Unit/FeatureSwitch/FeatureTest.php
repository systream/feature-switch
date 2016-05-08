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
		$feature->addSwitcher(Simple::on());
		$this->assertTrue($feature->isEnabled());
	}

	/**
	 * @test
	 */
	public function isFeatureEnabled_setSimpleSwitcherOff()
	{
		$feature = new Feature('test');
		$feature->addSwitcher(Simple::off());
		$this->assertFalse($feature->isEnabled());
	}

	/**
	 * @test
	 */
	public function multipleFeatures_allDisabled()
	{
		$feature = new Feature('test');
		$feature->addSwitcher(Simple::off());
		$feature->addSwitcher(Simple::off());
		$this->assertFalse($feature->isEnabled());
	}

	/**
	 * @test
	 */
	public function multipleFeatures_OneEnabled()
	{
		$feature = new Feature('test');
		$feature->addSwitcher(Simple::off());
		$feature->addSwitcher(Simple::on());
		$this->assertTrue($feature->isEnabled());
	}

	/**
	 * @test
	 */
	public function multipleFeatures_AllEnabled()
	{
		$feature = new Feature('test');
		$feature->addSwitcher(Simple::on());
		$feature->addSwitcher(Simple::on());
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
