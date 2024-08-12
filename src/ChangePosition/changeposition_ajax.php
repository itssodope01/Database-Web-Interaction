<?php
include('..\db_connection.php');
session_start();


if (!isset($_SESSION['username'])) {
    header("Location: ..\index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $participantId = $_POST['participant_id'];
    $newPositionId = $_POST['new_position'];

    $updateSql = "UPDATE Participants SET ID_Positions = $newPositionId WHERE ID_Participants = $participantId";

    if ($conn->query($updateSql) === TRUE) {
        $participantDataSql = "SELECT p.*, pos.position AS new_position_name 
                               FROM Participants p 
                               INNER JOIN Positions pos ON p.ID_Positions = pos.ID_Positions 
                               WHERE p.ID_Participants = $participantId";
        $participantDataResult = $conn->query($participantDataSql);

        if ($participantDataResult->num_rows > 0) {
            $participantData = $participantDataResult->fetch_assoc();
            echo '<p>Participant ID: ' . $participantData['ID_Participants'] . '</p>';
            echo '<p>Name: ' . $participantData['First_name'] . ' ' . $participantData['Last_name'] . '</p>';
            echo '<p>New Position: ' . $participantData['new_position_name'] . '</p>';
        } else {
            echo 'Error: Participant data not found.';
        }
    } else {
        echo 'Error: ' . $conn->error;
    }
} else {
    echo 'Error: Invalid request method.';
}

if ($conn->ping()) {
    $conn->close();
}
