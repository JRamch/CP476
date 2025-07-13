<?php
//session_start();
//$_SESSION['login'] = FALSE;
$valid_name = "test";
$valid_email = "test";

$nameErr = "";
$name ="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  }
}
?>

<html>
<body>


<form action="welcome.php" method="post">
Name: <input type="text" name="name">
<span class="error">* <?php echo $nameErr;?></span>
<br><br>
Password: <input type="text" name="pass"><br>
<input type="submit">
</form>
</body>
</html>
