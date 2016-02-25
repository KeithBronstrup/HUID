<?php // Copyright (c) 2016 Keith Bronstrup and Contributors

class strToHexTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @covers HUID::strToHex
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::strToHex
	 * @uses   HUID::isStr
	 */

	public function testSuccess ()
	{
		$HUID = new HUID;
		$this->assertEquals('33333333333333444444455556667777', $HUID->strToHex('33333333333333-4444444-5555-666-7777'));
	}


	/**
	 * @covers HUID::strToHex
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::strToHex
	 * @uses   HUID::isStr
	 */

	public function testFailure ()
	{
		$HUID = new HUID;
		$this->assertEquals(false, $HUID->strToHex('3333333333333-444444-555-66-777'));
	}
}
