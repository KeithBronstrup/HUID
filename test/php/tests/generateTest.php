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
		$this->assertEquals(true, $HUID->setNS('aaaa', 'bbb'));
		$this->assertEquals(true, $HUID->generate());
		$this->assertEquals(1, preg_match('/[0-9a-f]{14}-[0-9a-f]{7}-a{4}-b{3}-[0-9a-f]{4}/', $HUID->get('str')));
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
		$this->assertEquals(true, $HUID->setNS('aaaa', 'bbb'));
		$this->assertEquals(true, $HUID->generate());
		$this->assertEquals(false, $HUID->setNS('aaa', 'bb'));
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
		$this->assertEquals(true, $HUID->setNS('aaa', 'bbb'));
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
		$this->assertEquals(true, $HUID->setNS('aaaa', 'bb'));
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
		$this->assertEquals(false, $HUID->setNS('aaa', 'bb'));
		$this->assertEquals(false, $HUID->generate());
		$this->assertEquals(false, $HUID->get('str'));
	}
}