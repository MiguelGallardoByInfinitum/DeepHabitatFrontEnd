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

INSERT INTO users (username, password) VALUES ('jordi', 'j0rdi.2024');
-- INSERT INTO users (username, password) VALUES ('Guillem', 'gurex');

SELECT * FROM users;
SELECT * FROM jobs;

DELIMITER //

CREATE FUNCTION hash_password(input_password VARCHAR(255)) 
RETURNS VARCHAR(255)
DETERMINISTIC
BEGIN
    DECLARE hashed_password VARCHAR(255);
    SET hashed_password = PASSWORD(input_password);
    RETURN hashed_password;
END;
//
DELIMITER ;


CREATE TRIGGER before_insert_users BEFORE INSERT ON users
FOR EACH ROW
SET NEW.password = hash_password(NEW.password);
