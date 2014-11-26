<div class="block backlink"><a href="<?php echo linkTo(null, array('new')); ?>">
	back to issue list
</a></div>

<h2 class="block heading">New issue</h2>

<form method="post" class="common-form">
	<table class="block common-form-main">
		<tr>
			<th><label for="task">Task name:</label></th>
			<td colspan="2">
				<input type="text" name="task" id="task" class="issue-new-task" required value="<?php
				echo !empty($_POST['task']) ? htmlspecialchars($_POST['task']) : '';?>">
			</td>
		</tr>

		<tr>
			<th><label for="description">Description:</label></th>
			<td colspan="2">
				<textarea name="description" id="description" class="issue-new-description" required><?php
					echo !empty($_POST['description']) ? htmlspecialchars($_POST['description'])
						: htmlspecialchars($predefinedDescription) ; ?></textarea>
			</td>
		</tr>

		<tr>
			<th><label for="mail">E-mail address (optional):</label></th>
			<td>
				<input type="text" name="mail" id="mail" class="issue-new-mail" value="<?php
				echo !empty($_POST['mail']) ? htmlspecialchars($_POST['mail']) : '';?>">
			</td>
			<td class="form-common-extra">
				<p>When given, issue tracker will notify you by e-mail when issue is updated.</p>
				<p>E-mail address is hidden from public.</p>
				<p>You can dismiss notifications anytime in future.</p>
			</td>
		</tr>
	</table>

	<ul class="block tasks-list-labels">
		<?php foreach ($labels as $label) { ?>
			<li style="color: #<?php echo $label->color;?>;" class="list label-<?php echo $label->label; ?>">
				<label>
					<input type="checkbox" name="label[]" value="<?php echo $label->id; ?>"<?php
						echo (!empty($_POST['label']) && in_array($label->id, $_POST['label'])) ? ' checked' : ''; ?>>
					<?php echo $label->label; ?>
				</label>
			</li>
		<?php } ?>
	</ul>

	<?php if ($errorMessage) { ?>
	<div class="block error">
		<p><?php echo $errorMessage; ?></p>
	</div>
	<?php } ?>

	<div class="block">
		<input type="text" name="protect" value="" class="protect">
		<input type="submit" name="create" value="create">
	</div>
</form>
