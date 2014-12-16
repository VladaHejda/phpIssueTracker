<?php

$issueId = (int) $_GET['issue'];

$statement = $pdo->prepare("SELECT task, description, state, updated FROM {$tablesPrefix}tasks WHERE id = ?");
$statement->execute(array($issueId));
$issue = $statement->fetch();

$statement = $pdo->prepare("SELECT label, color FROM {$tablesPrefix}tasks_labels
	LEFT JOIN {$tablesPrefix}labels ON ({$tablesPrefix}tasks_labels.label_id = {$tablesPrefix}labels.id)
	WHERE task_id = ?");
$statement->execute(array($issueId));
$labels = $statement->fetchAll();


$errorMessage = $successMessage = null;

if (isset($_POST['ok'])) {

	try {
		protect();

		$mailAdd = trim($_POST['mail_add']) ?: null;
		$mailDismiss = trim($_POST['mail_dismiss']) ?: null;
		$ip = ip2long($_SERVER['REMOTE_ADDR']);

		if ($mailAdd && $mailDismiss) {
			throw new FormException('You cannot add and dismiss e-mail addresses at once.');
		}

		if ($mailDismiss) {
			if (!checkMail($mailDismiss)) {
				throw new FormException('Invalid e-mail address.');
			}
			$statement = $pdo->prepare("DELETE FROM {$tablesPrefix}tasks_notify WHERE task_id = ? AND email = ?");
			$statement->execute(array($issueId, $mailDismiss));
			$deleted = (bool) $pdo->query('SELECT ROW_COUNT()')->fetchColumn();
			if (!$deleted) {
				throw new FormException('No such e-mail address in database.');
			}
			$successMessage = 'E-mail address dismissed.';

		} elseif ($mailAdd) {
			if (!checkMail($mailAdd)) {
				throw new FormException('Invalid e-mail address.');
			}
			$statement = $pdo->prepare("SELECT 1 FROM {$tablesPrefix}tasks_notify WHERE ipv4 = ? AND email = ?");
			$statement->execute(array($ip, $mailAdd));
			$alreadySubmitted = $statement->fetchColumn();
			if (!$alreadySubmitted) {
				$statement = $pdo->prepare("SELECT COUNT(DISTINCT email) FROM {$tablesPrefix}tasks_notify WHERE ipv4 = ?");
				$statement->execute(array($ip));
				$distinctEmails = $statement->fetchColumn();
				if ($distinctEmails >= $maxEmailsSubmission) {
					header(' ', null, 403);
					echo 'You have submitted too many different e-mail addresses from your IP.';
					exit;
				}
			}

			$statement = $pdo->prepare("INSERT IGNORE INTO {$tablesPrefix}tasks_notify (task_id, email, ipv4)
				VALUES (?, ?, ?)");
			$statement->execute(array($issueId, $mailAdd, $ip));
			$successMessage = 'E-mail address successfully added.';

		} else {
			throw new FormException('Fill some e-mail address.');
		}

	} catch (FormException $e) {
		$errorMessage = $e->getMessage();
	}
}
