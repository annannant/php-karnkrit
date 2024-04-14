

<?php

include ('config/db.php');

$sql = 'SELECT users.*, section.section_name FROM `users` INNER JOIN section ON users.section_id = section.section_id;';
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($data = $result->fetch_object()) {
        $users[] = $data;
    }
}
?>
<div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Section</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) { ?>
                <tr>
                    <td><?php echo $user->user_id; ?></td>
                    <td><?php echo $user->user_name; ?></td>
                    <td><?php echo $user->section_name; ?></td>
                </tr>
            <?php } ?>
          </tbody>
    </table>
</div>

