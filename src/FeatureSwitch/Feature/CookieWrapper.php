<?php

namespace Systream\FeatureSwitch\Feature;

class CookieWrapper
{
	/**
	 * @param string $name
	 * @return null|string
	 */
	public function get($name)
	{
		if (isset($_COOKIE[$name])) {
			return $_COOKIE[$name];
		}

		return null;
	}

	/**
	 * @param string $name
	 * @param string $value
	 * @param int $ttl
	 * @return bool
	 */
	public function set($name, $value, $ttl)
	{
		$result = setcookie($name, $value, time() + $ttl);
		$_COOKIE[$name] = $value;
		return $result;
	}
}