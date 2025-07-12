<?php
$host = 'localhost';
$dbname = 'InventoryDB';
$user = 'root';
$pass = 'SkibidiGoon'; //whatever ur pword is

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "connected to sql\n";
} catch (PDOexception $e) {
    die("failed connection: " . $e->getMessage());
}
?>