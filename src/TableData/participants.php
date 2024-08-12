<?php
include('..\db_connection.php');
include('..\db_operations.php');

session_start();


if (!isset($_SESSION['username'])) {
    header("Location: ..\index.php");
    exit();
}

$sql = "SELECT * FROM Participants";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $participantsData = array();
    while ($row = $result->fetch_assoc()) {
        $participantsData[] = $row;
    }
} else {
    $participantsData = array();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participants Data</title>
    <link rel="stylesheet" href="..\styles.css">
</head>
<body>
    <h1>Participants Data</h1>

    <?php if (!empty($participantsData)) : ?>
        <table>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Position ID</th>
                <th>Action</th>
            </tr>
            <?php foreach ($participantsData as $participant) : ?>
                <tr>
                    <td><?= $participant['ID_Participants']; ?></td>
                    <td><?= $participant['First_name']; ?></td>
                    <td><?= $participant['Last_name']; ?></td>
                    <td><?= $participant['ID_Positions']; ?></td>
                    <td>
                        <button class="remove-button" onclick="removeParticipant(<?= $participant['ID_Participants']; ?>)">Remove</button>
                        <button class="change-position-button" onclick="changePosition(<?= $participant['ID_Participants']; ?>)">Change Position</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else : ?>
        <p>No data available in Participants table.</p>
    <?php endif; ?>
</body>
</html>
