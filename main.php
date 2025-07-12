<?php
session_start();
echo "Welcome, " . $_SESSION['name'] . "!\n";
?>
<html>
<body>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
Inventory columns: invProductID, invProductName, invQuantity, invPrice, invStatus, invSupplierName<br>
Search (enter a Column and value)<br>
Column: <input type="text" name="col"><br>
Value: <input type="text" name="value"><br>
<br>
Insert into Database: INSERT INTO inventory (invProductID, invProductName, invQuantity, invPrice, invStatus, invSupplierName) VALUES (<input type="text" name="input">)<br>
Delete from Database: <input type="text" name="delete"><br>
<br><br>
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
$text = "last Update command: ".$_SESSION['input'] . "\n\n";
echo nl2br($text);

//take user input and insert it into iventory
if($_SESSION['input'] !== ""){
    $inv = $conn->prepare("INSERT INTO inventory (invProductID, invProductName, invQuantity, invPrice, invStatus, invSupplierName) VALUES (?,?,?,?,?,?)");
    $inv->bind_param("isidss", $id, $proName, $quant, $price, $status, $supName);
    $vars = explode(',', $_SESSION['input']);
    try{
        $id = $vars[0];
        /*
        if(!is_int($id)){
            throw new Exception("ID is not Integer");
        }
            */
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

$_SESSION['delete'] = htmlspecialchars($_POST["delete"]);

if($_SESSION['delete'] !== ""){
    $inv = $conn->prepare("DELETE FROM inventory WHERE invProductID = ".$_SESSION['delete']);
    try{
        $inv->execute();
    }catch(Exception $e){
        $text = "\n".$e->getMessage()."\n";
        echo nl2br($text);
    }
}




$_SESSION['col'] = htmlspecialchars($_POST["col"]);
$_SESSION['value'] = htmlspecialchars($_POST["value"]);

if(($_SESSION['col'] != "") && ($_SESSION['value'] != "")){
    $inv = $conn->prepare("SELECT * FROM inventory where ".$_SESSION['col']." LIKE \"%".$_SESSION['value']."\"");
    $_SESSION['search'] = "SELECT * FROM inventory where ".$_SESSION['col']." LIKE \"%".$_SESSION['value']."\"";
}else{
    $inv = $conn->prepare("SELECT * FROM inventory");
    $_SESSION['search'] = "SELECT * FROM inventory";
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