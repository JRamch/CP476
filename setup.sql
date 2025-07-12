-- Create the main database
CREATE DATABASE IF NOT EXISTS InventoryDB;
USE InventoryDB;

-- Drop tables if they already exist (for clean re-runs)
DROP TABLE IF EXISTS inventory;
DROP TABLE IF EXISTS product;
DROP TABLE IF EXISTS supplier;

-- Create the supplier table
CREATE TABLE supplier (
    supSupplierID INT PRIMARY KEY,
    supSupplierName VARCHAR(50) NOT NULL,
    supAddress VARCHAR(100),
    supPhone VARCHAR(20),
    supEmail VARCHAR(100)
);

-- Create the product table
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

-- Create the inventory table (denormalized view-style)
CREATE TABLE inventory (
    invProductID INT PRIMARY KEY,
    invProductName VARCHAR(50),
    invPrice DECIMAL(10,2),
    invStatus CHAR(1),
    invSupplierName VARCHAR(50)
);
