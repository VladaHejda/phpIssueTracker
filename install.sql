CREATE TABLE tasks (
	id INT(1) UNSIGNED NOT NULL AUTO_INCREMENT,
	task VARCHAR(63) NOT NULL,
	description TEXT NOT NULL,
	state ENUM('new', 'waiting', 'done', 'denied') NOT NULL DEFAULT 'new',
	updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	creator_ipv4 INT(1) SIGNED NOT NULL,
	PRIMARY KEY (id),
	INDEX (task),
	INDEX (updated)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE labels (
	id INT(1) UNSIGNED NOT NULL AUTO_INCREMENT,
	label VARCHAR(63) NOT NULL,
	color CHAR(6) NOT NULL DEFAULT '000000',
	PRIMARY KEY (id),
	UNIQUE (label)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE tasks_labels (
	task_id INT(1) UNSIGNED NOT NULL,
	label_id INT(1) UNSIGNED NOT NULL,
	PRIMARY KEY (task_id, label_id),
	FOREIGN KEY (task_id) REFERENCES tasks (id) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (label_id) REFERENCES labels (id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE tasks_notify (
	notify_id INT(1) UNSIGNED NOT NULL AUTO_INCREMENT,
	task_id INT(1) UNSIGNED NOT NULL,
	email VARCHAR(100) NOT NULL,
	ipv4 INT(1) SIGNED NOT NULL,
	PRIMARY KEY (notify_id),
	UNIQUE (task_id, email),
	FOREIGN KEY (task_id) REFERENCES tasks (id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO labels (label, color) VALUES
	('bug', '900000'),
	('feature', '009000'),
	('not necessary', '009090');
