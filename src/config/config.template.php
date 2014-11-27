<?php

/**
 * Copy this file as "config.php" and fill your credentials, eventually customize.
 */

$dsn = 'mysql:host=localhost;dbname=issues';
$dbLogin = '';
$dbPassword = '';
$tablesPrefix = '';

$htmlTemplate = 'default';
$tasksLimitPerPage = 20;
$maxIssuesCreatedPerDay = 5;
$maxEmailsSubmission = 3; // per IP for entire time
$predefinedDescription = '';

$projectBackLink = '/';
$projectTitle = '';
$notificationsEmail = ''; // notifies new issues, comments, etc.
$adminPasswordVerifier = function($password) {
	return md5($password) === 'give md5 of your password';
};
$adminLoginMaxAttempts = 3;
