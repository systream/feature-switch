<?php

namespace Tests\Systream\Unit\FeatureSwitch\Feature\Switcher;


use Systream\FeatureSwitch\Feature\FeatureInterface;

abstract class AbstractTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @param string $key
	 * @return \PHPUnit_Framework_MockObject_MockObject|FeatureInterface
	 */
	protected function getFeatureMock($key = '')
	{
		$mock = $this->getMock('Systream\FeatureSwitch\Feature\FeatureInterface');

		if ($key) {
			$mock
				->expects($this->any())
				->method('getKey')
				->will($this->returnValue($key));
		}
		return $mock;
	}

}
