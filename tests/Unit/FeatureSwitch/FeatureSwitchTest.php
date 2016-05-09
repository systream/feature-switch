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
		$feature = FeatureSwitch::buildFeature('foo', true);
		$this->assertTrue($feature->isEnabled());
		$this->assertEquals('foo', $feature->getKey());
	}

	/**
	 * @test
	 */
	public function featureFactory_disabled()
	{
		$feature = FeatureSwitch::buildFeature('bar', false);
		$this->assertFalse($feature->isEnabled());
		$this->assertEquals('bar', $feature->getKey());
	}

	/**
	 * @test
	 */
	public function addFeature_enabled()
	{
		$featureSwitch = new FeatureSwitch();
		$featureSwitch->addFeature(FeatureSwitch::buildFeature('foo', true));
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
		$featureSwitch = new FeatureSwitch();
		$featureSwitch->addFeature(FeatureSwitch::buildFeature('foo', true));
		$featureSwitch->addFeature(FeatureSwitch::buildFeature('bar', false));

		$this->assertFalse($featureSwitch->isEnabled('bar'));
	}

	/**
	 * @test
	 * @expectedException \Exception
	 */
	public function addFeature_missing()
	{
		$featureSwitch = new FeatureSwitch();
		$featureSwitch->addFeature(FeatureSwitch::buildFeature('foo', true));

		$this->assertTrue($featureSwitch->isEnabled('foo_missing'));
	}

	/**
	 * @test
	 * @expectedException \Exception
	 */
	public function addFeature_addTwiceTheSame()
	{
		$featureSwitch = new FeatureSwitch();
		$featureSwitch->addFeature(FeatureSwitch::buildFeature('foo', true));
		$featureSwitch->addFeature(FeatureSwitch::buildFeature('foo', false));
	}
}
