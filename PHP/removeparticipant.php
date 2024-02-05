<?php
include('db_connection.php');

if(isset($_GET['id'])) {
    $participantId = $_GET['id'];

    $deleteCourseGrading = "DELETE FROM Course_Grading WHERE ID_Participants = $participantId";
    $resultCourseGrading = $conn->query($deleteCourseGrading);

    if ($resultCourseGrading) {
       
        $deleteParticipant = "DELETE FROM Participants WHERE ID_Participants = $participantId";
        $resultParticipant = $conn->query($deleteParticipant);

        if ($resultParticipant) {
           
            $resetAutoIncrement = "ALTER TABLE Participants AUTO_INCREMENT = $participantId";
            $conn->query($resetAutoIncrement);

            echo "Participant removed successfully. Reload Page to see updated information.";
        } else {
            echo "Error removing participant from Participants table: " . $conn->error;
        }
    } else {
        echo "Error removing participant from Course_Grading table: " . $conn->error;
    }
} else {
    echo "Participant ID not provided.";
}

$conn->close();
