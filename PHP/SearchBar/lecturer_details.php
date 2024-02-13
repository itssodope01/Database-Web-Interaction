<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ecf0f1; /* Lighter background color */
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
        h1, h2, p {
            color: #134668; 
            margin-bottom: 10px;
        }
        strong {
            font-weight: bold;
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
