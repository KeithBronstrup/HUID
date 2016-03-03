<?php // Copyright (c) 2016 Keith Bronstrup and Contributors

class getNSTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @covers HUID::getNS
	 * @uses   HUID::__construct
	 * @uses   HUID::validateNS
	 * @uses   HUID::getNS
	 */

	public function testEmpty ()
	{
		$HUID = new HUID;
		$this->assertEquals(false, $HUID->getNS('primary'));
		$this->assertEquals(false, $HUID->getNS('secondary'));
		$this->assertEquals(false, $HUID->getNS('both'));
	}


	/**
	 * @covers HUID::getNS
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
	 * @covers HUID::getNS
	 * @uses   HUID::__construct
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::getNS
	 */

	public function testValidSecondary ()
	{
		$HUID = new HUID;
		$this->assertEquals(true, $HUID->setNS(null, '6666'));
		$this->assertEquals(false, $HUID->getNS('primary'));
		$this->assertEquals('6666', $HUID->getNS('secondary'));
		$this->assertEquals(false, $HUID->getNS('both'));
	}


	/**
	 * @covers HUID::getNS
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
}
