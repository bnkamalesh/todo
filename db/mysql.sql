DROP TABLE IF EXISTS todo_login;
$
DROP TABLE IF EXISTS todo_event;
$
CREATE TABLE todo_login (
	id INT(10) NOT NULL AUTO_INCREMENT,
	user_name varchar(30) NOT NULL,
	password varchar(40) NOT NULL DEFAULT '',
	email varchar(100) NOT NULL DEFAULT '',
	PRIMARY KEY (id)
);
$
CREATE TABLE todo_event (
	id INT(10) NOT NULL AUTO_INCREMENT,
	user_id INT(10) NOT NULL DEFAULT '1',
	title varchar(50) NOT NULL DEFAULT '',
	description varchar(200) NOT NULL DEFAULT '',
	status enum('done', 'pending') NOT NULL DEFAULT 'pending',
	PRIMARY KEY (id)
);