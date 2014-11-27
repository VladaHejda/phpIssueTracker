<?php

protect();
$ip = $_SERVER['REMOTE_ADDR'];
$errorMessage = '';
$ipLong = ip2long($ip);

$statement = $pdo->prepare("SELECT COUNT(*) FROM {$tablesPrefix}admin_logins WHERE ipv4 = ?");
$statement->execute(array($ipLong));
$attemptsCount = $adminLoginMaxAttempts - $statement->fetchColumn();

if ($administrator) {
	try {
		if (!empty($_POST['labelDelete'])) {
			$labelId = (int) key($_POST['labelDelete']);
			try {
				$statement = $pdo->prepare("DELETE FROM {$tablesPrefix}labels WHERE id = ?");
				$statement->execute(array($labelId));
			} catch (PDOException $e) {
				if ((int) $e->getCode() === 23000) {
					throw new FormException('Label is in use and cannot be deleted.');
				}
			}

		} elseif (!empty($_POST['labelAdd'])) {
			$label = trim($_POST['label']);
			if (!preg_match('/^[a-z0-9 _-]+$/i', $label)) {
				throw new FormException('Label must contain only alphanumeric characters.');
			}

			$color = '';
			foreach (array('red', 'green', 'blue') as $channel) {
				$percent = trim($_POST[$channel]);
				if (!ctype_digit($percent)) {
					throw new FormException(sprintf('Color channel %s is invalid.', $channel));
				}
				$percent = (int) $percent;
				if ($percent < 0 || $percent > 100) {
					throw new FormException(sprintf('Color channel %s is out of range.', $channel));
				}
				$byte = round(255 * ($percent / 100));
				$hex = dechex($byte);
				if (strlen($hex) == 1) {
					$hex = "0{$hex}";
				}
				$color .= $hex;
			}
			echo $color;

			try {
				$statement = $pdo->prepare("INSERT INTO {$tablesPrefix}labels (label, color) VALUES (?, ?)");
				$statement->execute(array($label, $color));
			} catch (PDOException $e) {
				if ((int) $e->getCode() === 23000) {
					throw new FormException('Label already exists.');
				}
			}
		}
	} catch (FormException $e) {
		$errorMessage = $e->getMessage();
	}

	$labels = $pdo->query("SELECT id, label, color FROM {$tablesPrefix}labels")->fetchAll();


// login
} elseif ($attemptsCount > 0 && isset($_POST['login'])) {

	if (!$adminPasswordVerifier($_POST['password'])) {
		$errorMessage = 'Wrong password.';
		--$attemptsCount;
		$statement = $pdo->prepare("INSERT INTO {$tablesPrefix}admin_logins (ipv4) VALUES (?)");
		$statement->execute(array($ipLong));

	} else {
		$statement = $pdo->prepare("DELETE FROM {$tablesPrefix}admin_logins WHERE ipv4 = ?");
		$statement->execute(array($ipLong));
		$_SESSION['admin'] = true;
		header('Location: ?admin', null, 303);
		exit;
	}
}
