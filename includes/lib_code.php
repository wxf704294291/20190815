<?php
//WEBSC商城资源
function encrypt($str, $key = AUTH_KEY)
{
	$coded = '';
	$keylength = strlen($key);
	$i = 0;

	for ($count = strlen($str); $i < $count; $i += $keylength) {
		$coded .= substr($str, $i, $keylength) ^ $key;
	}

	return str_replace('=', '', base64_encode($coded));
}

function decrypt($str, $key = AUTH_KEY)
{
	$coded = '';
	$keylength = strlen($key);
	$str = base64_decode($str);
	$i = 0;

	for ($count = strlen($str); $i < $count; $i += $keylength) {
		$coded .= substr($str, $i, $keylength) ^ $key;
	}

	return $coded;
}

if (!defined('IN_ECS')) {
	exit('Hacking attempt');
}

?>
