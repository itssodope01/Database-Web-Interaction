<?php
include('..\db_connection.php');
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ..\index.php");
    exit();
}


if (isset($_GET['course_id']) && isset($_GET['participant_id'])) {
    $course_id = $_GET['course_id'];
    $participant_id = $_GET['participant_id'];

   
    $grades = array();
    if ($course_id == 1 || $course_id == 3 || $course_id == 4) {
        $grades = array('2.0', '2.5', '3.0', '3.5', '4.0', '4.5', '5.0');
    } elseif ($course_id == 2) {
        $grades = array('Passed', 'Not Passed');
    }


    $courseCode = '';
    $courseCodeSql = "SELECT Course_Code FROM Courses WHERE ID_Courses = $course_id"; 
    $courseCodeResult = $conn->query($courseCodeSql);
    if ($courseCodeResult->num_rows == 1) {
        $courseCodeRow = $courseCodeResult->fetch_assoc();
        $courseCode = $courseCodeRow['Course_Code'];
    }

   
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
            $message = "Grade updated successfully. Course Code: $courseCode, Participant ID: $participant_id";
            $messageType = 'success';
        } else {
            $message = "Error updating grade: " . $conn->error;
            $messageType = 'error';
        }
    }

    $conn->close();
} else {
    //Redirecting to an error page or home page if course_id or participant_id is not provided
    header("Location: ..\pritam.php");
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
        body {
            font-family: Arial, sans-serif;
            background-color: #ecf0f1;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            color: #333;
        }

        .container {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
            top: 0;
            transition: top 0.1s ease;
        }

        .container:hover {
            top: -2px;
        }

        h1 {
            text-align: center;
            color: #16415e;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-top: 10px;
            color: #555;
        }

        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            margin-top: 5px;
            box-sizing: border-box;
            background-color: #f9f9f9;
            background-image: url('data:image/svg+xml;utf8,<svg fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="%23555555"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>');
            background-repeat: no-repeat;
            background-position: right 10px center;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            width: 100%;
            margin-top: 20px;
            background-color: #16415e;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #245575;
        }

        .return-link {
            text-align: center;
            margin-top: 20px;
        }

        .return-link a {
            text-decoration: none;
            color: #245575;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .return-link a:hover {
            color: #2980b9;
        }

        .message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 4px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Change Grade</h1>
        <?php if (isset($message)) : ?>
            <div class="message <?= $messageType; ?>">
                <?= $message; ?>
            </div>
        <?php endif; ?>
        <form method="POST">
            <label for="new_grade">Select New Grade:</label>
            <select name="new_grade" id="new_grade">
                <?php foreach ($grades as $grade) : ?>
                    <option value="<?= $grade; ?>" <?= ($grade == $currentGrade) ? 'selected' : ''; ?>><?= $grade; ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Submit</button>
        </form>

        <div class="return-link">
            <!-- Return to Home Page button -->
            <a href="..\Pritam.php">Return to Home Page</a>
        </div>
    </div>
</body>
</html>
