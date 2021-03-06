-- SQL CODE FOR BLOG DATABASE

CREATE DATABASE blog;

-- CREATE USERS TABLE

CREATE TABLE users (
  user_id INT(8) NOT NULL AUTO_INCREMENT,
  user_name VARCHAR(50) NOT NULL,
  user_username VARCHAR(25) NOT NULL,
  user_email VARCHAR(128) NOT NULL,
  user_password VARCHAR(255) NOT NULL,
  user_joined DATETIME NOT NULL,
  UNIQUE INDEX user_username_unique (user_username),
  PRIMARY KEY (user_id)
) ENGINE=INNODB;

-- CREATE POSTS TABLE

CREATE TABLE posts (
  post_id INT(8) NOT NULL AUTO_INCREMENT,
  post_title VARCHAR(255) NOT NULL,
  post_image VARCHAR(255),
  post_content TEXT NOT NULL,
  post_date DATETIME NOT NULL,
  post_by INT(8) NOT NULL,
  PRIMARY KEY (post_id)
) ENGINE=INNODB;

-- CREATE COMMENTS TABLE

CREATE TABLE comments (
  comment_id INT(8) NOT NULL AUTO_INCREMENT,
  comment_text TEXT NOT NULL,
  comment_date DATETIME NOT NULL,
  comment_post INT(8) NOT NULL,
  comment_by INT(8) NOT NULL,
  PRIMARY KEY (comment_id)
) ENGINE=INNODB;

-- LINK USERS AND POSTS TABLE

ALTER TABLE
  posts
ADD FOREIGN KEY
  (post_by)
REFERENCES
  users(user_id)
ON DELETE RESTRICT ON UPDATE CASCADE;

-- LINK COMMENTS AND USERS TABLE

ALTER TABLE
  comments
ADD FOREIGN KEY
  (comment_by)
REFERENCES
  users(user_id)
ON DELETE RESTRICT ON UPDATE CASCADE;

-- LINK COMMENTS AND POSTS TABLE

ALTER TABLE
  comments
ADD FOREIGN KEY
  (comment_post)
REFERENCES
  posts(post_id)
ON DELETE CASCADE ON UPDATE CASCADE;