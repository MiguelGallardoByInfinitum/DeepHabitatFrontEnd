CREATE DATABASE IF NOT EXISTS deepHabitatDB;

USE deepHabitatDB;

DROP TABLE IF EXISTS users;

CREATE TABLE IF NOT EXISTS users(
	id			BINARY(16) PRIMARY KEY DEFAULT (UUID_TO_BIN(UUID())),
    username 	VARCHAR(255) UNIQUE KEY,
    password 	VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS jobs(
	id 		INT PRIMARY KEY auto_increment,
    name	VARCHAR(255) DEFAULT 'Job',
    url 	TEXT
);

INSERT INTO users (username, password) VALUES ('Miguel', 'chimpy');
INSERT INTO users (username, password) VALUES ('Guillem', 'gurex');

INSERT INTO jobs (name, url) VALUES ('Job', 'http://127.0.0.1:8000/historic');

SELECT * FROM users;
SELECT * FROM jobs;