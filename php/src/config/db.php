<?php

$host = 'db';
$user = 'laboratory';
$pass = 'password';
$db = 'laboratory';
 
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
