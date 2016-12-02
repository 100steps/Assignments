<?php
function rand($num = 15, $dic = null)
{
	if (is_null($dic)) $dic = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890';
	$result = '';
	for ($i=0; $i < $num; $i++) { 
		$result .= $dic[mt_rand() % strlen($dic)];
	}
	return $result;
}

$n = empty($_GET['n']) ? 15 : (int) $_GET['n'];
$n = $n == 0 ? 15 : $n;
echo rand($n, empty($_GET['dic']) ? null : $_GET['dic']);
