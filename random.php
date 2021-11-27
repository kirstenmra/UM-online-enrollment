<?php
$n=15;
function getpassword($n) {
	$password = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$randomString = '';

	for ($i = 0; $i < $n; $i++) {
		$index = rand(0, strlen($password) - 1);
		$randomString .= $password[$index];
	}

	return $randomString;
}

echo getpassword($n);
?>
