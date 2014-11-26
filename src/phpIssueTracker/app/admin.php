<?php

protect();
$ip = $_SERVER['REMOTE_ADDR'];
$errorMessage = '';
$ipLong = ip2long($ip);

$statement = $pdo->prepare("SELECT COUNT(*) FROM {$tables_prefix}admin_logins WHERE ipv4 = ?");
$statement->execute(array($ipLong));
$attemptsCount = $adminLoginMaxAttempts - $statement->fetchColumn();

if ($administrator) {


} elseif ($attemptsCount > 0 && isset($_POST['login'])) {

	if (!$adminPasswordVerifier($_POST['password'])) {
		$errorMessage = 'Wrong password.';
		--$attemptsCount;
		$statement = $pdo->prepare("INSERT INTO {$tables_prefix}admin_logins (ipv4) VALUES (?)");
		$statement->execute(array($ipLong));

	} else {
		$statement = $pdo->prepare("DELETE FROM {$tables_prefix}admin_logins WHERE ipv4 = ?");
		$statement->execute(array($ipLong));
		$_SESSION['admin'] = true;
		header('Location: ?admin', null, 303);
		exit;
	}
}
