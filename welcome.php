
<?php
session_start();
// Define the correct credentials
$valid_name = "test";
$valid_email = "test";

$nameErr = "";
$name ="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
  }
}

// Get the form input data
$name = test_input($_POST['name']);
$email = test_input($_POST['pass']);

// Check if the submitted credentials match the valid ones
if ($name !== $valid_name || $email !== $valid_email) {
    
    header("Location:login.php");
    //echo "Invalid login credentials. Please try again.";
    exit;
}
$_SESSION['name'] = $name;
$_SESSION['input'] = "";
$_SESSION['delete'] = "";
$_SESSION['col'] = "";
$_SESSION['value'] = "";
$_SESSION['search'] = "SELECT * FROM inventory";
$_SESSION['login'] = TRUE;
$_SESSION['delKey'] = "";
$_SESSION['upQuant'] = "";
$_SESSION['upPrice'] = "";
$_SESSION['upStatus'] = "";
$_SESSION['upID'] = "";
$_SESSION['upSup'] = "";
header("Location:main.php");
exit;
//echo "Welcome, " . htmlspecialchars($name) . "!";

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);

  return $data;
}

?>