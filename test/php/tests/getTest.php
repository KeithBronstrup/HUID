<?php // Copyright (c) 2016 Keith Bronstrup and Contributors

class getTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @uses   HUID::generate
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::generate
	 * @uses   HUID::get
	 */

	public function testGetStr ()
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

	public function testGetHex ()
	{
		$HUID = new HUID;
		$this->assertEquals(true, $HUID->setNS('aaaa', 'bbb'));
		$this->assertEquals(true, $HUID->generate());
		$HUIDValue = $HUID->get('hex');
		$this->assertEquals($HUIDValue, strtolower($HUIDValue));
		$this->assertEquals(32, strlen($HUIDValue));
		$this->assertEquals(true, ctype_xdigit($HUIDValue));
	}


	/**
	 * @uses   HUID::generate
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::generate
	 * @uses   HUID::get
	 */

	public function testGetBin ()
	{
		$HUID = new HUID;
		$this->assertEquals(true, $HUID->setNS('aaaa', 'bbb'));
		$this->assertEquals(true, $HUID->generate());
		$HUIDValue = $HUID->get('bin');
		$this->assertEquals(16, strlen($HUIDValue));
		$this->assertEquals(true, ('0x'.bin2hex($HUIDValue) <= 0xffffffffffffffffffffffffffffffff));
	}


	/**
	 * @uses   HUID::generate
	 * @uses   HUID::validateNS
	 * @uses   HUID::setNS
	 * @uses   HUID::generate
	 * @uses   HUID::get
	 */

	public function testGetObj ()
	{
		$HUID = new HUID;
		$this->assertEquals(true, $HUID->setNS('aaaa', 'bbb'));
		$this->assertEquals(true, $HUID->generate());
		$HUIDValue = $HUID->get('obj');
		$this->assertEquals('stdClass', get_class($HUIDValue));
		$this->assertEquals(1, preg_match('/[0-9a-f]{14}-[0-9a-f]{7}-a{4}-b{3}-[0-9a-f]{4}/', $HUIDValue->str));
		$this->assertEquals($HUIDValue->hex, strtolower($HUIDValue->hex));
		$this->assertEquals(32, strlen($HUIDValue->hex));
		$this->assertEquals(true, ctype_xdigit($HUIDValue->hex));
		$this->assertEquals(16, strlen($HUIDValue->bin));
		$this->assertEquals(true, ('0x'.bin2hex($HUIDValue->bin) <= 0xffffffffffffffffffffffffffffffff));
	}
}
