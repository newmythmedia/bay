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

	/**
	 * @expectedException InvalidArgumentException
	 * @expectedExceptionMessage \SampleClass::hello has no params.
	 */
	public function testDisplayRendersWithInvalidParam()
	{
		$bay = new Bay();
		$bay->display('\SampleClass::hello', 'one=two');
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

	public function testDisplayRendersWithValidOneSameNameParamString()
	{
		$bay = new Bay();
		$params = 'params=two';
		$expected = 'two';

		$this->assertEquals($expected, $bay->display('\SampleClass::echobox', $params));
	}

	//--------------------------------------------------------------------

	public function testDisplayRendersWithValidSameNameParam()
	{
		$bay = new Bay();
		$params = ['params' => 'one', 'another' => 'two'];
		$expected = $params;

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

	public function testDisplayRendersWithValidMultipleParamString()
	{
		$bay = new Bay();
		$params = 'a=x b=y c=z';
		$expected = 'xyz';

		$this->assertEquals($expected, $bay->display('\SampleClass::multipleParams', $params));
	}

	//--------------------------------------------------------------------

	public function testDisplayRendersWithValidMultipleParamArray()
	{
		$bay = new Bay();
		$params = ['a' => 'x', 'b' => 'y', 'c' => 'z'];
		$expected = 'xyz';

		$this->assertEquals($expected, $bay->display('\SampleClass::multipleParams', $params));
	}

	//--------------------------------------------------------------------

	public function testDisplayRendersWithValidMultipleParamArrayAnotherOrder()
	{
		$bay = new Bay();
		$params = ['c' => 'z', 'a' => 'x', 'b' => 'y'];
		$expected = 'xyz';

		$this->assertEquals($expected, $bay->display('\SampleClass::multipleParams', $params));
	}

	//--------------------------------------------------------------------

	/**
	 * @expectedException InvalidArgumentException
	 * @expectedExceptionMessage bad is not a valid param name.
	 */
	public function testDisplayRendersWithInvalidMultipleParamArray()
	{
		$bay = new Bay();
		$params = ['a' => 'x', 'b' => 'y', 'bad' => 'z'];
		$bay->display('\SampleClass::multipleParams', $params);
	}

	//--------------------------------------------------------------------
}
