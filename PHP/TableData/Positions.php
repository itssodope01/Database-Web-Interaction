<?php
include('..\db_connection.php');

session_start();


if (!isset($_SESSION['username'])) {
    header("Location: ..\index.php");
    exit();
}

$sql = "SELECT * FROM Positions";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $positionsData = array();
    while ($row = $result->fetch_assoc()) {
        $positionsData[] = $row;
    }
} else {
    $positionsData = array();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Positions Data</title>
    <link rel="stylesheet" href="..\styles.css">
</head>
<body>
    <h1>Positions Data</h1>
    <?php if (!empty($positionsData)) : ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Position</th>
            </tr>
            <?php foreach ($positionsData as $position) : ?>
                <tr>
                    <td><?= $position['ID_Positions']; ?></td>
                    <td><?= $position['Position']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else : ?>
        <p>No data available in Positions table.</p>
    <?php endif; ?>
</body>
</html>
