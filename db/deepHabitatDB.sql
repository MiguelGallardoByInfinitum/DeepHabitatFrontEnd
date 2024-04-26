CREATE DATABASE IF NOT EXISTS deepHabitatDB;

USE deepHabitatDB;

-- DROP TABLE IF EXISTS users;
-- DROP TABLE IF EXISTS jobs;

CREATE TABLE IF NOT EXISTS users(
	id			INT PRIMARY KEY AUTO_INCREMENT,
    username 	VARCHAR(255) UNIQUE KEY,
    password 	VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS jobs(
	id 			INT PRIMARY KEY auto_increment,
    name		VARCHAR(255) DEFAULT 'Job',
    petition_id INT
);

CREATE TABLE IF NOT EXISTS moodboards(
	id 				INT PRIMARY KEY auto_increment,
    title 			VARCHAR(255) DEFAULT 'Moodboard',
    moodboard_id 	INT
);

INSERT INTO users (username, password) VALUES ('admin', '$2y$10$l80NkVh0SkZgXTAK9sn2nOwbE0w2Uw5g55PwPd1JjLzwTxrnzwAA.');
-- INSERT INTO users (username, password) VALUES ('Guillem', 'gurex');

SELECT * FROM users;
SELECT * FROM jobs;
