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
    $test = fgetcsv($file, 1000, ',','"',"");
    for ($i = 0; $i < count($test); $i++){
        echo $test[$i];
    }
    fclose($file);
} catch(Exception $e){
    exit("error opening Product.txt");
}

$conn->close();
echo "\nsuccess!";
?>