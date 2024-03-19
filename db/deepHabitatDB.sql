CREATE DATABASE IF NOT EXISTS deepHabitatDB;

USE deepHabitatDB;

-- DROP TABLE IF EXISTS users;
-- DROP TABLE IF EXISTS jobs;

CREATE TABLE IF NOT EXISTS users(
	id			BINARY(16) PRIMARY KEY DEFAULT (UUID_TO_BIN(UUID())),
    username 	VARCHAR(255) UNIQUE KEY,
    password 	VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS jobs(
	id 			INT PRIMARY KEY auto_increment,
    name		VARCHAR(255) DEFAULT 'Job',
    petition_id INT
);

INSERT INTO users (username, password) VALUES ('Miguel', 'chimpy');
INSERT INTO users (username, password) VALUES ('Guillem', 'gurex');

-- INSERT INTO jobs (name, petition_id) VALUES ('Garpe4', 27);
-- INSERT INTO jobs (name, petition_id) VALUES ('Pero tio que increible', 17);

SELECT * FROM users;
SELECT * FROM jobs;
