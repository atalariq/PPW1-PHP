-- DDL: run once to create the database and tables
-- To reset: DROP DATABASE ppw1; then re-run this file, then seed.sql

CREATE DATABASE IF NOT EXISTS ppw1
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE ppw1;

CREATE TABLE IF NOT EXISTS prodi (
  id   INT PRIMARY KEY AUTO_INCREMENT,
  nama VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS mahasiswa (
  id         INT PRIMARY KEY AUTO_INCREMENT,
  nama       VARCHAR(100)   NOT NULL,
  nim        VARCHAR(20)    NOT NULL UNIQUE,
  prodi_id   INT            NOT NULL,
  ipk        DECIMAL(3,2)   NOT NULL,
  semester   TINYINT        NOT NULL,
  created_at TIMESTAMP      DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (prodi_id) REFERENCES prodi(id)
);
