<?php

$issueId = (int) $_GET['issue'];

$statement = $pdo->prepare("SELECT task, description, state, updated FROM {$tables_prefix}tasks WHERE id = ?");
$statement->execute(array($issueId));
$issue = $statement->fetch();

$statement = $pdo->prepare("SELECT label, color FROM {$tables_prefix}tasks_labels
	LEFT JOIN {$tables_prefix}labels ON ({$tables_prefix}tasks_labels.label_id = {$tables_prefix}labels.id)
	WHERE task_id = ?");
$statement->execute(array($issueId));
$labels = $statement->fetchAll();
