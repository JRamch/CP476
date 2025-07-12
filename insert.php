
<?php

//THIS FILE DOES NOT NEED TO BE CALLED FOR OUR PROJECT! 
//IT'S ONLY FOR POPULATING YOUR MYSQL DATABASE!

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

    $insert = $conn->prepare("INSERT INTO product (proProductID, proProductName, proDescription, proPrice, proQuantity, proStatus, proSupplierID) VALUES (?,?,?,?,?,?,?)");
    $insert->bind_param("issdisi", $proID, $proName, $desc, $price, $quant, $status, $supID);

    while (($data = fgetcsv($file, 1000, ',','"',"")) != FALSE){
        //echo $test[$i];
        $proID = $data[0];
        $proName = $data[1];
        $desc = $data[2];
        $price = $data[3];
        $quant = $data[4];
        $status = $data[5];
        $supID = $data[6];
        /*
        echo $ID; 
        echo $proName; 
        echo $desc; 
        echo $price; 
        echo $quant; 
        echo $status; 
        echo $supID;
        */
        $insert->execute();
    }
    fclose($file);
} catch(Exception $e){
    echo $e;
    exit("\nerror opening Product.txt");
}

try{
    $file = fopen("Supplier.txt", 'r');
    //$test = fgetcsv($file, 1000, ',','"',"");

    $insertSup = $conn->prepare("INSERT INTO supplier (supSupplierID, supSupplierName, supAddress, supPhone, supEmail) VALUES (?,?,?,?,?)");
    $insertSup->bind_param("issss", $supSupID, $supName, $address, $phone, $email);

    while (($data = fgetcsv($file, 1000, ',','"',"")) != FALSE){
        //echo $test[$i];
        $supSupID = $data[0];
        $supName = $data[1];
        $address = $data[2];
        $phone = $data[3];
        $email = $data[4];
        /*
        echo $ID; 
        echo $proName; 
        echo $desc; 
        echo $price; 
        echo $quant; 
        echo $status; 
        echo $supID;
        */
        $insertSup->execute();
    }
    fclose($file);
} catch(Exception $e){
    echo $e;
    exit("\nerror opening Supplier.txt");
}

$inv = $conn->prepare("INSERT INTO inventory select proProductID, proProductName, proQuantity, proPrice, proStatus, S.supSupplierName FROM product INNER JOIN supplier S ON proSupplierID = supSupplierID");
$inv->execute();

$conn->close();
echo "\nsuccess!";
?>