<?php namespace Myth\Bay;

class CI3Cache implements CacheInterface {

	protected $ci;

	//--------------------------------------------------------------------

	public function __construct()
	{
	    $this->ci =& get_instance();
	}

	//--------------------------------------------------------------------


	/**
	 * Provides a way to retrieve a single item from
	 * the cache.
	 *
	 * Used by the Bay to get the latest cached version of
	 * the view.
	 *
	 * @param $key
	 * @return string|false
	 */
	public function get($key)
	{
		// Does CI even have a cache engine loaded?
		if (! is_object($this->ci->cache))
		{
			return false;
		}

		return $this->ci->cache->get($key);
	}

	//--------------------------------------------------------------------

	/**
	 * Provides a way to set a single cache item.
	 *
	 * @param string $key
	 * @param string $content
	 * @param int $ttl          // Time in _minutes_
	 * @return mixed
	 */
	public function set($key, $content, $ttl)
	{
		// Does CI even have a cache engine loaded?
		if (! is_object($this->ci->cache))
		{
			return true;
		}

		return $this->ci->cache->set($key, $content, $ttl * 60);
	}

	//--------------------------------------------------------------------
}