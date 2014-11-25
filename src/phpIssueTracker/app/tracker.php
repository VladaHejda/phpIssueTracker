<?php

if (!defined('CONFIG_FILE')) {
	die ('Please, define "CONFIG_FILE" constant with path to configuration file.');
}
if (!file_exists(CONFIG_FILE)) {
	die ('Configuration file defined in "CONFIG_FILE" constant does not exist.');
}

require CONFIG_FILE;

$pdo = new PDO($dsn, $login, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$pdo->query("SET NAMES 'utf8'");

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

$title = (empty($projectTitle) ? '' : "{$projectTitle} ") . 'PHP Issue Tracker';

if (!empty($_GET['issue'])) {
	$view = 'issue';
	require __DIR__ . '/issue.php';

} elseif (isset($_GET['new'])) {
	$view = 'new';
	require __DIR__ . '/new.php';

} else {
	$view = 'list';
	require __DIR__ . '/list.php';
}

require __DIR__ . '/../templates/' . $template .'/layout.php';
