<?php // Copyright (c) 2016 Keith Bronstrup and Contributors

class validateHUIDTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @covers HUID::binToHex
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::validateHUID
	 * @uses   HUID::isStr
	 * @uses   HUID::strToHex
	 */

	public function testValidStr ()
	{
		$HUID = new HUID;
		$testHUID = '33333333333333-44444-5555-6666-77777';
		$this->assertEquals('str', $HUID->validateHUID($testHUID));
	}


	/**
	 * @covers HUID::binToHex
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::validateHUID
	 * @uses   HUID::isStr
	 * @uses   HUID::strToHex
	 */

	public function testValidStrWithMatchingNS ()
	{
		$HUID = new HUID;
		$testHUID = '33333333333333-44444-5555-6666-77777';
		$this->assertEquals('str', $HUID->validateHUID($testHUID, '5555'));
		$this->assertEquals('str', $HUID->validateHUID($testHUID, null, '6666'));
		$this->assertEquals('str', $HUID->validateHUID($testHUID, '5555', '6666'));
	}


	/**
	 * @covers HUID::binToHex
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::validateHUID
	 * @uses   HUID::isStr
	 * @uses   HUID::strToHex
	 */

	public function testValidStrWithNonmatchingNS ()
	{
		$HUID = new HUID;
		$testHUID = '33333333333333-44444-5555-6666-77777';
		$this->assertEquals(false, $HUID->validateHUID($testHUID, 'aaaa'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, null, 'bbbb'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, 'aaaa', 'bbbb'));
	}


	/**
	 * @covers HUID::binToHex
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::validateHUID
	 * @uses   HUID::isStr
	 * @uses   HUID::strToHex
	 */

	public function testValidStrWithInvalidNS ()
	{
		$HUID = new HUID;
		$testHUID = '33333333333333-44444-5555-6666-77777';
		$this->assertEquals(false, $HUID->validateHUID($testHUID, '555'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, null, '666'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, '555', '666'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, '5555', '666'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, '555', '666'));
	}


	/**
	 * @covers HUID::binToHex
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::validateHUID
	 * @uses   HUID::isStr
	 */

	public function testInvalidStr ()
	{
		$HUID = new HUID;
		$testHUID = '3333333333333-4444-555-666-7777';
		$this->assertEquals(false, $HUID->validateHUID($testHUID));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, '5555'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, null, '6666'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, '5555', '6666'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, 'aaaa'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, null, 'bbbb'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, 'aaaa', 'bbbb'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, '555'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, null, '666'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, '555', '6666'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, '5555', '666'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, '555', '666'));
	}


	/**
	 * @covers HUID::binToHex
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::validateHUID
	 * @uses   HUID::isHex
	 */

	public function testValidHex ()
	{
		$HUID = new HUID;
		$testHUID = '33333333333333444445555666677777';
		$this->assertEquals('hex', $HUID->validateHUID($testHUID));
	}


	/**
	 * @covers HUID::binToHex
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::validateHUID
	 * @uses   HUID::isHex
	 */

	public function testValidHexWithMatchingNS ()
	{
		$HUID = new HUID;
		$testHUID = '33333333333333444445555666677777';
		$this->assertEquals('hex', $HUID->validateHUID($testHUID, '5555'));
		$this->assertEquals('hex', $HUID->validateHUID($testHUID, null, '6666'));
		$this->assertEquals('hex', $HUID->validateHUID($testHUID, '5555', '6666'));
	}


	/**
	 * @covers HUID::binToHex
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::validateHUID
	 * @uses   HUID::isHex
	 */

	public function testValidHexWithNonmatchingNS ()
	{
		$HUID = new HUID;
		$testHUID = '33333333333333444445555666677777';
		$this->assertEquals(false, $HUID->validateHUID($testHUID, 'aaaa'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, null, 'bbbb'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, 'aaaa', 'bbbb'));
	}


	/**
	 * @covers HUID::binToHex
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::validateHUID
	 * @uses   HUID::isHex
	 */

	public function testValidHexWithInvalidNS ()
	{
		$HUID = new HUID;
		$testHUID = '33333333333333444445555666677777';
		$this->assertEquals(false, $HUID->validateHUID($testHUID, '555'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, null, '666'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, '555', '666'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, '5555', '666'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, '555', '666'));
	}


	/**
	 * @covers HUID::binToHex
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::validateHUID
	 * @uses   HUID::isHex
	 */

	public function testInvalidHex ()
	{
		$HUID = new HUID;
		$testHUID = '333333333333344445556667777';
		$this->assertEquals(false, $HUID->validateHUID($testHUID));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, '5555'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, null, '6666'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, '5555', '6666'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, 'aaaa'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, null, 'bbbb'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, 'aaaa', 'bbbb'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, '555'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, null, '666'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, '555', '6666'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, '5555', '666'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, '555', '666'));
	}


	/**
	 * @covers HUID::binToHex
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::validateHUID
	 * @uses   HUID::isBin
	 * @uses   HUID::binToHex
	 */

	public function testValidBin ()
	{
		$HUID = new HUID;
		$testHUID = '3333333DDEUVfgww';
		$this->assertEquals('bin', $HUID->validateHUID($testHUID));
	}


	/**
	 * @covers HUID::binToHex
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::validateHUID
	 * @uses   HUID::isBin
	 * @uses   HUID::binToHex
	 */

	public function testValidBinWithMatchingNS ()
	{
		$HUID = new HUID;
		$testHUID = '3333333DDEUVfgww';
		$this->assertEquals('bin', $HUID->validateHUID($testHUID, '5555'));
		$this->assertEquals('bin', $HUID->validateHUID($testHUID, null, '6666'));
		$this->assertEquals('bin', $HUID->validateHUID($testHUID, '5555', '6666'));
	}


	/**
	 * @covers HUID::binToHex
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::validateHUID
	 * @uses   HUID::isBin
	 * @uses   HUID::binToHex
	 */

	public function testValidBinWithNonmatchingNS ()
	{
		$HUID = new HUID;
		$testHUID = '3333333DDEUVfgww';
		$this->assertEquals(false, $HUID->validateHUID($testHUID, 'aaaa'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, null, 'bbbb'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, 'aaaa', 'bbbb'));
	}


	/**
	 * @covers HUID::binToHex
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::validateHUID
	 * @uses   HUID::isBin
	 * @uses   HUID::binToHex
	 */

	public function testValidBinwithInvalidNS ()
	{
		$HUID = new HUID;
		$testHUID = '3333333DDEUVfgww';
		$this->assertEquals(false, $HUID->validateHUID($testHUID, '555'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, null, '666'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, '555', '666'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, '5555', '666'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, '555', '666'));
	}


	/**
	 * @covers HUID::binToHex
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::validateHUID
	 * @uses   HUID::isBin
	 */

	public function testInvalidBin ()
	{
		$HUID = new HUID;
		$testHUID = '333333DDUfw';
		$this->assertEquals(false, $HUID->validateHUID($testHUID));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, '5555'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, null, '6666'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, '5555', '6666'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, 'aaaa'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, null, 'bbbb'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, 'aaaa', 'bbbb'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, '555'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, null, '666'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, '555', '6666'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, '5555', '666'));
		$this->assertEquals(false, $HUID->validateHUID($testHUID, '555', '666'));
	}
}
