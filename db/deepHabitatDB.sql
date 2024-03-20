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

INSERT INTO users (username, password) VALUES ('Miguel', 'chimpy');
-- INSERT INTO users (username, password) VALUES ('Guillem', 'gurex');

SELECT * FROM users;
SELECT * FROM jobs;
