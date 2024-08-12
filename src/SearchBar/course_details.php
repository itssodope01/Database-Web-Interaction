<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\SearchBar\details.css">
    <title>Course Details</title>
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
          
            $courseId = $_GET['id'];

            
            $sqlCourse = "SELECT c.*, l.Title AS Lecturer_Title, l.Initial_Name AS Lecturer_Initial_Name, l.Family_Name AS Lecturer_Family_Name, i.Name AS Institution_Name
                FROM courses c
                LEFT JOIN lecturers l ON c.ID_Lecturers = l.ID_Lecturers
                LEFT JOIN institutions i ON l.ID_Institutions = i.ID_Institutions
                WHERE c.ID_Courses = $courseId";
            $resultCourse = $conn->query($sqlCourse);

            
            if ($resultCourse->num_rows > 0) {
                $course = $resultCourse->fetch_assoc();

               
                echo "<h1>Course Details</h1>";
                echo "<p><strong>Course Code:</strong> " . $course['Course_Code'] . "</p>";
                echo "<p><strong>Course Name:</strong> " . $course['Course_Name'] . "</p>";
                echo "<p><strong>Date:</strong> " . $course['Date'] . "</p>";
                echo "<p><strong>Place:</strong> " . $course['Place'] . "</p>";
                echo "<p><strong>Lecturer:</strong> <a href='lecturer_details.php?id=" . $course['ID_Courses'] . "'>" . $course['Lecturer_Title'] . ' ' . $course['Lecturer_Initial_Name'] . ' ' . $course['Lecturer_Family_Name'] . "</a></p>";
                echo "<p><strong>Institution:</strong> <a href='institution_details.php?id=" . $course['ID_Courses'] . "'>" . $course['Institution_Name'] . "</a></p>";
            } else {
                echo "<p>Course not found.</p>";
            }
        } else {
            echo "<p>Course ID not provided.</p>";
        }
        ?>
    </div>
</body>
</html>
