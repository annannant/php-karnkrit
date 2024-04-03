<?php

include ('config/db.php');


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

?>

<!-- <button type="button" onclick="location.href='users-create.php'">Create User</button> -->
<button type="button" onclick="location.href='users-create.php'" class="btn btn-primary">Create User</button>
