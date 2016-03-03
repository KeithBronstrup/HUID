<?php // Copyright (c) 2016 Keith Bronstrup and Contributors

// HUID usage examples in PHP

require_once('huid.php');

$primaryNS   = '1b3d';
$secondaryNS = '5f7';
?>
<pre>HUID String Example
	<?PHP
	echo getHUID($primaryNS, $secondaryNS);

	/* OUTPUT:
	33333333333333-44444-5555-6666-77777
	*/?>

	HUID Hexadecimal Example
	<?PHP
	echo getHUID($primaryNS, $secondaryNS, 'hex');

	/* OUTPUT:
	33333333333333444445555666677777
	*/?>

	HUID Binary Example
	<?PHP
	echo getHUID($primaryNS, $secondaryNS, 'bin');

	/* OUTPUT:
	3333333DDEUVfgww
	*/?>

	HUID Object Example
	<?PHP
	print_r(getHUID($primaryNS, $secondaryNS, 'obj'));

	/* OUTPUT:
	stdClass Object
	(
		[str] => 33333333333333-44444-5555-6666-77777
		[hex] => 33333333333333444445555666677777
		[bin] => 3333333DDEUVfgww
	)
	*/?>
</pre>
