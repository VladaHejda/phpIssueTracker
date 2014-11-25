<div class="block tasks-manage">
	<a href="?new">new issue</a>
</div>


<h2 class="block heading">Issue list</h2>

<div class="block">
	<h2 class="block-prefix">Label:</h2>
	<ul class="block-content labels-list">
	<?php foreach ($labels as $label) { ?>
		<li class="list<?php echo isSelected('label', $label->label) ? ' selected' : ''; ?>" style="background: #<?php echo $label->color; ?>;">
			<a href="<?php echo renderListQuery('label', $label->label); ?>">
				<span><?php echo $label->label; ?></span>
			</a>
		</li>
	<?php } ?>
	</ul>
</div>

<div class="block">
	<h2 class="block-prefix">State:</h2>
	<ul class="block-content state-list">
		<?php foreach (array('new', 'waiting', 'done', 'denied') as $state) { ?>
			<li class="list issue-state-<?php echo $state . (isSelected('state', $state) ? ' selected' : ''); ?>">
				<a href="<?php echo renderListQuery('state', $state); ?>">
					<span><?php echo $state; ?></span>
				</a>
			</li>
		<?php } ?>
	</ul>
</div>


<?php if (empty($tasks)) { ?>
<div class="block tasks-list-empty">
	<p>no issues...</p>
</div>

<?php } else { ?>
<table class="block tasks-list">
	<thead>
		<tr>
			<td>No.</td>
			<td>Last updated</td>
			<td>State</td>
			<td>Issue</td>
			<td>Labels</td>
		</tr>
	</thead>
	<tbody>
	<?php $n = 0; foreach ($tasks as $n => $task) { ++$n; ?>
		<tr>
			<td><?php echo $n; ?>.</td>
			<td><?php echo $task->updated->format('d.m.Y H:i'); ?></td>
			<td class="issue-state-<?php echo $task->state; ?>"><?php echo $task->state; ?></td>
			<td><a href="<?php echo linkTo(array('issue' => $task->id)); ?>"><?php echo htmlspecialchars($task->task); ?></a></td>
			<td class="tasks-list-labels">
				<ul>
				<?php foreach ($task->labels as $label) { ?>
					<li style="color: #<?php echo $label->color;?>;" class="list label-<?php echo $label->label; ?>">
						<span><?php echo $label->label; ?></span>
					</li>
				<?php } ?>
				</ul>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>

<?php if ($pagesCount > 1) { ?>
	<ul class="block paginator">
	<?php for ($n = 1; $n <= $pagesCount; $n++) { ?>
		<?php if ($page !== $n) { ?>
			<li class="list"><a href="<?php echo linkTo(array('page' => $n)); ?>" class="paginator-anchor">
					<span><?php echo $n; ?></span>
			</a></li>
		<?php } else { ?>
			<li class="list selected"><strong class="paginator-anchor"><span><?php echo $n; ?></span></strong></li>
		<?php } ?>
	<?php } ?>
	</ul>
<?php } ?>

<?php } ?>
