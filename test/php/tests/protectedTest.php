<?php // Copyright (c) 2016 Keith Bronstrup and Contributors

class protectedTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @covers HUID::validateNS
	 * @uses   HUID::__construct
	 * @uses   HUID::validateNS
	 * @uses   HUID::testProtected
	 * @uses   HUID::isStr
	 * @uses   HUID::strToHex
	 * @uses   HUID::isHex
	 * @uses   HUID::isBin
	 * @uses   HUID::binToHex
	 */

	public function test_validateNS ()
	{
		$HUID = new HUID;
		$this->assertEquals(true, $HUID->testProtected('validateNS'));
	}


	/**
	 * @covers HUID::isStr
	 * @uses   HUID::__construct
	 * @uses   HUID::validateNS
	 * @uses   HUID::testProtected
	 * @uses   HUID::isStr
	 */

	public function test_isStr ()
	{
		$HUID = new HUID;
		$this->assertEquals(true, $HUID->testProtected('isStr'));
	}


	/**
	 * @covers HUID::isHex
	 * @uses   HUID::__construct
	 * @uses   HUID::validateNS
	 * @uses   HUID::testProtected
	 * @uses   HUID::isHex
	 */

	public function test_isHex ()
	{
		$HUID = new HUID;
		$this->assertEquals(true, $HUID->testProtected('isHex'));
	}


	/**
	 * @covers HUID::isBin
	 * @uses   HUID::__construct
	 * @uses   HUID::validateNS
	 * @uses   HUID::testProtected
	 * @uses   HUID::isBin
	 */

	public function test_isBin ()
	{
		$HUID = new HUID;
		$this->assertEquals(true, $HUID->testProtected('isBin'));
	}
}
