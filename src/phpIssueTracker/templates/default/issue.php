<div class="block backlink"><a href="<?php echo linkTo(null, array('issue')); ?>">
	back to issue list
</a></div>

<h2 class="block heading">Issue "<?php echo $issue->task; ?>"</h2>

<table class="block issue-detail">
	<tr>
		<th>Issue:</th>
		<td><?php echo htmlspecialchars($issue->task); ?></td>
	</tr>
	<tr>
		<th>State:</th>
		<td class="issue-state-<?php echo $issue->state;?>"><?php echo $issue->state; ?></td>
	</tr>
	<tr>
		<th>Labels:</th>
		<td class="tasks-list-labels">
			<ul>
				<?php foreach ($labels as $label) { ?>
					<li style="color: #<?php echo $label->color;?>;" class="list label-<?php echo $label->label; ?>">
						<span><?php echo $label->label; ?></span>
					</li>
				<?php } ?>
			</ul>
		</td>
	</tr>
	<tr>
		<th>Description:</th>
		<td class="issue-description"><pre><?php echo htmlspecialchars($issue->description); ?></pre></td>
	</tr>
</table>
