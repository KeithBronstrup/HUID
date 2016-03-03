<?php // Copyright (c) 2016 Keith Bronstrup and Contributors

class __constructTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @covers HUID::__construct
	 * @uses   HUID::__construct
	 * @uses   HUID::validateNS
	 */

	public function testCanBeConstructedWithNoParams ()
	{
		$this->assertEquals('HUID', get_class(new HUID));
	}


	/**
	 * @covers HUID::__construct
	 * @uses   HUID::__construct
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::generate
	 */

	public function testCanBeConstructedWithValidParams ()
	{
		$this->assertEquals('HUID', get_class(new HUID('5555', '6666')));
	}


	/**
	 * @covers HUID::__construct
	 * @uses   HUID::__construct
	 * @uses   HUID::validateNS
	 */

	public function testCanNotBeConstructedWithInvalidParams ()
	{
		try
		{
			new HUID('555', '6666');
			$this->fail('Expected exception "HUID created with invalid Primary Namespace" not thrown');
		} catch (Exception $e) {
			$this->assertEquals('HUID created with invalid Primary Namespace', $e->getMessage());
		}

		try
		{
			new HUID('5555', '666');
			$this->fail('Expected exception "HUID created with invalid Secondary Namespace" not thrown');
		} catch (Exception $e) {
			$this->assertEquals('HUID created with invalid Secondary Namespace', $e->getMessage());
		}

		try
		{
			new HUID('555', '666');
			$this->fail('Expected exception "HUID created with invalid Primary and Secondary Namespaces" not thrown');
		} catch (Exception $e) {
			$this->assertEquals('HUID created with invalid Primary and Secondary Namespaces', $e->getMessage());
		}
	}


	/**
	 * @covers HUID::__construct
	 * @uses   HUID::__construct
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::generate
	 * @uses   HUID::get
	 */

	public function testGeneratesHUIDWithValidParams ()
	{
		$HUID = new HUID('5555', '6666');
		$this->assertEquals(1, preg_match('/[0-9a-f]{14}-[0-9a-f]{5}-5{4}-6{4}-[0-9a-f]{5}/', $HUID->get('str')));
	}
}
