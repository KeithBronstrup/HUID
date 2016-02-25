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
		$this->assertEquals('HUID', get_class(new HUID('aaaa', 'bbb')));
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
			new HUID('aaa', 'bbb');
			$this->fail('Expected exception "HUID created with invalid Primary Namespace" not thrown');
		} catch (Exception $e) {
			$this->assertEquals('HUID created with invalid Primary Namespace', $e->getMessage());
		}

		try
		{
			new HUID('aaaa', 'bb');
			$this->fail('Expected exception "HUID created with invalid Secondary Namespace" not thrown');
		} catch (Exception $e) {
			$this->assertEquals('HUID created with invalid Secondary Namespace', $e->getMessage());
		}

		try
		{
			new HUID('aaa', 'bb');
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
		$HUID = new HUID('aaaa', 'bbb');
		$this->assertEquals(1, preg_match('/[0-9a-f]{14}-[0-9a-f]{7}-a{4}-b{3}-[0-9a-f]{4}/', $HUID->get('str')));
	}
}
