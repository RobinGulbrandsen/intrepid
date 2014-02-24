#############
#	users 	#
#############
#	Users have an auto_increment PK, this is so that players that
#	transfers characters from an other server will be able to keep
#	the accunt, and just has to reauthenticate owenership of their
#	character with the new name.
#
#	guild and guild_rank should never be set. This is fetched from blizz server
# 	but are located in the database to use the wrapping from object to json in
#	eloquent framework
#
#	When a user wants to join, he register - and an application will automaticly be
#	submited to the system. When a player logs in he can see his application if active
#	This way we use the authenticate functionallity and register functionallity at the
# 	same time, and saves the players and ourself for a lot of time.
#

CREATE TABLE users (
	id				int(8) 			PRIMARY KEY AUTO_INCREMENT,
	username 		varchar(50) 	NOT NULl UNIQUE,
	password 		varchar(60) 	NOT NULL,
	email 			varchar(100) 	NOT NULL UNIQUE,
	server			varchar(50) 	NOT NULL,
	guild 			varchar(20),
	guild_rank 		int(2),
	about			varchar(255),
	application_active boolean 		DEFAULT 1,
	created_at		date,
	updated_at		date
);

#############
# 	FORUM	#
#############
CREATE TABLE categories (
	id			int(8)			PRIMARY KEY AUTO_INCREMENT,
	name		varchar(255)	NOT NULL UNIQUE,
	description	varchar(255)	NOT NULL,
	required_guild_rank int(8),
	created_at	date,
	updated_at	date
);

CREATE TABLE topics (
	id			int(8)			PRIMARY KEY AUTO_INCREMENT,
	name		varchar(255)	NOT NULL UNIQUE,
	content		text			NOT NULL,
	sticky		boolean			DEFAULT 0,
	category_id	int(8)			NOT NULL,
	user_id		int(8)			NOT NULL,
	required_guild_rank int(8),
	created_at	date,
	updated_at	date,
	FOREIGN KEY (category_id) REFERENCES categories (id)
		ON DELETE CASCADE,
	FOREIGN KEY (user_id)	REFERENCES users (id)
);

CREATE TABLE posts (
	id 			int(8)		PRIMARY KEY AUTO_INCREMENT,
	content		text		NOT NULL,
	topic_id	int(8)		NOT NULL,
	user_id		int(8) 		NOT NULL,
	required_guild_rank int(8),
	created_at	date,
	updated_at	date,
	FOREIGN KEY (topic_id) REFERENCES topics (id)
		ON DELETE CASCADE,
	FOREIGN KEY (user_id)	REFERENCES users (id)
);

CREATE TABLE articles (
	id 			int(8)			PRIMARY KEY AUTO_INCREMENT,
	title		varchar(255) 	NOT NULL,
	content 	text 			NOT NULL,
	user_id 	int(8)  		NOT NULL,
	created_at 	date,
	updated_at 	date,
	FOREIGN KEY (user_id)	REFERENCES users (id)
);
