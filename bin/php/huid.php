<?php // Copyright (c) 2016 Keith Bronstrup and Contributors

// HUID Class - PHP Reference Implementation

/**
 * PHP Reference implementation of the Host-Unique Identifier class
 *
 * Version 0.2.0
 */

class HUID
{
	/**
	 * @param string $tail         The time component of the current HUID
	 * @param string $usec         The microsecond component of the current HUID
	 * @param string $primaryNS    The primary namespace component of the current HUID
	 * @param string $secondaryNS  The secondary namespace component of the current HUID
	 * @param string $rand         The random component of the current HUID
	 */

	protected $time = '';
	protected $usec = '';
	protected $primaryNS = '';
	protected $secondaryNS = '';
	protected $rand = '';


	/**
	 * Create a new HUID object, optionally generating a new HUID value with the supplied namespace values
	 *
	 * @param string $primaryNS    The primary namespace to set, 4 hexadecimal characters
	 * @param string $secondaryNS  The secondary namespace to set, 4 hexadecimal characters
	 *
	 * @throws Exception
	 */

	function __construct ($primaryNS = null, $secondaryNS = null) {
		$validNS = $this->validateNS($primaryNS, $secondaryNS);
		if ($validNS === 'both') {
			$this->setNS($primaryNS, $secondaryNS);
			$this->generate();
			return;
		} else if ($validNS === false
		 && $primaryNS !== null
		 && $secondaryNS !== null) {
			throw new Exception('HUID created with invalid Primary and Secondary Namespaces');
		} else if ($validNS === 'secondary'
		 && $primaryNS !== null) {
			throw new Exception('HUID created with invalid Primary Namespace');
		} else if ($validNS === 'primary'
		 && $secondaryNS !== null) {
			throw new Exception('HUID created with invalid Secondary Namespace');
		}
	}


	/**
	 * Generate a Host Unique Identifier
	 *
	 * @return bool  Returns true on success, false on failure
	 */

	public function generate ()
	{
		if ($this->validateNS($this->primaryNS, $this->secondaryNS) !== 'both')
		{
			$this->time = '';
			$this->usec = '';
			$this->rand = '';

			return false;
		} else {
			$this->time = str_pad(dechex(time()), 14, '0', STR_PAD_LEFT);
			$this->usec = str_pad(dechex(substr(microtime(), 2, 5)), 5, '0', STR_PAD_LEFT);
			$this->rand = str_pad(dechex(mt_rand(0,0xfffff)), 5, '0', STR_PAD_LEFT);

			return true;
		}
	}


	/**
	 * Get the current HUID
	 *
	 * @param string $format  The desired output format, one of 'str', 'hex', 'bin', or 'obj'. Default 'str'
	 *                         - str: Return a 36 character string in the format AAAAAAAAAAAAAA-BBBBB-CCCC-DDDD-EEEEE
	 *                         - hex: Return a 32 digit hexadecimal value in the format AAAAAAAAAAAAAABBBBBCCCCDDDDEEEEE
	 *                         - bin: Return a 16 byte binary string
	 *                         - obj: Return an object containing all 3 formats
	 *
	 * @return mixed  Returns the requested format, or false if an invalid format is requested or no HUID has been generated
	 */

	public function get ($format = 'str')
	{
		$hexHUID = $this->time.$this->usec.$this->primaryNS.$this->secondaryNS.$this->rand;

		if (!$this->isHex($hexHUID)) {
			return false;
		}

		switch ($format)
		{
			case 'str':
				return $this->hexToStr($hexHUID);
			case 'hex':
				return $hexHUID;
			case 'bin':
				return $this->hexToBin($hexHUID);
			case 'obj':
				$ret = new stdClass;
				$ret->str = $this->hexToStr($hexHUID);
				$ret->hex = $hexHUID;
				$ret->bin = $this->hexToBin($hexHUID);
				return $ret;
		}

		return false;
	}


	/**
	 * Set the namespace(s) for generated HUIDs
	 *
	 * @param string $primaryNS    The primary namespace to set, 4 hexadecimal characters
	 * @param string $secondaryNS  The secondary namespace to set, 4 hexadecimal characters
	 *
	 * @return bool  Returns true on success, false on failure
	 */

	public function setNS ($primaryNS = null, $secondaryNS = null)
	{
		$validNS = $this->validateNS($primaryNS, $secondaryNS);

		switch ($validNS) {
			case 'primary':
				$this->primaryNS = $primaryNS;

				if ($secondaryNS !== null) {
					$this->secondaryNS = '';
				}
				return true;
			case 'secondary':
				if ($primaryNS !== null) {
					$this->primaryNS = '';
				}

				$this->secondaryNS = $secondaryNS;
				return true;
			case 'both':
				$this->primaryNS = $primaryNS;
				$this->secondaryNS = $secondaryNS;
				return true;
			case false:
				if ($secondaryNS !== null) {
					$this->secondaryNS = '';
				}

				if ($primaryNS !== null) {
					$this->primaryNS = '';
				}
		}

		return false;
	}


	/**
	 * Get the namespace(s) for this HUID
	 *
	 * @param string $which  The desired namespace to fetch, one of 'primary', 'secondary', or 'both'
	 *                        - primary: Return the primary namespace
	 *                        - secondary: Return the secondary namespace
	 *                        - both: Return both namespaces in the format AAAA-BBB
	 *
	 * @return bool  Returns true on success, false on failure
	 */

	public function getNS ($which = 'both')
	{
		switch ($which)
		{
			case 'primary':
				if ($this->primaryNS === '')
				{
					return false;
				} else {
					return $this->primaryNS;
				}
			case 'secondary':
				if ($this->secondaryNS === '')
				{
					return false;
				} else {
					return $this->secondaryNS;
				}
			case 'both':
				if ($this->primaryNS === ''
				 || $this->secondaryNS === '')
				{
					return false;
				} else {
					return $this->primaryNS.'-'.$this->secondaryNS;
				}
		}

		return false;
	}


	/**
	 * Validate one or both namespaces
	 *
	 * @param string $primaryNS    The primary namespace to validate, 4 hexadecimal characters
	 * @param string $secondaryNS  The secondary namespace to validate, 4 hexadecimal characters
	 *
	 * @return mixed  Returns 'primary' if $primaryNS is a valid namespace, 'secondary' if $secondaryNS is a valid namespace, 'both' if both are valid, or false if neither are valid
	 */

	protected function validateNS ($primaryNS = null, $secondaryNS = null)
	{
		if (strlen($primaryNS) === 4
		 && ctype_xdigit($primaryNS))
		{
			if ($this->validateNS(null, $secondaryNS) === 'secondary') {
				return 'both';
			} else {
				return 'primary';
			}
		} else if (strlen($secondaryNS) === 4
		 && ctype_xdigit($secondaryNS))
		{
			return 'secondary';
		} else {
			return false;
		}
	}


	/**
	 * Validate a Host Unique Identifier in string format
	 *
	 * @param string $HUID  The HUID to validate
	 *
	 * @return bool  Returns true if $HUID is a valid string HUID, false otherwise
	 */

	protected function isStr ($HUID) {
		return preg_match('/[0-9a-f]{14}-[0-9a-f]{5}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{5}/', $HUID) ? true : false;
	}


	/**
	 * Validate a Host Unique Identifier in hexadecimal format
	 *
	 * @param string $HUID  The HUID to validate
	 *
	 * @return bool  Returns true if $HUID is a valid hexadecimal HUID, false otherwise
	 */

	protected function isHex ($HUID) {
		if (strtolower($HUID) !== $HUID
		 || strlen($HUID) !== 32
		 || !ctype_xdigit($HUID)) {
			return false;
		}

		return true;
	}


	/**
	 * Validate a Host Unique Identifier in binary format
	 *
	 * @param string $HUID  The HUID to validate
	 *
	 * @return bool  Returns true if $HUID is a valid binary HUID, false otherwise
	 */

	protected function isBin ($HUID) {
		if (strlen($HUID) !== 16
		 || '0x'.bin2hex($HUID) > 0xffffffffffffffffffffffffffffffff) {
			return false;
		}

		return true;
	}


	/**
	 * Convert a Host Unique Identifier from string format to hexadecimal format
	 *
	 * @param string $HUID  The HUID to convert
	 *
	 * @return mixed  Returns the HUID in hexadecimal format if $HUID is a valid string HUID, false otherwise
	 */

	public function strToHex ($HUID) {
		if (!$this->isStr($HUID))
		{
			return false;
		}

		return str_replace('-', '', $HUID);
	}


	/**
	 * Convert a Host Unique Identifier from string format to binary format
	 *
	 * @param string $HUID  The HUID to convert
	 *
	 * @return mixed  Returns the HUID in binary format if $HUID is a valid string HUID, false otherwise
	 */

	public function strToBin ($HUID) {
		if (!$this->isStr($HUID))
		{
			return false;
		}

		return hex2bin(str_replace('-', '', $HUID));
	}


	/**
	 * Convert a Host Unique Identifier from hexadecimal format to string format
	 *
	 * @param string $HUID  The HUID to convert
	 *
	 * @return mixed  Returns the HUID in string format if $HUID is a valid hexadecimal HUID, false otherwise
	 */

	public function hexToStr ($HUID) {
		if (!$this->isHex($HUID))
		{
			return false;
		}

		$a = substr($HUID,  0, 14);
		$b = substr($HUID, 14,  5);
		$c = substr($HUID, 19,  4);
		$d = substr($HUID, 23,  4);
		$e = substr($HUID, 27,  5);

		return $a.'-'.$b.'-'.$c.'-'.$d.'-'.$e;
	}


	/**
	 * Convert a Host Unique Identifier from hexadecimal format to binary format
	 *
	 * @param string $HUID  The HUID to convert
	 *
	 * @return mixed  Returns the HUID in binary format if $HUID is a valid hexadecimal HUID, false otherwise
	 */

	public function hexToBin ($HUID) {
		if (!$this->isHex($HUID))
		{
			return false;
		}

		return hex2bin($HUID);
	}


	/**
	 * Convert a Host Unique Identifier from binary format to string format
	 *
	 * @param string $HUID  The HUID to convert
	 *
	 * @return mixed  Returns the HUID in string format if $HUID is a valid binary HUID, false otherwise
	 */

	public function binToStr ($HUID) {
		if (!$this->isBin($HUID))
		{
			return false;
		}

		return $this->hexToStr(bin2hex($HUID));
	}


	/**
	 * Convert a Host Unique Identifier from binary format to hexadecimal format
	 *
	 * @param string $HUID  The HUID to convert
	 *
	 * @return mixed  Returns the HUID in hexadecimal format if $HUID is a valid binary HUID, false otherwise
	 */

	public function binToHex ($HUID) {
		if (!$this->isBin($HUID))
		{
			return false;
		}

		return bin2hex($HUID);
	}


	/**
	 * Validate a Host Unique Identifier
	 *
	 * @param string $HUID          The HUID to validate, as a string in any valid HUID format (e.g. string, hex, binary, or object)
	 * @param string $primaryNS     The primary namespace to validate against, 4 hexadecimal characters
	 * @param string $secondaryNS   The secondary namespace to validate against, 4 hexadecimal characters
	 *
	 * @return mixed  Returns a string containing the format ('str', 'hex', or 'bin') of $HUID if $HUID contains a valid HUID value and matches the optionally-provided namespace(s); returns false if the HUID is invalid or does not match the provided namespaces
	 */

	public function validateHUID ($HUID, $primaryNS = null, $secondaryNS = null)
	{
		switch ($this->validateNS($primaryNS, $secondaryNS))
		{
			case 'primary':
				if ($secondaryNS !== null) {
					return false;
				}
				break;
			case 'secondary':
				if ($primaryNS !== null) {
					return false;
				}
				break;
			case false:
				if ($primaryNS !== null
				 || $secondaryNS !== null) {
					return false;
				}
				break;
		}

		if ($this->isStr($HUID)) {
			$format = 'str';
			$hexHUID = $this->strToHex($HUID);
			$c = substr($hexHUID, 19, 4);
			$d = substr($hexHUID, 23, 4);

		} else if ($this->isHex($HUID)) {
			$format = 'hex';
			$c = substr($HUID, 19, 4);
			$d = substr($HUID, 23, 4);
		} else if ($this->isBin($HUID)) {
			$format = 'bin';
			$hexHUID = $this->binToHex($HUID);
			$c = substr($hexHUID, 19, 4);
			$d = substr($hexHUID, 23, 4);
		} else {
			return false;
		}

		if (($primaryNS !== null
		  && $primaryNS !== $c)
		 || ($secondaryNS !== null
		  && $secondaryNS !== $d))
		{
			return false;
		}

		return $format;
	}


	/**
	 * Test protected methods
	 *
	 * @param string $method  The name of the protected method to test
	 *
	 * @return mixed  Returns true if self-tests pass, false on failure, or a message if an invalid $method value is passed
	 */

	public function testProtected ($method) {
		switch ($method) {
			case 'validateNS':
				if ($this->validateNS('5555')         === 'primary'
				 && $this->validateNS('5555',   null) === 'primary'
				 && $this->validateNS('5555',  '666') === 'primary'
				 && $this->validateNS(  null, '6666') === 'secondary'
				 && $this->validateNS( '555', '6666') === 'secondary'
				 && $this->validateNS('5555', '6666') === 'both'
				 && $this->validateNS( '555',   null) === false
				 && $this->validateNS(  null,  '666') === false
				 && $this->validateNS(  null,   null) === false
				 && $this->validateNS( '555',  '666') === false
				 && $this->validateNS()               === false)
				{
					return true;
				}
				break;
			case 'isStr':
				if ($this->isStr('33333333333333-44444-5555-6666-77777') === true
				 && $this->isStr('33333333333333444445555666677777') === false
				 && $this->isStr('3333333DDEUVfgww') === false)
				{
					return true;
				}
				break;
			case 'isHex':
				if ($this->isHex('33333333333333444445555666677777') === true
				 && $this->isHex('33333333333333-44444-5555-6666-77777') === false
				 && $this->isHex('3333333DDEUVfgww') === false)
				{
					return true;
				}
				break;
			case 'isBin':
				if ($this->isBin('3333333DDEUVfgww') === true
				 && $this->isBin('33333333333333-44444-5555-6666-77777') === false
				 && $this->isBin('33333333333333444445555666677777') === false)
				{
					return true;
				}
				break;
			default:
				return 'No test exists for method "'.$method.'". If this method exists and is protected, please write some tests!';
		}

		return false;
	}
}
