<?php // Copyright (c) 2016 Keith Bronstrup and Contributors

class hexToStrTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @covers HUID::hexToStr
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::hexToStr
	 * @uses   HUID::isHex
	 */

	public function testSuccess ()
	{
		$HUID = new HUID;
		$this->assertEquals('33333333333333-44444-5555-6666-77777', $HUID->hexToStr('33333333333333444445555666677777'));
	}


	/**
	 * @covers HUID::hexToStr
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::hexToStr
	 * @uses   HUID::isHex
	 */

	public function testFailure ()
	{
		$HUID = new HUID;
		$this->assertEquals(false, $HUID->hexToStr('333333333333344445556667777'));
	}
}
