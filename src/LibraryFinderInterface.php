<?php namespace Myth\Bay;

interface LibraryFinderInterface {

	/**
	 * Allows framework/project-specific methods of loading a library
	 * when the Bay class cannot autoload it.
	 *
	 * Should load the class into memory and return true or false.
	 *
	 * @param $class
	 *
	 * @return bool
	 */
	public function find($class);

	//--------------------------------------------------------------------

}