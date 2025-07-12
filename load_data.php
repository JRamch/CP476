<?php
require 'db.php';

// Load suppliers
$supplierF = fopen("Supplier.txt", "r");
if ($supplierF) {
    while (($line = fgets($supplierF)) !== false) {
        $data = explode(",", trim($line));
        if (count($data) >= 5) {
            $stmt = $pdo->prepare("INSERT IGNORE INTO supplier (supSupplierID, supSupplierName, supAddress, supPhone, supEmail)
                                   VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$data[0], $data[1], $data[2], $data[3], $data[4]]); //load id, name, address, phone, email, in that order

        }
    }
    fclose($supplierF);
    echo "Suppliers loaded.<br>";
} else {
    echo "Could not open Supplier.txt<br>";
}
//load product file
$productF = fopen("Product.txt", "r");
if ($productF) {
    while (($line = fgets($productF)) !== false) {
        $data = explode(",", trim($line));
        if (count($data) >= 6) {
            $stmt = $pdo->prepare(
                "INSERT IGNORE INTO product (proProductID, proProductName, proDescription, proPrice, proQuantity, proStatus, proSupplierID)
                 VALUES (?, ?, ?, ?, ?, ?, ?)"
            );
            $stmt->execute([$data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6]]); //load product id, name, desc, price, quantity, status, supplier id in that order
        }
    }
    fclose($productF);
    echo "Products loaded.<br>";
} else {
    echo "Could not open Product.txt<br>";
}
?>