<?PHP // HUID Reference implementation in PHP

/** 
 * Generate a Host Unique Identifier
 * 
 * @param string $primaryID    The primary host ID, 4 hexadecimal characterd
 * @param string $secondaryID  The secondary host ID, 3 hexadecimal characters
 * @param string $format       The desired output format, one of 'str', 'hex', 'bin', or 'obj'. Default 'str'
 *                              - str: Return a 36 character string in the format AAAA-BBB-CCCC-DDDDDDDDDDDDDD-EEEEEEE
 *                              - hex: Return a 32 digit hexadecimal value in the format AAAABBBCCCCDDDDDDDDDDDDDDEEEEEEE
 *                              - bin: Return a 16 byte binary string
 *                              - obj: Return an object containing all 3 formats
 * 
 * @return mixed  Returns a string in the requested format, or false if parameters are incorrect
 * @example /reference/php/example.php
 */

function getHUID ($primaryID, $secondaryID, $format = 'str') {
	if (strlen($primaryID) === 4
	 && strlen($secondaryID) === 3
	 && ctype_xdigit($primaryID)
	 && ctype_xdigit($secondaryID))
    {
		if (in_array($format, ['hex','bin']))
		{
			$delimiter = ''; 
		} else {
			$delimiter = '-'; 
		}
		
		$huid = strtolower(
			$primaryID.
			$delimiter.
			$secondaryID.
			$delimiter.
			str_pad(dechex(mt_rand(0,0xffff)), 4, '0', STR_PAD_LEFT).
			$delimiter.
			str_pad(dechex(time()), 14, '0', STR_PAD_LEFT).
			$delimiter.
			str_pad(dechex(substr(microtime(), 2, 8)), 7, '0', STR_PAD_LEFT)
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
