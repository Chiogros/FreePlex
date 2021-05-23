DELETE TABLE Movies;

CREATE TABLE IF NOT EXISTS Movies (
	title varchar(128) NOT NULL,
	year varchar(4),
	classification varchar(64),
	release_date varchar(32),
	runtime int NOT NULL,
	genre varchar(64),
	director varchar(32),
	writers varchar(256),
	actors varchar(256),
	synopsis varchar(512),
	languages varchar(64),
	countries varchar(64),
	awards varchar(64),
	poster_url varchar(256),
	metascore varchar(8),
	imdb_rating varchar(4),
	imdb_votes varchar(4),
	imdb_id varchar(16) PRIMARY KEY,
	type varchar(32)
);
