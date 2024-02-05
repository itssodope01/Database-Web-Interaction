<?php
include('db_connection.php');

$sql = "SELECT CG.ID_Courses, CG.ID_Participants, CG.Grade, 
               C.Course_Name, CONCAT(P.First_Name, ' ', P.Last_Name) AS Participant_Name
        FROM Course_Grading CG
        INNER JOIN Courses C ON CG.ID_Courses = C.ID_Courses
        INNER JOIN Participants P ON CG.ID_Participants = P.ID_Participants";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $courseGradingData = array();
    while ($row = $result->fetch_assoc()) {
        $courseGradingData[] = $row;
    }
} else {
    $courseGradingData = array();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<script src="scripts.js"></script>
<link rel="stylesheet" href="styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Grading Data</title>
    <style>
        .toggle-button {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Course Grading Data</h1>

    <!-- Toggle button to switch between showing IDs and names -->
    <button class="toggle-button" onclick="toggleNames()">Toggle Names</button>

    <?php if (!empty($courseGradingData)) : ?>
        <table id="gradingTable">
            <tr>
                <th>Course</th>
                <th>Participant</th>
                <th>Grade</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($courseGradingData as $grading) : ?>
                <tr>
                    <!-- Initially display IDs -->
                    <td class="course-id"><?= $grading['ID_Courses']; ?></td>
                    <td class="participant-id"><?= $grading['ID_Participants']; ?></td>

                    <!-- Initially hide names -->
                    <td class="course-name" style="display: none;"><?= $grading['Course_Name']; ?></td>
                    <td class="participant-name" style="display: none;"><?= $grading['Participant_Name']; ?></td>

                    <td><?= $grading['Grade']; ?></td>
                    <td>
                        <a href="change_grade.php?course_id=<?= $grading['ID_Courses']; ?>&participant_id=<?= $grading['ID_Participants']; ?>" class="change-grade-button">
                            <button>Change Grade</button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else : ?>
        <p>No data available in Course Grading table.</p>
    <?php endif; ?>

</body>
</html>
