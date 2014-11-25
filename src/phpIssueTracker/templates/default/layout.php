<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>
	<style>
		* { margin: 0; padding: 0; }
		body { margin: 10px 20px; }
		table { border-collapse: collapse; }
		table td, table th { border: 1px solid #000; padding: 2px 3px; }
		table th { text-align: left; }
		h1 a { text-decoration: none; color: #aa778b; }
		.protect { display: none; }
		.error { color: #900; }
		.heading { color: #8929aa; }
		.block { float: left; clear: left; margin-top: 15px; }
		.block-prefix { float: left; width: 60px; font-size: 1.2em; }
		.block-content { float: left; }
		.block-content .selected { border: solid 2px #f00; }
		.labels-list .list { float: left; margin-right: 5px; list-style: none; }
		.labels-list .list a { display: block; color: #fff; text-decoration: none; padding: 3px 10px; }
		.tasks-list-labels .list { float: left; margin-right: 5px; list-style: none; font-weight: bold; }
		.issue-state-new { background: #fa0; }
		.issue-state-waiting { background: #ff0; }
		.issue-state-done { background: #0f0; }
		.issue-state-denied { background: #aaa; }
		.state-list .list { float: left; margin-right: 5px; list-style: none; }
		.state-list .list a { display: block; color: #000; text-decoration: none; padding: 3px 10px; }
		.tasks-list-empty { font-style: italic; color: #900; font-weight: bold; }
		footer { float: left; margin-top: 20px; width: 100%; }
		.footer-copyright { float: right; }
		.paginator .list { list-style: none; float: left; margin-right: 5px; font-weight: bold; }
		.paginator .list .paginator-anchor { display: block; padding: 3px 5px; text-decoration: none;
			background: #000; color: #fff; }
		.paginator li.selected .paginator-anchor {  background: #ccc; color: #000; }
		.issue-new-main th, .issue-new-main td { border: none; }
		.issue-new-main th { vertical-align: top; }
		.issue-new-task, .issue-new-description { width: 400px; border: 1px solid #aaa; }
		.issue-new-description { height: 80px; }
	</style>
</head>
<body>

<header>

	<?php if ($backLink) { ?>
		<div class="block backlink"><a href="<?php echo $backLink; ?>">
			<?php if ($projectTitle) {
				echo sprintf('back to %s', $projectTitle);
			} else { ?>
				back
			<?php } ?>
		</a></div>
	<?php } ?>

	<h1 class="block"><a href="?"><?php echo $title; ?></a></h1>

</header>

<main>

<?php include __DIR__ . '/' . $view . '.php';?>

</main>

<footer>
	<div class="footer-copyright">
		<a href="https://github.com/VladaHejda/phpIssueTracker" target="_blank">PHP Issue Tracker</a>
	</div>
</footer>

</body>
</html>
