<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\SearchBar\details.css">
    <title>Lecturer Details</title>
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
            
            $lecturerId = $_GET['id'];

            
            $sqlLecturer = "SELECT l.*, i.Name AS Institution_Name
                FROM lecturers l
                LEFT JOIN institutions i ON l.ID_Institutions = i.ID_Institutions
                WHERE l.ID_Lecturers = $lecturerId";
            $resultLecturer = $conn->query($sqlLecturer);

            
            if ($resultLecturer->num_rows > 0) {
                $lecturer = $resultLecturer->fetch_assoc();

               
                echo "<h1>Lecturer Details</h1>";
                echo "<p><strong>Title:</strong> " . $lecturer['Title'] . "</p>";
                echo "<p><strong>Initial Name:</strong> " . $lecturer['Initial_Name'] . "</p>";
                echo "<p><strong>Family Name:</strong> " . $lecturer['Family_Name'] . "</p>";
                echo "<p><strong>Institution:</strong> <a href='institution_details.php?id=" . $lecturer['ID_Lecturers'] . "'>" . $lecturer['Institution_Name'] . "</a></p>";
            } else {
                echo "<p>Lecturer not found.</p>";
            }
        } else {
            echo "<p>Lecturer ID not provided.</p>";
        }
        ?>
    </div>
</body>
</html>
