<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    //change 'root' and 'Admin' to your mysql username / password
    $conn = new mysqli("localhost", "root", "Admin", "cp476"); 
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $conn->set_charset("utf8mb4");
} catch(Exception $e) {
    error_log($e->getMessage());
    exit('Error connecting to database');
}

try{
    $file = fopen("Product.txt", 'r');
    //$test = fgetcsv($file, 1000, ',','"',"");

    $insert = $conn->prepare("INSERT IGNORE INTO product (proProductID, proProductName, proDescription, proPrice, proQuantity, proStatus, proSupplierID) VALUES (?,?,?,?,?,?,?)");
    $insert->bind_param("isidss", $ID, $proName, $quantity, $price, $status, $supName);

    while (($data = fgetcsv($file, 1000, ',','"',"")) !== FALSE){
        //echo $test[$i];
        $ID = $data[0];
        $proName = $data[1];
        $quantity = $data[2];
        $price = $data[3];
        $status = $data[4];
        $supName = $data[5];
        echo $ID; $proName; $quantity; $price; $status; $supName;
    }
    fclose($file);
} catch(Exception $e){
    echo $e;
    exit("\nerror opening Product.txt");
}

$conn->close();
echo "\nsuccess!";
?>