--creating the main database
CREATE DATABASE IF NOT EXISTS InventoryDB;
USE InventoryDB;

-- drop tables for clean re-runs
DROP TABLE IF EXISTS inventory;
DROP TABLE IF EXISTS product;
DROP TABLE IF EXISTS supplier;
--self explaining
CREATE TABLE supplier (
    supSupplierID INT PRIMARY KEY,
    supSupplierName VARCHAR(50) NOT NULL,
    supAddress VARCHAR(100),
    supPhone VARCHAR(20),
    supEmail VARCHAR(100)
);

CREATE TABLE product (
    proProductID INT PRIMARY KEY,
    proProductName VARCHAR(50),
    proDescription VARCHAR(50),
    proPrice DECIMAL(10,2),
    proQuantity INT,
    proStatus CHAR(1),
    proSupplierID INT,
    FOREIGN KEY (proSupplierID) REFERENCES supplier(supSupplierID)
);

CREATE TABLE inventory (
    invProductID INT PRIMARY KEY,
    invProductName VARCHAR(50),
    invPrice DECIMAL(10,2),
    invStatus CHAR(1),
    invSupplierName VARCHAR(50)
);
