<?php

function renderListQuery($name, $value) {
	$get = $_GET;
	unset($get['page']);
	if (empty($get[$name]) || !is_array($get[$name])) {
		$get[$name] = array();
	}
	if (in_array($value, $get[$name])) {
		unset($get[$name][array_search($value, $get[$name])]);
		$get[$name] = array_values($get[$name]);
	} else {
		$get[$name][] = $value;
	}
	return sprintf('?%s', http_build_query($get));
}

function isSelected($name, $value) {
	if (isset($_GET[$name])) {
		if (in_array($value, $_GET[$name])) {
			return true;
		}
	}
	return false;
}

// FILTERS:
$conditions = $args = array();

// LABELS filter
$selectedLabels = empty($_GET['label']) ? array() : (array) $_GET['label'];
if (!empty($selectedLabels)) {
	array_walk($selectedLabels, function(& $label) use ($pdo) {
		$label = $pdo->quote($label);
	});
	$conditions[] = sprintf('label IN (%s)', implode(', ', $selectedLabels));
}

// STATE filter
$selectedStates = empty($_GET['state']) ? array() : (array) $_GET['state'];
if (!empty($selectedStates)) {
	array_walk($selectedStates, function(& $label) use ($pdo) {
		$label = $pdo->quote($label);
	});
	$conditions[] = sprintf('state IN (%s)', implode(', ', $selectedStates));
}

$conditions = implode(' AND ', $conditions);
if (!empty($conditions)) {
	$conditions = sprintf('WHERE %s', $conditions);
}

$labels = $pdo->query("SELECT label, color FROM {$tablesPrefix}labels")->fetchAll();

$query = "SELECT %s FROM {$tablesPrefix}tasks
	LEFT JOIN {$tablesPrefix}tasks_labels ON ({$tablesPrefix}tasks.id = {$tablesPrefix}tasks_labels.task_id)
	LEFT JOIN {$tablesPrefix}labels ON ({$tablesPrefix}tasks_labels.label_id = {$tablesPrefix}labels.id)
	{$conditions} %s";

$statement = $pdo->prepare(sprintf($query, "COUNT(DISTINCT {$tablesPrefix}tasks.id)", ''));
$statement->execute($args);
$count = $statement->fetchColumn();

$page = $pagesCount = 1;
if ($count) {
	$offset = 0;
	if ($count > $tasksLimitPerPage) {
		$page = !empty($_GET['page']) ? (int) $_GET['page'] : 1;
		$offset = ($page -1) * $tasksLimitPerPage;
		$pagesCount = ceil($count / $tasksLimitPerPage);
	}

	$statement = $pdo->prepare(sprintf($query, "{$tablesPrefix}tasks.id, task, state, updated",
		sprintf("GROUP BY {$tablesPrefix}tasks.id ORDER BY updated DESC LIMIT %d OFFSET %d", $tasksLimitPerPage, $offset)));
	$statement->execute($args);
	$tasks = $statement->fetchAll();
	foreach ($tasks as & $task) {
		$statement = $pdo->prepare("SELECT label, color FROM {$tablesPrefix}tasks_labels
			LEFT JOIN {$tablesPrefix}labels ON ({$tablesPrefix}tasks_labels.label_id = {$tablesPrefix}labels.id)
			WHERE task_id = ?");
		$statement->execute(array($task->id));
		$task->labels = $statement->fetchAll();
		$task->updated = new DateTime($task->updated);
	}
	unset($task);
} else {
	$tasks = array();
}
