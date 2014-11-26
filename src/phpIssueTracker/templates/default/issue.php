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


<form method="post" class="common-form">
	<table class="block common-form-main">
		<tr>
			<th><label for="mail_add">Notifications about changes on e-mail address:</label></th>
			<td>
				<input type="text" name="mail_add" id="mail_add" class="issue-new-mail" value="<?php
				echo !empty($_POST['mail_add']) ? htmlspecialchars($_POST['mail_add']) : '';?>">
			</td>
			<td class="form-common-extra">
				<p>E-mail address is hidden from public.</p>
			</td>
		</tr>

		<tr>
			<th><label for="mail_dismiss">Dismiss notifications on e-mail address:</label></th>
			<td colspan="2">
				<input type="text" name="mail_dismiss" id="mail_dismiss" class="issue-new-mail" value="<?php
				echo !empty($_POST['mail_dismiss']) ? htmlspecialchars($_POST['mail_dismiss']) : '';?>">
			</td>
		</tr>
	</table>

	<?php if ($errorMessage) { ?>
		<div class="block error">
			<p><?php echo $errorMessage; ?></p>
		</div>
	<?php } ?>

	<div class="block">
		<input type="text" name="protect" value="" class="protect">
		<input type="submit" name="ok" value="ok">
	</div>

	<?php if ($successMessage) { ?>
		<div class="block success">
			<p><?php echo $successMessage; ?></p>
		</div>
	<?php } ?>
</form>
