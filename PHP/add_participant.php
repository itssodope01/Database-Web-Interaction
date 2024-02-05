<?php
include('db_connection.php');

$firstName = $lastName = $position = $course = $grade = '';
$message = $error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $position = $_POST['position'];
    $course = $_POST['course'];
    $grade = $_POST['grade'];

    $checkParticipantSql = "SELECT ID_Participants FROM Participants WHERE First_name = ? AND Last_name = ?";
    $stmtCheckParticipant = $conn->prepare($checkParticipantSql);

    if ($stmtCheckParticipant) {
        $stmtCheckParticipant->bind_param("ss", $firstName, $lastName);
        $stmtCheckParticipant->execute();
        $stmtCheckParticipant->store_result();

        if ($stmtCheckParticipant->num_rows == 0) {
            $insertParticipantSql = "INSERT INTO Participants (First_name, Last_name, ID_Positions) VALUES (?, ?, ?)";
            $stmtParticipant = $conn->prepare($insertParticipantSql);

            if ($stmtParticipant) {
                $stmtParticipant->bind_param("ssi", $firstName, $lastName, $position);

                if ($stmtParticipant->execute()) {
                    $participantId = $stmtParticipant->insert_id;

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
        } else {
            $error = "Participant with the same name already exists.";
        }

        $stmtCheckParticipant->close();
    } else {
        $error = "Error in preparing Check Participant statement: " . $conn->error;
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
<script src="scripts.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Participant</title>
    <style>
    body { 
    font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; 
}

h1 {
    text-align: center; color: #333; 
}

form {
    max-width: 400px; margin: 20px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

label { display: block; margin-bottom: 8px; }

input, select { width: 100%; padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type="submit"] {
    background-color: #4caf50;
    color: #fff; cursor: pointer;
}

input[type="submit"]:hover { background-color: #45a049; }
.error { color: red; }
    p { color: green; }</style>
</head>
<body>
    <h1>Add Participant </h1>
    <div style="text-align: center; margin-bottom: 20px;">
        <!-- Return to Home Page button -->
        <a href="Pritam.php">
            <button>Return to Home Page</button>
        </a>
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
        <label for="position">Position:</label>
        <select name="position" required>
            <?php
            foreach ($positions as $pos) {
                echo "<option value='{$pos['ID_Positions']}'>{$pos['Position']}</option>";
            }
            ?>
        </select>
        <label for="course">Course:</label>
        <select name="course" id="courseSelect" required onchange="updateGradeOptions()">
            <?php
            foreach ($courses as $course) {
                echo "<option value='{$course['ID_Courses']}'>{$course['Course_Name']}</option>";
            }
            ?>
        </select>
        <label for="grade">Grade:</label>
        <select name="grade" id="gradeSelect" required>
            <option value="N/A">N/A</option>
        </select>
        <input type="submit" value="Add Participant">
        
    </form>
    <script>window.onload = updateGradeOptions;</script>
</body>
</html>

<?php
$conn->close();
?>
