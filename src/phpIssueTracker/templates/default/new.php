<div class="block backlink"><a href="<?php echo linkTo(null, array('new')); ?>">
	back to issue list
</a></div>

<h2 class="block heading">New issue</h2>

<form method="post">
	<table class="block issue-new-main">
		<tr>
			<th><label for="task">Task name:</label></th>
			<td><input type="text" name="task" id="task" class="issue-new-task" required></td>
		</tr>

		<tr>
			<th><label for="description">Description:</label></th>
			<td>
				<textarea name="description" id="description" class="issue-new-description" required></textarea>
			</td>
		</tr>
	</table>

	<ul class="block tasks-list-labels">
		<?php foreach ($labels as $label) { ?>
			<li style="color: #<?php echo $label->color;?>;" class="list label-<?php echo $label->label; ?>">
				<label>
					<input type="checkbox" name="label[]" value="<?php echo $label->id; ?>">
					<?php echo $label->label; ?>
				</label>
			</li>
		<?php } ?>
	</ul>

	<?php if ($error) { ?>
	<div class="block error">
		<p><?php echo $errorMessage; ?></p>
	</div>
	<?php } ?>

	<div class="block">
		<input type="text" name="protect" value="" class="protect">
		<input type="submit" name="create" value="create">
	</div>
</form>
