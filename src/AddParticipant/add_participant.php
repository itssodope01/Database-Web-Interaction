<?php
include('..\db_connection.php');

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ..\index.php");
    exit();
}

$firstName = $lastName = $position = $course = $grade = '';
$message = $error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $position = $_POST['position'];
    $course = $_POST['course'];
    $grade = $_POST['grade'];

    $checkGapSql = "SELECT ID_Participants FROM Participants";
    $result = $conn->query($checkGapSql);
    $existingIds = [];
    while ($row = $result->fetch_assoc()) {
        $existingIds[] = intval($row['ID_Participants']);
    }

    sort($existingIds);
    $expectedId = 1;
    foreach ($existingIds as $id) {
        if ($id != $expectedId) {
            $participantId = $expectedId;
            break;
        }
        $expectedId++;
    }
    if (!isset($participantId)) {
        $participantId = $expectedId;
    }

    
    $insertParticipantSql = "INSERT INTO Participants (ID_Participants, First_name, Last_name, ID_Positions) VALUES (?, ?, ?, ?)";
    $stmtParticipant = $conn->prepare($insertParticipantSql);

    if ($stmtParticipant) {
        $stmtParticipant->bind_param("isss", $participantId, $firstName, $lastName, $position);

        if ($stmtParticipant->execute()) {
            $insertCourseGradingSql = "INSERT INTO Course_Grading (ID_Participants, ID_Courses, Grade) VALUES (?, ?, ?)";
            $stmtCourseGrading = $conn->prepare($insertCourseGradingSql);

            if ($stmtCourseGrading) {
                $stmtCourseGrading->bind_param("iis", $participantId, $course, $grade);

                if ($stmtCourseGrading->execute()) {
                    $message = "Participant added successfully!";
                } else {
                    $error = "Error in inserting into Course_Grading: " . $stmtCourseGrading->error;
                }

                $stmtCourseGrading->close();
            } else {
                $error = "Error in preparing Course_Grading statement: " . $conn->error;
            }
        } else {
            $error = "Error in inserting into Participants: " . $stmtParticipant->error;
        }

        $stmtParticipant->close();
    } else {
        $error = "Error in preparing Participants statement: " . $conn->error;
    }
}

$sqlPositions = "SELECT * FROM Positions";
$resultPositions = $conn->query($sqlPositions);
$positions = array();

if ($resultPositions->num_rows > 0) {
    while ($row = $resultPositions->fetch_assoc()) {
        $positions[] = $row;
    }
}

$sqlCourses = "SELECT * FROM Courses";
$resultCourses = $conn->query($sqlCourses);
$courses = array();

if ($resultCourses->num_rows > 0) {
    while ($row = $resultCourses->fetch_assoc()) {
        $courses[] = $row;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="..\AddParticipant\AddStyles.css">
<script src="..\scripts.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Participant</title>
</head>
<body>
    <h1>Add Participant </h1>
    <div style="text-align: center; margin-bottom: 20px;">
        <!-- Return to Home Page button -->
        <div class="back-button">
        <a href="..\Pritam.php">
            <button>Return to Home Page</button>
        </a>
        </div>
    </div>
    <?php
    if (!empty($message)) {
        echo "<p>$message</p>";
    } elseif (!empty($error)) {
        echo "<p class='error'>$error</p>";
    }
    ?>
    <form method="post" action="">
        <label for="firstName">First Name:</label>
        <input type="text" name="firstName" required>
        <label for="lastName">Last Name:</label>
        <input type="text" name="lastName" required>
        <div class="select-container">
    <div class="select-wrapper">
        <label for="position">Position:</label>
        <select name="position" id="positionSelect" required>
            <?php
            foreach ($positions as $pos) {
                echo "<option value='{$pos['ID_Positions']}'>{$pos['Position']}</option>";
            }
            ?>
        </select>
    </div>
    <div class="select-wrapper">
        <label for="course">Course:</label>
        <select name="course" id="courseSelect" required onchange="updateGradeOptions()">
            <?php
            foreach ($courses as $course) {
                echo "<option value='{$course['ID_Courses']}'>{$course['Course_Name']}</option>";
            }
            ?>
        </select>
    </div>
</div>

        <label for="grade">Grade:</label>
        <select name="grade" id="gradeSelect" required>
            <option value="N/A">N/A</option>
        </select>
        <input type="submit" value="Submit">
        
    </form>
    <script>window.onload = updateGradeOptions;</script>
</body>
</html>

<?php
$conn->close();
?>
