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

	/**
	 * @test
	 */
	public function iterator()
	{
		
		$featureNames = array(
			'foo',
			'bar',
			'fooBar'
		);
		
		$featureSwitch = new FeatureSwitch();
		foreach ($featureNames as $featureName) {
			$featureSwitch->addFeature(FeatureSwitch::buildFeature($featureName, true));
		}

		$index = 0;
		/** @var FeatureSwitch\Feature $feature */
		foreach ($featureSwitch as $feature) {
			$this->assertEquals($featureNames[$index++], $feature->getKey());
		}

		$this->assertEquals($index, count($featureNames));
	}

	/**
	 * @test
	 */
	public function iterator_isset()
	{
		$featureSwitch = new FeatureSwitch();
		$featureSwitch->addFeature(FeatureSwitch::buildFeature('foo', true));

		$this->assertTrue(isset($featureSwitch['foo']));
		$this->assertFalse(isset($featureSwitch['foo_not_exists']));

		$this->assertTrue(
			$featureSwitch['foo']->isEnabled()
		);
	}

	/**
	 * @test
	 */
	public function iteratorSet_nameSame()
	{
		$featureSwitch = new FeatureSwitch();
		$feature = FeatureSwitch::buildFeature('foo', true);
		$featureSwitch['foo'] = $feature;

		$this->assertTrue($featureSwitch->isEnabled('foo'));
	}

	/**
	 * @test
	 * @expectedException \Exception
	 */
	public function iteratorSet_nameNotTheSame()
	{
		$featureSwitch = new FeatureSwitch();
		$featureSwitch['foo'] = FeatureSwitch::buildFeature('foo2', true);
	}


	/**
	 * @test
	 */
	public function iteratorSet_withoutKey()
	{
		$featureSwitch = new FeatureSwitch();
		$featureSwitch[] = FeatureSwitch::buildFeature('foo', true);
		$this->assertTrue($featureSwitch->isEnabled('foo'));
		$featureSwitch['foo']->isEnabled();
	}

	/**
	 * @test
	 * @expectedException \Exception
	 */
	public function iteratorSet_notFeature_withKey()
	{
		$featureSwitch = new FeatureSwitch();
		$featureSwitch['foo'] = 'foo';
	}

	/**
	 * @test
	 * @expectedException \Exception
	 */
	public function iteratorSet_notFeature_withoutKey()
	{
		$featureSwitch = new FeatureSwitch();
		$featureSwitch[] = 'foo';
	}

	/**
	 * @test
	 */
	public function iterator_unset()
	{
		$featureSwitch = new FeatureSwitch();
		$featureSwitch[] = FeatureSwitch::buildFeature('foo', true);

		$this->assertTrue(isset($featureSwitch['foo']));

		unset($featureSwitch['foo']);
		$this->assertFalse(isset($featureSwitch['foo']));
	}
}
