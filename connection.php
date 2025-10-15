<?php
$conn = mysqli_connect("localhost", "root", "", "shoping_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
