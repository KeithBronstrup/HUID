<?php // Copyright (c) 2016 Keith Bronstrup and Contributors

class setNSTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @covers HUID::setNS
	 * @uses   HUID::__construct
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::getNS
	 */

	public function testValidPrimary ()
	{
		$HUID = new HUID;
		$this->assertEquals(true, $HUID->setNS('5555'));
		$this->assertEquals('5555', $HUID->getNS('primary'));
		$this->assertEquals(false, $HUID->getNS('secondary'));
		$this->assertEquals(false, $HUID->getNS('both'));
	}


	/**
	 * @covers HUID::setNS
	 * @uses   HUID::__construct
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::getNS
	 */

	public function testValidSecondary ()
	{
		$HUID = new HUID;
		$this->assertEquals(true, $HUID->setNS(null, '6666'));
		$this->assertEquals('6666', $HUID->getNS('secondary'));
		$this->assertEquals(false, $HUID->getNS('primary'));
		$this->assertEquals(false, $HUID->getNS('both'));
	}


	/**
	 * @covers HUID::setNS
	 * @uses   HUID::__construct
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::getNS
	 */

	public function testValidPair ()
	{
		$HUID = new HUID;
		$this->assertEquals(true, $HUID->setNS('5555', '6666'));
		$this->assertEquals('5555', $HUID->getNS('primary'));
		$this->assertEquals('6666', $HUID->getNS('secondary'));
		$this->assertEquals('5555-6666', $HUID->getNS('both'));
	}


	/**
	 * @covers HUID::setNS
	 * @uses   HUID::__construct
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::getNS
	 */

	public function testInvalidPrimary ()
	{
		$HUID = new HUID;
		$this->assertEquals(false, $HUID->setNS('555'));
		$this->assertEquals(false, $HUID->getNS('primary'));
		$this->assertEquals(false, $HUID->getNS('secondary'));
		$this->assertEquals(false, $HUID->getNS('both'));
	}


	/**
	 * @covers HUID::setNS
	 * @uses   HUID::__construct
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::getNS
	 */

	public function testInvalidSecondary ()
	{
		$HUID = new HUID;
		$this->assertEquals(false, $HUID->setNS(null, '666'));
		$this->assertEquals(false, $HUID->getNS('primary'));
		$this->assertEquals(false, $HUID->getNS('secondary'));
		$this->assertEquals(false, $HUID->getNS('both'));
	}


	/**
	 * @covers HUID::setNS
	 * @uses   HUID::__construct
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::getNS
	 */

	public function testInvalidPair ()
	{
		$HUID = new HUID;
		$this->assertEquals(false, $HUID->setNS('555', '666'));
		$this->assertEquals(false, $HUID->getNS('primary'));
		$this->assertEquals(false, $HUID->getNS('secondary'));
		$this->assertEquals(false, $HUID->getNS('both'));
	}


	/**
	 * @covers HUID::setNS
	 * @uses   HUID::__construct
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::getNS
	 */

	public function testInvalidPrimaryWithValidSecondary ()
	{
		$HUID = new HUID;
		$this->assertEquals(true, $HUID->setNS('555', '6666'));
		$this->assertEquals(false, $HUID->getNS('primary'));
		$this->assertEquals('6666', $HUID->getNS('secondary'));
		$this->assertEquals(false, $HUID->getNS('both'));
	}


	/**
	 * @covers HUID::setNS
	 * @uses   HUID::__construct
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::getNS
	 */

	public function testInvalidSecondaryWithValidPrimary ()
	{
		$HUID = new HUID;
		$this->assertEquals(true, $HUID->setNS('5555', '666'));
		$this->assertEquals('5555', $HUID->getNS('primary'));
		$this->assertEquals(false, $HUID->getNS('secondary'));
		$this->assertEquals(false, $HUID->getNS('both'));
	}


	/**
	 * @covers HUID::setNS
	 * @uses   HUID::__construct
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::getNS
	 */

	public function testReplacePrimaryOnInvalid ()
	{
		$HUID = new HUID;
		$this->assertEquals(true, $HUID->setNS('5555'));
		$this->assertEquals('5555', $HUID->getNS('primary'));
		$this->assertEquals(false, $HUID->setNS('555'));
		$this->assertEquals(false, $HUID->getNS('primary'));
	}


	/**
	 * @covers HUID::setNS
	 * @uses   HUID::__construct
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::getNS
	 */

	public function testReplaceSecondaryOnInvalid ()
	{
		$HUID = new HUID;
		$this->assertEquals(true, $HUID->setNS(null, '6666'));
		$this->assertEquals('6666', $HUID->getNS('secondary'));
		$this->assertEquals(false, $HUID->setNS(null, '666'));
		$this->assertEquals(false, $HUID->getNS('secondary'));
	}


	/**
	 * @covers HUID::setNS
	 * @uses   HUID::__construct
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::getNS
	 */

	public function testReplacePairOnInvalid ()
	{
		$HUID = new HUID;
		$this->assertEquals(true, $HUID->setNS('5555', '6666'));
		$this->assertEquals('5555', $HUID->getNS('primary'));
		$this->assertEquals('6666', $HUID->getNS('secondary'));
		$this->assertEquals('5555-6666', $HUID->getNS('both'));
		$this->assertEquals(false, $HUID->setNS('555', '666'));
		$this->assertEquals(false, $HUID->getNS('primary'));
		$this->assertEquals(false, $HUID->getNS('secondary'));
		$this->assertEquals(false, $HUID->getNS('both'));
	}


	/**
	 * @covers HUID::setNS
	 * @uses   HUID::__construct
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::getNS
	 */

	public function testReplacePrimaryOnInvalidWithValidSecondary ()
	{
		$HUID = new HUID;
		$this->assertEquals(true, $HUID->setNS('5555', '6666'));
		$this->assertEquals('5555', $HUID->getNS('primary'));
		$this->assertEquals('6666', $HUID->getNS('secondary'));
		$this->assertEquals('5555-6666', $HUID->getNS('both'));
		$this->assertEquals(true, $HUID->setNS('555', '6666'));
		$this->assertEquals(false, $HUID->getNS('primary'));
		$this->assertEquals('6666', $HUID->getNS('secondary'));
		$this->assertEquals(false, $HUID->getNS('both'));
	}


	/**
	 * @covers HUID::setNS
	 * @uses   HUID::__construct
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::getNS
	 */

	public function testReplaceSecondaryOnInvalidWithValidPrimary ()
	{
		$HUID = new HUID;
		$this->assertEquals(true, $HUID->setNS('5555', '6666'));
		$this->assertEquals('5555', $HUID->getNS('primary'));
		$this->assertEquals('6666', $HUID->getNS('secondary'));
		$this->assertEquals('5555-6666', $HUID->getNS('both'));
		$this->assertEquals(true, $HUID->setNS('5555', '666'));
		$this->assertEquals('5555', $HUID->getNS('primary'));
		$this->assertEquals(false, $HUID->getNS('secondary'));
		$this->assertEquals(false, $HUID->getNS('both'));
	}
}
