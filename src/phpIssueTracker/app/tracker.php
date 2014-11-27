<?php

if (empty($_SERVER['REMOTE_ADDR'])) {
	header(' ', null, 403);
	echo 'Forbidden.';
	exit;
}

if (!defined('CONFIG_FILE')) {
	die ('Please, define "CONFIG_FILE" constant with path to configuration file.');
}
if (!file_exists(CONFIG_FILE)) {
	die ('Configuration file defined in "CONFIG_FILE" constant does not exist.');
}

require CONFIG_FILE;

$pdo = new PDO($dsn, $dbLogin, $dbPassword);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$pdo->query("SET NAMES 'utf8'");


class FormException extends Exception {}

function linkTo(array $add = null, array $strip = array()) {
	$get = $_GET;
	if (is_array($add)) {
		$get = array_merge($get, $add);
	}
	if (!empty($strip)) {
		$get = array_diff_key($get, array_flip($strip));
	}
	return sprintf('?%s', http_build_query($get));
}

function checkMail($mail) {
	return (bool) preg_match('/^[^@]+@[^@.]+\.[^@]+$/i', $mail);
}

// bot protection
function protect() {
	if (!empty($_POST['protect'])) {
		header(' ', null, 403);
		echo 'Forbidden.';
		exit;
	}
}

function sendMail($from, $to, $subject, $body) {
	return mail($to, $subject, $body,
		"MIME-Version: 1.0\nContent-Type: text/plain; charset=utf-8\nContent-Transfer-Encoding: 8bit\nFrom: {$from}");
}

$title = (empty($projectTitle) ? '' : "{$projectTitle} ") . 'PHP Issue Tracker';

session_start();
if (isset($_GET['logout'])) {
	unset($_SESSION['admin']);
}
$administrator = isset($_SESSION['admin']) && $_SESSION['admin'];

if (!empty($_GET['issue'])) {
	$view = 'issue';
	require __DIR__ . '/issue.php';

} elseif (isset($_GET['new'])) {
	$view = 'new';
	require __DIR__ . '/new.php';

} elseif (isset($_GET['admin'])) {
	if ($administrator) {
		$view = 'admin';
	} else {
		$view = 'adminLogin';
	}
	require __DIR__ . '/admin.php';

} else {
	$view = 'list';
	require __DIR__ . '/list.php';
}

require __DIR__ . '/../templates/' . $htmlTemplate .'/layout.php';
