<?php
session_start();
if($_SESSION['login'] == FALSE){
    header("Location:login.php");
}
echo "Welcome, " . $_SESSION['name'] . "!\n";
?>
<html>
<body>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
<br>
Inventory columns: invProductID, invProductName, invQuantity, invPrice, invStatus, invSupplierName<br>
<br>
Insert into database:
<br>
INSERT INTO inventory (invProductID, invProductName, invQuantity, invPrice, invStatus, invSupplierName) VALUES (<input type="text" name="input">) (seperate with commas)<br>
<br>
Search (enter a Column and value):<br>
Column: <input type="text" name="col"><br>
Value: <input type="text" name="value"><br>
<br>

Delete (enter a Column and value):<br>
Column: <input type="text" name="delKey"><br>
Value:<input type="text" name="delete"><br>
<br><br>

Update:<br>
Product ID <input type="text" name="upID"> and Product Supplier <input type="text" name="upSup"> to be updated <br>
Update Fields:<br>
Quantity: <input type="text" name="upQuant"><br>
Price: <input type="text" name="upPrice"><br>
Status: <input type="text" name="upStatus"><br>
<br>
<input type="submit">
</form>

</body>
</html>

<?php
error_reporting(0);
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

$_SESSION['input'] = htmlspecialchars($_POST["input"]);

// INSERTING FOR TESTING PURPOSES
$text = "last Update command: ".$_SESSION['input'] . "\n\n";
//echo nl2br($text);

//take user input and insert it into iventory
if($_SESSION['input'] !== ""){
    $inv = $conn->prepare("INSERT INTO inventory (invProductID, invProductName, invQuantity, invPrice, invStatus, invSupplierName) VALUES (?,?,?,?,?,?)");
    $inv->bind_param("isidss", $id, $proName, $quant, $price, $status, $supName);
    $vars = explode(',', $_SESSION['input']);
    try{
        $id = $vars[0];
        $proName = $vars[1];
        $quant = $vars[2];
        $price = $vars[3];
        $status = $vars[4];
        $supName =$vars[5];
        if($supName === NULL){
            throw new Exception("Check SQL format");
        }
        $inv->execute();
    }catch(Exception $e){
        $text = "\n".$e->getMessage()."\n";
        echo nl2br($text);
    }
}

/*
if($_SESSION['update'] !== ""){
    $inv = $conn->prepare("UPDATE inventory SET ");
}*/

$_SESSION['delete'] = htmlspecialchars($_POST["delete"]);
$_SESSION['delKey'] = htmlspecialchars($_POST["delKey"]);

if(($_SESSION['delete'] != "") && ($_SESSION['delKey'] != "")){
    $inv = $conn->prepare("DELETE FROM inventory WHERE ".$_SESSION['delKey']." LIKE ?");
    try{
        $inv->bind_param("s", $delete);
        $delete = '%'.$_SESSION['delete'];
        $inv->execute();
        //echo "DELETE FROM inventory WHERE ".$_SESSION['delKey']." LIKE %?";
    }catch(Exception $e){
        $text = "\n".$e->getMessage()."\n";
        echo nl2br($text);
    }
}

$_SESSION['upID'] = htmlspecialchars($_POST["upID"]);
$_SESSION['upSup'] = htmlspecialchars($_POST["upSup"]);
$_SESSION['upPrice'] = htmlspecialchars($_POST["upPrice"]);
$_SESSION['upQuant'] = htmlspecialchars($_POST["upQuant"]);
$_SESSION['upStatus'] = htmlspecialchars($_POST["upStatus"]);


if(($_SESSION['upID'] !== "") && ($_SESSION['upSup'] !== "")){
    if($_SESSION['upPrice'] != ""){
        $inv = $conn->prepare("UPDATE inventory SET invPrice=? WHERE ((invProductID LIKE ?) AND (invSupplierName LIKE ?))");
        $inv->bind_param("sss", $price, $proID, $supName);
        $price = $_SESSION['upPrice'];
        $proID = '%'.$_SESSION['upID'];
        $supName = '%'.$_SESSION['upSup'];
        $inv->execute();
    }

    if($_SESSION['upQuant'] != ""){
        $inv = $conn->prepare("UPDATE inventory SET invQuantity=? WHERE ((invProductID LIKE ?) AND (invSupplierName LIKE ?))");
        $inv->bind_param("iss", $quant, $proID, $supName);
        $quant = $_SESSION['upQuant'];
        $proID = '%'.$_SESSION['upID'];
        $supName = '%'.$_SESSION['upSup'];
        $inv->execute();
    }

    if($_SESSION['upStatus'] != ""){
        $inv = $conn->prepare("UPDATE inventory SET invStatus=? WHERE ((invProductID LIKE ?) AND (invSupplierName LIKE ?))");
        $inv->bind_param("sss", $status, $proID, $supName);
        $status = $_SESSION['upStatus'];
        $proID = '%'.$_SESSION['upID'];
        $supName = '%'.$_SESSION['upSup'];
        $inv->execute();
    }

    /*
    $inv = $conn->prepare("UPDATE inventory SET invQuantity=?, invPrice=?, invStatus=? WHERE ((invProductID LIKE ?) AND (invSupplierName LIKE ?))");
    $inv->bind_param("idsis", $quant, $price, $status, $proID, $supName);
    //$vars = explode(',', $_SESSION['input']);
    try{
        $quant = $_SESSION['upQuant'];
        $price = $_SESSION['upPrice'];
        $status = $_SESSION['upStatus'];
        $proID = '%'.$_SESSION['upID'];
        $supName = '%'.$_SESSION['upSup'];
        $inv->execute();
    }catch(Exception $e){
        $text = "\n".$e->getMessage()."\n";
        echo nl2br($text);
    }
        */
}


$_SESSION['col'] = htmlspecialchars($_POST["col"]);
$_SESSION['value'] = htmlspecialchars($_POST["value"]);

if(($_SESSION['col'] != "") && ($_SESSION['value'] != "")){
    $inv = $conn->prepare("SELECT * FROM inventory where ".$_SESSION['col']." LIKE \"%".$_SESSION['value']."\" ORDER BY invProductID");
    $_SESSION['search'] = "SELECT * FROM inventory where ".$_SESSION['col']." LIKE \"%".$_SESSION['value']."\" ORDER BY invProductID";
}else{
    $inv = $conn->prepare("SELECT * FROM inventory ORDER BY invProductID");
    $_SESSION['search'] = "SELECT * FROM inventory ORDER BY invProductID";
}
$inv->execute();

$result = $inv->get_result();

$text = "Inventory Table:\n";
echo nl2br($text);
$text = "Current search: ".$_SESSION['search']."\n\n";
echo nl2br($text);
$text = "|  Product ID  |   Product Name    |   Quantity  |   Price  |  Status  |    Supplier   |\n";
echo nl2br($text);

while ($row = $result->fetch_array(MYSQLI_NUM)) {
    echo "|";
    foreach ($row as $r) {
        echo "  $r  | ";
        
    }
    $text = "\n";
    echo nl2br($text);
}

$conn->close();

?>

<html>
<body>
<form action="login.php" method="post">
<br>
<input type="submit" name = "logout" value="Logout"><br>
<?php if ($_POST['logout']){session_destroy();}?>
</form>
</body>
</html>