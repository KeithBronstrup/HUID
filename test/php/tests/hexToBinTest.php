<?php // Copyright (c) 2016 Keith Bronstrup and Contributors

class hexToBinTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @covers HUID::hexToBin
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::hexToBin
	 * @uses   HUID::isHex
	 */

	public function testSuccess ()
	{
		$HUID = new HUID;
		$this->assertEquals('3333333DDDEUVfww', $HUID->hexToBin('33333333333333444444455556667777'));
	}


	/**
	 * @covers HUID::hexToBin
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::hexToBin
	 * @uses   HUID::isHex
	 */

	public function testFailure ()
	{
		$HUID = new HUID;
		$this->assertEquals(false, $HUID->hexToBin('333333333333344444455566777'));
	}
}
