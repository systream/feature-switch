<?php

namespace Tests\Systream\Unit\FeatureSwitch;


use Systream\FeatureSwitch;

class FeatureSwitchTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @test
	 */
	public function featureFactory_enabled()
	{
		$featureSwitch = $this->getClass();
		$feature = $featureSwitch::buildFeature('foo', true);
		$this->assertTrue($feature->isEnabled());
		$this->assertEquals('foo', $feature->getKey());
	}

	/**
	 * @test
	 */
	public function featureFactory_disabled()
	{
		$featureSwitch = $this->getClass();
		$feature = $featureSwitch::buildFeature('bar', false);
		$this->assertFalse($feature->isEnabled());
		$this->assertEquals('bar', $feature->getKey());
	}

	/**
	 * @test
	 */
	public function addFeature_enabled()
	{
		$featureSwitch = $this->getClass();
		$featureSwitch->addFeature($featureSwitch::buildFeature('foo', true));
		$feature = new FeatureSwitch\Feature('bar2');
		$feature->addSwitcher(new FeatureSwitch\Feature\Switcher\AB());
		$featureSwitch->addFeature($feature);

		$this->assertTrue($featureSwitch->isEnabled('foo'));
	}

	/**
	 * @test
	 */
	public function addFeature_disabled()
	{
		$featureSwitch = $this->getClass();
		$featureSwitch->addFeature($featureSwitch::buildFeature('foo', true));
		$featureSwitch->addFeature($featureSwitch::buildFeature('bar', false));

		$this->assertFalse($featureSwitch->isEnabled('bar'));
	}

	/**
	 * @test
	 * @expectedException \Exception
	 */
	public function addFeature_missing()
	{
		$featureSwitch = $this->getClass();
		$featureSwitch->addFeature($featureSwitch::buildFeature('foo', true));

		$this->assertTrue($featureSwitch->isEnabled('foo_missing'));
	}

	/**
	 * @test
	 * @expectedException \Exception
	 */
	public function addFeature_addTwiceTheSame()
	{
		$featureSwitch = $this->getClass();
		$featureSwitch->addFeature($featureSwitch::buildFeature('foo', true));
		$featureSwitch->addFeature($featureSwitch::buildFeature('foo', false));
	}
	
	/**
	 * @return FeatureSwitch
	 */
	protected function getClass()
	{
		return new FeatureSwitch();
	}
}
