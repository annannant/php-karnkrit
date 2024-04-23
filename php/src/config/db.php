<?php

$host = 'db';
$user = 'laboratory';
$password = 'password';
$db = 'laboratory';

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}