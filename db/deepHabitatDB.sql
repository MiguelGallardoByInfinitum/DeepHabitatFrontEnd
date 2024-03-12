CREATE DATABASE IF NOT EXISTS deepHabitatDB;

USE deepHabitatDB;

DROP TABLE IF EXISTS users;

CREATE TABLE IF NOT EXISTS users(
	id	BINARY(16) PRIMARY KEY DEFAULT (UUID_TO_BIN(UUID())),
    username VARCHAR(255) UNIQUE KEY,
    password VARCHAR(255)
);

INSERT INTO users (username, password) VALUES ('Miguel', 'Chimpy');

SELECT * FROM users;