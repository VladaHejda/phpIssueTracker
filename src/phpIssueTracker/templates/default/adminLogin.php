<div class="block backlink"><a href="?">
	back to issue list
</a></div>

<h2 class="block heading">Admin</h2>

<?php if ($attemptsCount < 1) { ?>
<div class="block error">
	<p>You have reached max attempts to log in.</p>
</div>
<?php } else { ?>

<form method="post" class="common-form">
	<table class="block common-form-main">
		<tr>
			<th><label for="password">Admin password:</label></th>
			<td>
				<input type="password" name="password" id="password" class="issue-new-password" required>
			</td>
			<td class="form-common-extra">
				<p>Your IP: <?php echo $ip; ?>, remains <?php echo $attemptsCount; ?> attempts.</p>
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
		<input type="submit" name="login" value="login">
	</div>
</form>
<?php } ?>
