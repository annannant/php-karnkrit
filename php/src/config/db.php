<?php

$host = 'db';
$user = 'laboratory';
$password = 'password';
$db = 'laboratory';

date_default_timezone_set("Asia/Bangkok");

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
