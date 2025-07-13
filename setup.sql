-- Create the main database
CREATE DATABASE IF NOT EXISTS InventoryDB;
USE InventoryDB;

-- Drop tables if they already exist (for clean re-runs)
DROP TABLE IF EXISTS inventory;
DROP TABLE IF EXISTS product;
DROP TABLE IF EXISTS supplier;

-- Create the supplier table
CREATE TABLE supplier (
    supSupplierID INT NOT NULL,
    supSupplierName VARCHAR(50),
    supAddress VARCHAR(100),
    supPhone VARCHAR(20),
    supEmail VARCHAR(100)
);

-- Create the product table
CREATE TABLE product (
    proProductID INT NOT NULL,
    proProductName VARCHAR(50),
    proDescription VARCHAR(50),
    proPrice DECIMAL(10,2),
    proQuantity INT,
    proStatus VARCHAR(10),
    proSupplierID INT
);

-- Create the inventory table (denormalized view-style)
CREATE TABLE inventory (
    invProductID INT NOT NULL,
    invProductName VARCHAR(50),
    invPrice DECIMAL(10,2),
    invStatus VARCHAR(10),
    invSupplierName VARCHAR(50)
);
