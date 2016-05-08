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
	private $state;

	/**
	 * @param \DateTime $dateTime
	 * @param bool $state
	 */
	public function __construct(\DateTime $dateTime, $state = true)
	{
		$this->dateTime = $dateTime;
		$this->state = (bool)$state;
	}

	/**
	 * @param FeatureInterface $feature
	 * @return bool
	 */
	public function isEnabled(FeatureInterface $feature)
	{
		$currentDate = new \DateTime();

		$state = $this->state;

		$dateDiff = $currentDate->getTimestamp() - $this->dateTime->getTimestamp();
		if ($dateDiff < 0) {
			$state = !$state;
		}

		return $state;
	}
}