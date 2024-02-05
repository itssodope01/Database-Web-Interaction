<?php
include('db_connection.php');

if (isset($_GET['id'])) {
    $participantId = $_GET['id'];
    $sql = "SELECT * FROM Participants WHERE ID_Participants = $participantId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $participant = $result->fetch_assoc();
    } else {
        echo "Participant not found.";
        exit;
    }

    //Fetching positions for dropdown
    $positionsSql = "SELECT * FROM Positions";
    $positionsResult = $conn->query($positionsSql);

    if ($positionsResult->num_rows > 0) {
        $positions = $positionsResult->fetch_all(MYSQLI_ASSOC);
    } else {
        echo "No positions found.";
        exit;
    }

    //Handling form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $newPositionId = $_POST['new_position'];
        $updateSql = "UPDATE Participants SET ID_Positions = $newPositionId WHERE ID_Participants = $participantId";
        if ($conn->query($updateSql) === TRUE) {
            echo "Position updated successfully!";
        } else {
            echo "Error updating position: " . $conn->error;
        }
    }
    $conn->close();
} else {
    echo "Participant ID not provided.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Position</title>
 
</head>
<body>
    <h1>Change Position</h1>

    <?php if (isset($participant)) : ?>
        <p>Participant: <?= $participant['First_name'] . ' ' . $participant['Last_name']; ?></p>

        <form method="post">
            <label for="new_position">Select New Position:</label>
            <select name="new_position" id="new_position">
                <?php foreach ($positions as $position) : ?>
                    <option value="<?= $position['ID_Positions']; ?>"><?= $position['Position']; ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Change Position</button>
        </form>
    <?php endif; ?>
</body>
</html>
