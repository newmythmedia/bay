<?php
/**
 * Created by PhpStorm.
 * User: Lonnie
 * Date: 5/26/15
 * Time: 10:52 PM
 */

use \Myth\Bay\Bay;


class BayTest extends \PHPUnit_Framework_TestCase {

	//--------------------------------------------------------------------
	// parseParameters()
	//--------------------------------------------------------------------

	public function testParseReturnsNullWithInvalid()
	{
		$bay = new Bay();

		$this->assertNull($bay->prepareParams(1.023));
	}

	//--------------------------------------------------------------------

	public function testParseReturnsNullWithEmptyString()
	{
		$bay = new Bay();

		$this->assertNull($bay->prepareParams(''));
	}

	//--------------------------------------------------------------------

	public function testParseReturnsSelfWhenArray()
	{
		$bay = new Bay();
		$object = ['one' => 'two', 'three' => 'four'];


		$this->assertEquals($object, $bay->prepareParams($object));
	}

	//--------------------------------------------------------------------

	public function testParseReturnsNullWithEmptyArray()
	{
		$bay = new Bay();

		$this->assertNull($bay->prepareParams([]));
	}

	//--------------------------------------------------------------------

	public function testParseReturnsArrayWithString()
	{
		$bay = new Bay();
		$params = 'one=two three=four';
		$expected = ['one' => 'two', 'three' => 'four'];

		$this->assertEquals($expected, $bay->prepareParams($params));
	}

	//--------------------------------------------------------------------

	public function testParseHandlesCommas()
	{
		$bay = new Bay();
		$params = 'one=2, three=4.15';
		$expected = ['one' => 2, 'three' => 4.15];

		$this->assertEquals($expected, $bay->prepareParams($params));
	}

	//--------------------------------------------------------------------

	public function testParseWorksWithoutSpaces()
	{
		$bay = new Bay();
		$params = 'one=two,three=four';
		$expected = ['one' => 'two', 'three' => 'four'];

		$this->assertEquals($expected, $bay->prepareParams($params));
	}

	//--------------------------------------------------------------------

	//--------------------------------------------------------------------
	// Display()
	//--------------------------------------------------------------------

	public function testDisplayRendersWithNamespacedClass()
	{
		$bay = new Bay();
		$expected = 'Hello';

		$this->assertEquals($expected, $bay->display('\SampleClass::hello'));
	}

	//--------------------------------------------------------------------

	public function testDisplayRendersWithValidParamString()
	{
		$bay = new Bay();
		$params = 'one=two,three=four';
		$expected = ['one' => 'two', 'three' => 'four'];

		$this->assertEquals($expected, $bay->display('\SampleClass::echobox', $params));
	}

	//--------------------------------------------------------------------

	public function testDisplayRendersWithStaticMethods()
	{
		$bay = new Bay();
		$params = 'one=two,three=four';
		$expected = ['one' => 'two', 'three' => 'four'];

		$this->assertEquals($expected, $bay->display('\SampleClass::staticEcho', $params));
	}

	//--------------------------------------------------------------------
}
