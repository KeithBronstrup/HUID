<?PHP // HUID Reference implementation in PHP

/** 
 * Generate a Host Unique Identifier
 * 
 * @param string $primaryNS    The primary namespace, 4 hexadecimal characterd
 * @param string $secondaryNS  The secondary namespace, 3 hexadecimal characters
 * @param string $format       The desired output format, one of 'str', 'hex', 'bin', or 'obj'. Default 'str'
 *                              - str: Return a 36 character string in the format AAAAAAAAAAAAAA-BBBBBBB-CCCC-DDD-EEEE
 *                              - hex: Return a 32 digit hexadecimal value in the format AAAAAAAAAAAAAABBBBBBBCCCCDDDEEEE
 *                              - bin: Return a 16 byte binary string
 *                              - obj: Return an object containing all 3 formats
 * 
 * @return mixed  Returns a string in the requested format, or false if parameters are incorrect
 * @example /reference/php/example.php
 */

function getHUID ($primaryNS, $secondaryNS, $format = 'str') {
	if (strlen($primaryNS) === 4
	 && strlen($secondaryNS) === 3
	 && ctype_xdigit($primaryNS)
	 && ctype_xdigit($secondaryNS))
    {
		if (in_array($format, ['hex','bin']))
		{
			$delimiter = ''; 
		} else {
			$delimiter = '-'; 
		}
		
		$huid = strtolower(
			str_pad(dechex(time()), 14, '0', STR_PAD_LEFT).
			$delimiter.
			str_pad(dechex(substr(microtime(), 2, 8)), 7, '0', STR_PAD_LEFT).
			$delimiter.
			$primaryNS.
			$delimiter.
			$secondaryNS.
			$delimiter.
			str_pad(dechex(mt_rand(0,0xffff)), 4, '0', STR_PAD_LEFT)
		);

		switch ($format)
		{
			case 'bin':
				return hex2bin($huid);
				break;

			case 'obj':
				$huids = new stdClass;
				$huids->str = $huid;
				$huids->hex = str_replace('-', '', $huid);
				$huids->bin = hex2bin($huids->hex);
				return $huids;
				break;

			default:
				return $huid;
				break;
		}
	}
	
	return false;
}
