<?php
include('..\db_connection.php');
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ..\index.php");
    exit();
}

$sql = "SELECT * FROM Institutions";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $institutionsData = array();
    while ($row = $result->fetch_assoc()) {
        $institutionsData[] = $row;
    }
} else {
    $institutionsData = array();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Institutions Data</title>
    <link rel="stylesheet" href="..\styles.css">
</head>
<body>
    <h1>Institutions Data</h1>

    <?php if (!empty($institutionsData)) : ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Address1</th>
                <th>Address2</th>
            </tr>
            <?php foreach ($institutionsData as $institution) : ?>
                <tr>
                    <td><?= $institution['ID_Institutions']; ?></td>
                    <td><?= $institution['Name']; ?></td>
                    <td><?= $institution['Address1']; ?></td>
                    <td><?= $institution['Address2']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else : ?>
        <p>No data available in Institutions table.</p>
    <?php endif; ?>
</body>
</html>
