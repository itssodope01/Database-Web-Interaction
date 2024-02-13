<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participant Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ecf0f1; 
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border: 1px solid #ccc;
        }
        h1, h2 {
            color: #134668;
            margin-bottom: 20px;
        }
        ul {
            padding: 0;
            margin: 0;
            list-style-type: none;
        }
        li {
            margin-bottom: 20px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 20px;
        }
        strong {
            font-weight: bold;
            color: #555;
        }
        p {
            margin-bottom: 20px;
        }
        .no-results {
            color: #555; 
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        
        include('..\db_connection.php');
        session_start();

       
if (!isset($_SESSION['username'])) {
    header("Location: ..\index.php");
    exit();
}

        
        if (isset($_GET['id'])) {
           
            $participantId = $_GET['id'];

            
            $sqlParticipant = "SELECT p.*, pos.Position
                FROM participants p
                LEFT JOIN positions pos ON p.ID_Positions = pos.ID_Positions
                WHERE p.ID_Participants = $participantId";
            $resultParticipant = $conn->query($sqlParticipant);

            
            if ($resultParticipant->num_rows > 0) {
                $participant = $resultParticipant->fetch_assoc();


echo "<h1>Participant Details</h1>";
echo "<p><strong>Name:</strong>" . ' ' .$participant['First_name'] . ' ' . $participant['Last_name'] ."</p>";
echo "<p><strong>Position:</strong> " . $participant['Position'] . "</p>";


$sqlCourses = "SELECT c.Course_Code, c.Course_Name, cg.Grade, l.Title, l.Initial_Name, l.Family_Name, c.ID_Courses
    FROM course_grading cg
    LEFT JOIN courses c ON cg.ID_Courses = c.ID_Courses
    LEFT JOIN lecturers l ON c.ID_Lecturers = l.ID_Lecturers
    WHERE cg.ID_Participants = $participantId";
$resultCourses = $conn->query($sqlCourses);


if ($resultCourses->num_rows > 0) {
    
    echo "<h2>Courses and Grades</h2>";
    echo "<ul>";
    while ($course = $resultCourses->fetch_assoc()) {
        echo "<li>";
        echo "<strong>Course:</strong> <a href='course_details.php?id=" . $course['ID_Courses'] . "'>" . $course['Course_Code'] . ' - ' . $course['Course_Name'] . "</a><br>";
        echo "<strong>Lecturer:</strong> <a href='lecturer_details.php?id=" . $course['ID_Courses'] . "'>". $course['Title'] . ' ' . $course['Initial_Name'] . ' ' . $course['Family_Name'] . "</a><br>";
        echo "<strong>Grade:</strong> " . $course['Grade'] . "<br>";
        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "<p class='no-results'>No courses found for this participant.</p>";
}

            } else {
                echo "<p class='no-results'>Participant not found.</p>";
            }
        } else {
            echo "<p class='no-results'>Participant ID not provided.</p>";
        }
        ?>
    </div>
</body>
</html>
