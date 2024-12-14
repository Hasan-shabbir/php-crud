<?php
session_start();
include('connection.php');
if(isset($_SESSION['admin'])){
  header("location: read.php");
  die();
}
else{
    header("location: login.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tgyhj</title>
</head>
<body>
    
</body>
</html>