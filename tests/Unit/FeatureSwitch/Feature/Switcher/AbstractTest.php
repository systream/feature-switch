<?php

namespace Tests\Systream\Unit\FeatureSwitch\Feature\Switcher;


use Systream\FeatureSwitch\Feature\FeatureInterface;
use Systream\FeatureSwitch\Feature\Switcher\Simple;

abstract class AbstractTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @param string $key
	 * @param string $name
	 * @return \PHPUnit_Framework_MockObject_MockObject|FeatureInterface
	 */
	protected function getFeatureMock($key = '', $name = '')
	{
		$mock = $this->getMockBuilder('\Systream\FeatureSwitch\Feature\FeatureInterface')->getMock();
		if ($key) {
			$mock
				->expects($this->any())
				->method('getKey')
				->will($this->returnValue($key));
		}

		if ($name) {
			$mock
				->expects($this->any())
				->method('getName')
				->will($this->returnValue($name));
		}

		return $mock;
	}

}
