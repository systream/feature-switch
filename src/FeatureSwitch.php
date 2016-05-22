<?php

namespace Systream;


use Systream\FeatureSwitch\Feature;
use Systream\FeatureSwitch\Feature\Switcher\Simple;

class FeatureSwitch implements \Iterator, \ArrayAccess
{
	/**
	 * @var Feature\SwitchableFeatureInterface[]
	 */
	protected $features = array();

	/**
	 * @var int
	 */
	protected $currentIndex = 0;

	/**
	 * @param string $key
	 * @param bool $status
	 * @return Feature
	 */
	public static function buildFeature($key, $status)
	{
		$feature = new Feature($key);

		if ($status) {
			$feature->addSwitcher(Simple::on());
		}

		return $feature;
	}

	/**
	 * @param Feature\SwitchableFeatureInterface $feature
	 * @throws \Exception
	 */
	public function addFeature(Feature\SwitchableFeatureInterface $feature)
	{
		if (isset($this->features[$feature->getKey()])) {
			throw new \Exception(sprintf('There are already a feature with this key: %s', $feature->getKey()));
		}
		$this->features[$feature->getKey()] = $feature;
	}

	/**
	 * @param string $key
	 * @return bool
	 * @throws \Exception
	 */
	public function isEnabled($key)
	{
		if (!isset($this->features[$key])) {
			throw new \Exception(sprintf('Unknown feature: %s', $key));
		}
		return $this->features[$key]->isEnabled();
	}

	/**
	 * Return the current element
	 * @link http://php.net/manual/en/iterator.current.php
	 * @return mixed Can return any type.
	 * @since 5.0.0
	 */
	public function current()
	{
		return array_values($this->features)[$this->currentIndex];
	}

	/**
	 * Move forward to next element
	 * @link http://php.net/manual/en/iterator.next.php
	 * @return void Any returned value is ignored.
	 * @since 5.0.0
	 */
	public function next()
	{
		$this->currentIndex++;
	}

	/**
	 * Return the key of the current element
	 * @link http://php.net/manual/en/iterator.key.php
	 * @return mixed scalar on success, or null on failure.
	 * @since 5.0.0
	 */
	public function key()
	{
		return array_keys($this->features)[$this->currentIndex];
	}

	/**
	 * Checks if current position is valid
	 * @link http://php.net/manual/en/iterator.valid.php
	 * @return boolean The return value will be casted to boolean and then evaluated.
	 * Returns true on success or false on failure.
	 * @since 5.0.0
	 */
	public function valid()
	{
		$features = array_values($this->features);
		return isset($features[$this->currentIndex]);
	}

	/**
	 * Rewind the Iterator to the first element
	 * @link http://php.net/manual/en/iterator.rewind.php
	 * @return void Any returned value is ignored.
	 * @since 5.0.0
	 */
	public function rewind()
	{
		$this->currentIndex = 0;
	}

	/**
	 * Whether a offset exists
	 * @link http://php.net/manual/en/arrayaccess.offsetexists.php
	 * @param mixed $offset <p>
	 * An offset to check for.
	 * </p>
	 * @return boolean true on success or false on failure.
	 * </p>
	 * <p>
	 * The return value will be casted to boolean if non-boolean was returned.
	 * @since 5.0.0
	 */
	public function offsetExists($offset)
	{
		return isset($this->features[$offset]);
	}

	/**
	 * Offset to retrieve
	 * @link http://php.net/manual/en/arrayaccess.offsetget.php
	 * @param mixed $offset <p>
	 * The offset to retrieve.
	 * </p>
	 * @return Feature\SwitchableFeatureInterface
	 * @since 5.0.0
	 */
	public function offsetGet($offset)
	{
		return $this->features[$offset];
	}

	/**
	 * Offset to set
	 * @link http://php.net/manual/en/arrayaccess.offsetset.php
	 * @param mixed $offset <p>
	 * The offset to assign the value to.
	 * </p>
	 * @param Feature\SwitchableFeatureInterface $value <p>
	 * The value to set.
	 * </p>
	 * @throws \Exception
	 * @since 5.0.0
	 */
	public function offsetSet($offset, $value)
	{
		if (!$value instanceof Feature\SwitchableFeatureInterface) {
			throw new \Exception('The value must be SwitchableFeatureInterface');
		}

		if (!is_null($offset)) {
			if ($offset != $value->getKey()) {
				throw new \Exception('The given key and the feature key are not the same.');
			}
			$this->features[$offset] = $value;
			return;
		}

		$this->features[$value->getKey()] = $value;

	}

	/**
	 * Offset to unset
	 * @link http://php.net/manual/en/arrayaccess.offsetunset.php
	 * @param mixed $offset <p>
	 * The offset to unset.
	 * </p>
	 * @return void
	 * @since 5.0.0
	 */
	public function offsetUnset($offset)
	{
		if (isset($this->features[$offset])) {
			unset($this->features[$offset]);
		}
	}
}