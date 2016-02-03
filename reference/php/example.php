<?PHP // HUID usage examples in PHP
require_once('huid.php');

$primaryHost   = '1b3d';
$secondaryHost = '5f7';
?>
<pre>HUID String Example
<?PHP
echo getHUID($primaryHost, $secondaryHost);

/* OUTPUT:
1b3d-5f7-7bd0-00000056b17aec-0eb742c
*/
?>

HUID Hexadecimal Example
<?PHP
echo getHUID($primaryHost, $secondaryHost, 'hex');

/* OUTPUT:
1b3d5f77bd000000056b17aec0eb742c
*/
?>

HUID Binary Example
<?PHP
echo getHUID($primaryHost, $secondaryHost, 'bin');

/* OUTPUT:
=_w�k���t,
*/
?>

HUID Object Example
<?PHP
print_r(getHUID($primaryHost, $secondaryHost, 'obj'));

/* OUTPUT:
stdClass Object
(
    [str] => 1b3d-5f7-7bd0-00000056b17aec-0eb742c
    [hex] => 1b3d5f77bd000000056b17aec0eb742c
    [bin] => =_w�k���t,
)
*/

?></pre>
