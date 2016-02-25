<?php // Copyright (c) 2016 Keith Bronstrup and Contributors

class strToBinTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @covers HUID::strToBin
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::strToBin
	 * @uses   HUID::isStr
	 */

	public function testSuccess ()
	{
		$HUID = new HUID;
		$this->assertEquals('3333333DDDEUVfww', $HUID->strToBin('33333333333333-4444444-5555-666-7777'));
	}


	/**
	 * @covers HUID::strToBin
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::strToBin
	 * @uses   HUID::isStr
	 */

	public function testFailure ()
	{
		$HUID = new HUID;
		$this->assertEquals(false, $HUID->strToBin('3333333333333-444444-555-66-777'));
	}
}
