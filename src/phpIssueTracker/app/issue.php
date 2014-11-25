<?php

$issueId = (int) $_GET['issue'];

$statement = $pdo->prepare('SELECT task, description, state, updated FROM tasks WHERE id = ?');
$statement->execute(array($issueId));
$issue = $statement->fetch();

$statement = $pdo->prepare('SELECT label, color FROM tasks_labels
	LEFT JOIN labels ON (tasks_labels.label_id = labels.id) WHERE task_id = ?');
$statement->execute(array($issueId));
$labels = $statement->fetchAll();
