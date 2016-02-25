<?php // Copyright (c) 2016 Keith Bronstrup and Contributors

class binToHexTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @covers HUID::binToHex
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::binToHex
	 * @uses   HUID::isBin
	 */

	public function testSuccess ()
	{
		$HUID = new HUID;
		$this->assertEquals('33333333333333444444455556667777', $HUID->binToHex('3333333DDDEUVfww'));
	}


	/**
	 * @covers HUID::binToHex
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::binToHex
	 * @uses   HUID::isBin
	 */

	public function testFailure ()
	{
		$HUID = new HUID;
		$this->assertEquals(false, $HUID->binToHex('333333DDEVw'));
	}
}
