<?php
include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $participantId = $_POST['participant_id'];
    $newPositionId = $_POST['new_position'];

    $updateSql = "UPDATE Participants SET ID_Positions = $newPositionId WHERE ID_Participants = $participantId";

    if ($conn->query($updateSql) === TRUE) {
        $participantDataSql = "SELECT * FROM Participants WHERE ID_Participants = $participantId";
        $participantDataResult = $conn->query($participantDataSql);

        if ($participantDataResult->num_rows > 0) {
            $participantData = $participantDataResult->fetch_assoc();
            echo '<p>Participant ID: ' . $participantData['ID_Participants'] . '</p>';
            echo '<p>Name: ' . $participantData['First_name'] . ' ' . $participantData['Last_name'] . '</p>';
            echo '<p>New Position: ' . $newPositionId . '</p>';
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