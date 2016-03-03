<?php // Copyright (c) 2016 Keith Bronstrup and Contributors

class binToStrTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @covers HUID::binToStr
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::binToStr
	 * @uses   HUID::isBin
	 */

	public function testSuccess ()
	{
		$HUID = new HUID;
		$this->assertEquals('33333333333333-44444-5555-6666-77777', $HUID->binToStr('3333333DDEUVfgww'));
	}


	/**
	 * @covers HUID::binToStr
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::binToStr
	 * @uses   HUID::isBin
	 */

	public function testFailure ()
	{
		$HUID = new HUID;
		$this->assertEquals(false, $HUID->binToStr('333333DDUfw'));
	}
}
