<div class="block backlink"><a href="?">
		back to issue list
	</a></div>

<h2 class="block heading">Admin</h2>

<form method="post" class="common-form">
	<div class="block">
		<h2 class="block-prefix">Labels:</h2>
		<ul class="block-content labels-list">
			<?php foreach ($labels as $label) { ?>
				<li class="list" style="background: #<?php echo $label->color; ?>;">
					<span class="anchor"><?php echo $label->label; ?></span>
				</li>
				<li class="list">
					<input type="submit" name="labelDelete[<?php echo $label->id; ?>]" value="×">
				</li>
			<?php } ?>
		</ul>
	</div>

	<table class="block common-form-main">
		<tr>
			<th><label for="label">Add label:</label></th>
			<td colspan="2">
				<input type="text" name="label" id="label" class="issue-new-label" value="<?php
				echo !empty($_POST['label']) ? htmlspecialchars($_POST['label']) : '';?>">
			</td>
		</tr>

		<tr>
			<th><label for="color">Color (%):</label></th>
			<td colspan="2">
				<label style="color: #900;">Red: <input type="text" name="red" id="red" class="issue-new-color" size="2" value="<?php
				echo !empty($_POST['red']) ? htmlspecialchars($_POST['red']) : '50';?>"></label>
				<label style="color: #090;">Green: <input type="text" name="green" id="green" class="issue-new-color" size="2" value="<?php
				echo !empty($_POST['green']) ? htmlspecialchars($_POST['green']) : '50';?>"></label>
				<label style="color: #009;">Blue: <input type="text" name="blue" id="blue" class="issue-new-color" size="2" value="<?php
				echo !empty($_POST['blue']) ? htmlspecialchars($_POST['blue']) : '50';?>"></label>
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
		<input type="submit" name="labelAdd" value="add">
	</div>
</form>
