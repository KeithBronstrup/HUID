<?php // Copyright (c) 2016 Keith Bronstrup and Contributors

class generateTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @uses   HUID::generate
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::generate
	 * @uses   HUID::get
	 */

	public function testSuccess ()
	{
		$HUID = new HUID;
		$this->assertEquals(true, $HUID->setNS('5555', '6666'));
		$this->assertEquals(true, $HUID->generate());
		$this->assertEquals(1, preg_match('/[0-9a-f]{14}-[0-9a-f]{5}-5{4}-6{4}-[0-9a-f]{5}/', $HUID->get('str')));
	}


	/**
	 * @uses   HUID::generate
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::generate
	 * @uses   HUID::get
	 */

	public function testInvalidNSFailAfterSuccess ()
	{
		$HUID = new HUID;
		$this->assertEquals(true, $HUID->setNS('5555', '6666'));
		$this->assertEquals(true, $HUID->generate());
		$this->assertEquals(false, $HUID->setNS('555', '666'));
		$this->assertEquals(false, $HUID->generate());
		$this->assertEquals(false, $HUID->get('str'));
	}


	/**
	 * @uses   HUID::generate
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::generate
	 * @uses   HUID::get
	 */

	public function testInvalidPrimaryFail ()
	{
		$HUID = new HUID;
		$this->assertEquals(true, $HUID->setNS('555', '6666'));
		$this->assertEquals(false, $HUID->generate());
		$this->assertEquals(false, $HUID->get('str'));
	}


	/**
	 * @uses   HUID::generate
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::generate
	 * @uses   HUID::get
	 */

	public function testInvalidSecondaryFail ()
	{
		$HUID = new HUID;
		$this->assertEquals(true, $HUID->setNS('5555', '666'));
		$this->assertEquals(false, $HUID->generate());
		$this->assertEquals(false, $HUID->get('str'));
	}


	/**
	 * @uses   HUID::generate
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::generate
	 * @uses   HUID::get
	 */

	public function testInvalidPairFail ()
	{
		$HUID = new HUID;
		$this->assertEquals(false, $HUID->setNS('555', '666'));
		$this->assertEquals(false, $HUID->generate());
		$this->assertEquals(false, $HUID->get('str'));
	}
}