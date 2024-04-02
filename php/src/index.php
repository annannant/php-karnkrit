<?php
$host = 'db';
$user = 'MYSQL_USER';
$pass = 'MYSQL_PASSWORD';
$db = 'MYSQL_DATABASE';
 
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected to MySQL server successfully!";
}
 
$sql = 'SELECT * FROM USERS';
 
if ($result = $conn->query($sql)) {
    while ($data = $result->fetch_object()) {
        $users[] = $data;
    }
}
 
echo "<ul>";
foreach ($users as $user) {
    echo "<li>";
    echo $user->first_name . " " . $user->last_name . " " . $user->gender;
    echo "</li>";
}
echo "</ul>";