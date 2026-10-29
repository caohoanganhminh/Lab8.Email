
CREATE DATABASE IF NOT EXISTS qlkhachhang CHARACTER SET utf8mb4;
USE qlkhachhang;
CREATE TABLE IF NOT EXISTS khachhang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hoten VARCHAR(100),
    email VARCHAR(150) NOT NULL
);
INSERT INTO khachhang (hoten, email) VALUES
('Khách 1', 'test1@test.com'),
('Khách 2', 'test2@test.com'),
('Khách 3', 'test3@test.com');