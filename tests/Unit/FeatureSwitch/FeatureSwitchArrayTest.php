<?php

namespace Tests\Systream\Unit\FeatureSwitch;


use Systream\FeatureSwitch;
use Systream\FeatureSwitchArray;

class FeatureSwitchArrayTest extends FeatureSwitchTest
{

	/**
	 * @test
	 */
	public function iterator_unset()
	{
		$featureSwitch = $this->getClass();
		$featureSwitch[] = $featureSwitch::buildFeature('foo', true);

		$this->assertTrue(isset($featureSwitch['foo']));

		unset($featureSwitch['foo']);
		$this->assertFalse(isset($featureSwitch['foo']));
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

		$featureSwitch = $this->getClass();
		foreach ($featureNames as $featureName) {
			$featureSwitch->addFeature($featureSwitch::buildFeature($featureName, true));
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
		/** @var FeatureSwitch\Feature[] $featureSwitch */
		$featureSwitch = $this->getClass();
		$featureSwitch->addFeature($featureSwitch::buildFeature('foo', true));

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
		$featureSwitch = $this->getClass();
		$feature = $featureSwitch::buildFeature('foo', true);
		$featureSwitch['foo'] = $feature;

		$this->assertTrue($featureSwitch->isEnabled('foo'));
	}

	/**
	 * @test
	 * @expectedException \Exception
	 */
	public function iteratorSet_nameNotTheSame()
	{
		$featureSwitch = $this->getClass();
		$featureSwitch['foo'] = $featureSwitch::buildFeature('foo2', true);
	}


	/**
	 * @test
	 */
	public function iteratorSet_withoutKey()
	{
		$featureSwitch = $this->getClass();
		$featureSwitch[] = $featureSwitch::buildFeature('foo', true);
		$this->assertTrue($featureSwitch->isEnabled('foo'));
		$featureSwitch['foo']->isEnabled();
	}

	/**
	 * @test
	 * @expectedException \Exception
	 */
	public function iteratorSet_notFeature_withKey()
	{
		$featureSwitch = $this->getClass();
		$featureSwitch['foo'] = 'foo';
	}

	/**
	 * @test
	 * @expectedException \Exception
	 */
	public function iteratorSet_notFeature_withoutKey()
	{
		$featureSwitch = $this->getClass();
		$featureSwitch[] = 'foo';
	}


	/**
	 * @return FeatureSwitch
	 */
	protected function getClass()
	{
		return new FeatureSwitchArray();
	}
}
