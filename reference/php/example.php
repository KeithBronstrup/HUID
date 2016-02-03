<?PHP // HUID usage examples in PHP
require_once('huid.php');

$primaryNS   = '1b3d';
$secondaryNS = '5f7';
?>
<pre>HUID String Example
<?PHP
echo getHUID($primaryNS, $secondaryNS);

/* OUTPUT:
00000056b24b88-229a6c4-1b3d-5f7-581e
*/
?>

HUID Hexadecimal Example
<?PHP
echo getHUID($primaryNS, $secondaryNS, 'hex');

/* OUTPUT:
00000056b24b88229a6c41b3d5f7581e
*/
?>

HUID Binary Example
<?PHP
echo getHUID($primaryNS, $secondaryNS, 'bin');

/* OUTPUT:
V�K�"�lA���X
*/
?>

HUID Object Example
<?PHP
print_r(getHUID($primaryNS, $secondaryNS, 'obj'));

/* OUTPUT:
stdClass Object
(
    [str] => 00000056b24b88-229a6c4-1b3d-5f7-581e
    [hex] => 00000056b24b88229a6c41b3d5f7581e
    [bin] => V�K�"�lA���X
)
*/

?></pre>
