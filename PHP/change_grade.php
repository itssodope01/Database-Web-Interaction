<?php
include('db_connection.php');

// Check if course_id and participant_id are provided in the URL
if (isset($_GET['course_id']) && isset($_GET['participant_id'])) {
    $course_id = $_GET['course_id'];
    $participant_id = $_GET['participant_id'];

    // Fetch course details for available grades
    $grades = array();
    if ($course_id == 1) {
        $grades = array('2.0', '2.5', '3.0', '3.5', '4.0', '4.5', '5.0');
    } elseif ($course_id == 2) {
        $grades = array('Passed', 'Not Passed');
    }

    // Fetch current grade for the participant in the course
    $sql = "SELECT Grade FROM Course_Grading WHERE ID_Courses = $course_id AND ID_Participants = $participant_id";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $currentGrade = $row['Grade'];
    } else {
        $currentGrade = '';
    }

    //Handling form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $newGrade = $_POST['new_grade'];

        //Updating the grade in the database
        $updateSql = "UPDATE Course_Grading SET Grade = '$newGrade' WHERE ID_Courses = $course_id AND ID_Participants = $participant_id";
        if ($conn->query($updateSql) === TRUE) {
            echo "Grade updated successfully.";
            echo "\n    Course ID: " . $course_id;
            echo "\n    Participant ID: " . $participant_id;
        
            
        }
         else {
            echo "Error updating grade: " . $conn->error;
        }
    }

    $conn->close();
} else {
    //Redirecting to an error page or home page if course_id or participant_id is not provided
    header("Location: pritam.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Grade</title>
    <style>
        label {
            display: block;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Change Grade</h1>
    <div style="text-align: left; margin-bottom: 20px;">
        <!-- Return to Home Page button -->
        <a href="Pritam.php">
            <button>Return to Home Page</button>
        </a>
    </div>

    <form method="POST">
        <label for="new_grade">Select New Grade:</label>
        <select name="new_grade" id="new_grade">
            <?php foreach ($grades as $grade) : ?>
                <option value="<?= $grade; ?>" <?= ($grade == $currentGrade) ? 'selected' : ''; ?>><?= $grade; ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
