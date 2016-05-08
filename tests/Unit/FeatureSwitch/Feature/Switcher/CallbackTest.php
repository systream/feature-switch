<?php

namespace Tests\Systream\Unit\FeatureSwitch\Feature\Switcher;

use Systream\FeatureSwitch\Feature\Switcher\Callback;

class CallbackTest extends AbstractTest
{

	/**
	 * @test
	 */
	public function return_true()
	{
		$feature = new Callback(function() {
			return true;
		});

		$this->assertTrue(
			$feature->isEnabled($this->getFeatureMock())
		);
	}

	/**
	 * @test
	 */
	public function return_false()
	{
		$feature = new Callback(function() {
			return false;
		});

		$this->assertFalse(
			$feature->isEnabled($this->getFeatureMock())
		);
	}

	/**
	 * @test
	 */
	public function return_void()
	{
		$feature = new Callback(function() {
		});

		$this->assertFalse(
			$feature->isEnabled($this->getFeatureMock())
		);
	}

	/**
	 * @test
	 * @param \Closure $closure
	 * @param bool $excepted
	 *
	 * @dataProvider nonBooleanDataProvider
	 */
	public function nonBoolean(\Closure $closure, $excepted)
	{
		$feature = new Callback($closure);

		$this->assertEquals($excepted, $feature->isEnabled($this->getFeatureMock()));
	}

	/**
	 * @return array
	 */
	public function nonBooleanDataProvider()
	{
		return array(
			array(function(){ return 1; }, true),
			array(function(){ return 0; }, false),
			array(function(){ return 'foo'; }, true),
			array(function(){ return ''; }, false),
			array(function(){ return null; }, false),
			array(function(){ return new \stdClass(); }, true),
		);
	}
}
