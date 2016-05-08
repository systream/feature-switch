<?php

namespace Systream\FeatureSwitch\Feature\Switcher;


use Systream\FeatureSwitch\Feature\FeatureInterface;
use Systream\FeatureSwitch\Feature\FeatureSwitcherInterface;

class Until implements FeatureSwitcherInterface
{
	/**
	 * @var \DateTime
	 */
	private $dateTime;

	/**
	 * @var bool
	 */
	private $newState = true;

	/**
	 * @param \DateTime $dateTime
	 */
	public function __construct(\DateTime $dateTime)
	{
		$this->dateTime = $dateTime;
	}

	/**
	 * @param FeatureInterface $feature
	 * @return bool
	 */
	public function isEnabled(FeatureInterface $feature)
	{
		$currentDate = new \DateTime();

		$state = $this->newState;

		$dateDiff = $currentDate->getTimestamp() - $this->dateTime->getTimestamp();
		if ($dateDiff < 0) {
			$state = !$state;
		}

		return $state;
	}

	/**
	 * @param bool $state
	 */
	public function setState($state)
	{
		$this->newState = (bool)$state;
	}
}