<?php namespace Myth\Bay;

interface CacheInterface {

	/**
	 * Provides a way to retrieve a single item from
	 * the cache.
	 *
	 * Used by the Bay to get the latest cached version of
	 * the view.
	 *
	 * @param $key
	 * @return string|null
	 */
	public function get($key);

	//--------------------------------------------------------------------

	/**
	 * Provides a way to set a single cache item.
	 *
	 * @param string $key
	 * @param string $content
	 * @param int $ttl          // Time in _minutes_
	 * @return mixed
	 */
	public function set($key, $content, $ttl);

	//--------------------------------------------------------------------

}