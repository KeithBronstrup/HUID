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
		$this->assertEquals(true, $HUID->setNS('aaaa'));
		$this->assertEquals('aaaa', $HUID->getNS('primary'));
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
		$this->assertEquals(true, $HUID->setNS(null, 'bbb'));
		$this->assertEquals(false, $HUID->getNS('primary'));
		$this->assertEquals('bbb', $HUID->getNS('secondary'));
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
		$this->assertEquals(true, $HUID->setNS('aaaa', 'bbb'));
		$this->assertEquals('aaaa', $HUID->getNS('primary'));
		$this->assertEquals('bbb', $HUID->getNS('secondary'));
		$this->assertEquals('aaaa-bbb', $HUID->getNS('both'));
	}
}
