<?php

$labels = $pdo->query("SELECT id, label, color FROM {$tablesPrefix}labels")->fetchAll();

$errorMessage = null;

if (isset($_POST['create'])) {

	try {
		protect();

		// max creation limit prevention
		$ip = ip2long($_SERVER['REMOTE_ADDR']);
		$statement = $pdo->prepare("SELECT COUNT(*) FROM {$tablesPrefix}tasks WHERE creator_ipv4 = ?
			AND DATE(created) = DATE(NOW())");
		$statement->execute(array($ip));
		$createdToday = $statement->fetchColumn();
		if ($createdToday >= $maxIssuesCreatedPerDay) {
			header(' ', null, 403);
			echo 'You have created too many issues per today.';
			exit;
		}

		$task = trim($_POST['task']);
		$description = trim($_POST['description']);
		if (empty($task) || empty($description)) {
			throw new FormException('Please, fill task name and description.');
		}

		$pdo->beginTransaction();

		$statement = $pdo->prepare("INSERT INTO {$tablesPrefix}tasks
			SET task = ?, description = ?, creator_ipv4 = ?");
		$statement->execute(array($task, $description, $ip));

		$taskId = $pdo->query('SELECT LAST_INSERT_ID()')->fetchColumn();

		$queryBits = array();
		foreach ((array) @$_POST['label'] as $labelId) {
			$queryBits[] = sprintf('(%d, %d)', $taskId, (int) $labelId);
		}

		// labels
		if (!empty($queryBits)) {
			$queryBits = implode(', ', $queryBits);
			$pdo->query("INSERT INTO {$tablesPrefix}tasks_labels (task_id, label_id) VALUES {$queryBits}");
		}

		// notifications
		$mail = trim($_POST['mail']) ?: null;
		if ($mail) {
			if (!checkMail($mail)) {
				throw new FormException('Invalid e-mail address.');
			}
			$statement = $pdo->prepare("INSERT INTO {$tablesPrefix}tasks_notify (task_id, email, ipv4)
				VALUES (?, ?, ?)");
			$statement->execute(array($taskId, $mail, $ip));
		}

		$pdo->commit();

		if (!empty($notificationsEmail) && checkMail($notificationsEmail)) {
			$body = $task . "\n\n" . $description . "\n\n" . sprintf('http://%s?issue=%d',
				$_SERVER['HTTP_HOST'] . preg_replace('/\?.*$/', '', $_SERVER['REQUEST_URI']), $taskId)
				. "\n";
			sendMail(sprintf('noreply@%s', $_SERVER['HTTP_HOST']), $notificationsEmail,
				sprintf('%sNew issue submitted', $projectTitle ? "{$projectTitle} " : ''), $body);
		}

		header(sprintf('Location: ?issue=%d', $taskId), null, 303);
		exit;

	} catch (FormException $e) {
		$errorMessage = $e->getMessage();
	}
}
