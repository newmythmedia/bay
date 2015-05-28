<?php namespace Myth\Bay;

class CI3Finder implements LibraryFinderInterface {

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
	public function find($class)
	{
	    $ci =& get_instance();

		$ci->load->library($class);

		// If the library can't be found,
		// it's going to throw an error,
		// so the only possible response is true.
		return true;
	}

	//--------------------------------------------------------------------


}