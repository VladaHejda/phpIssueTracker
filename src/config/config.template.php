<?php

/**
 * Copy this file as "config.php" and fill your credentials, eventually customize.
 */

$dsn = 'mysql:host=localhost;dbname=issues';
$login = '';
$password = '';
$tables_prefix = '';

$tasksLimit = 20;
$maxCreatePerDay = 5;
$maxEmailsSubmission = 3;
$template = 'default';
$predefinedDescription = '';

$backLink = '/';
$projectTitle = '';
$notificationsEmail = '';
$adminPasswordVerifier = function($password) {
	return md5($password) === 'give md5 of your password';
};
$adminLoginMaxAttempts = 3;
