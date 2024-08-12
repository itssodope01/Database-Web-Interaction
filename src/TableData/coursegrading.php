<?php
include('..\db_connection.php');

session_start();

//Checking if user is not authenticated, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: ..\index.php");
    exit();
}

$sql = "SELECT CG.ID_Courses, CG.ID_Participants, CG.Grade, 
               C.Course_Name, C.Course_Code, CONCAT(P.First_Name, ' ', P.Last_Name) AS Participant_Name, P.ID_Participants AS Participant_ID
        FROM Course_Grading CG
        INNER JOIN Courses C ON CG.ID_Courses = C.ID_Courses
        INNER JOIN Participants P ON CG.ID_Participants = P.ID_Participants";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $courseGradingData = array();
    while ($row = $result->fetch_assoc()) {
        $course_id = $row['ID_Courses'];
        //Grouping by Course ID
        if (!isset($courseGradingData[$course_id])) {
            $courseGradingData[$course_id] = array(
                'Course_Name' => $row['Course_Name'],
                'Course_Code' => $row['Course_Code'],
                'Grades' => array(),
            );
        }
        $courseGradingData[$course_id]['Grades'][] = array(
            'Participant_Name' => $row['Participant_Name'],
            'Participant_ID' => $row['Participant_ID'],
            'Grade' => $row['Grade'],
        );
    }
} else {
    $courseGradingData = array();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .container {
            overflow: hidden;
        }
        .course-item {
            margin-bottom: 3px;
        }
        .course-item h2 {
            margin: 0;
            padding: 7px;
            cursor: pointer;
            background-color: #f0f0f0;
            border-bottom: 1px solid #ccc;
            border-radius: 3px 3px 0 0;
        }
        .grades-table {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
            background-color: #fff; 
            border-left: 1px solid #ccc;
            border-right: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
            border-radius: 0 0 5px 5px;
        }
        .grades-table.open {
            max-height: 300px; 
        }
        .grades-table table {
            width: 100%;
        }
        
        .change-grade-button {
            display: inline-block;
            padding: 4px 8px; 
            background-color: #3498DB;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none; 
            font-size: 14px; 
        }
        .change-grade-button:hover {
            background-color: #2980B9;
        }
        
        .container, .change-grade-button {
            margin-right: 5px; 
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Course Grading Data</h1>

        <?php if (!empty($courseGradingData)) : ?>
            <?php foreach ($courseGradingData as $course_id => $course) : ?>
                <div class="course-item">
                    <h2 onclick="toggleGrades('<?= $course_id; ?>')">
                        <?= formatCourse($course['Course_Code'], $course['Course_Name']); ?>
                    </h2>
                    <div id="grades_<?= $course_id; ?>" class="grades-table">
                        <table> 
                            <tr>
                                <th>Participant ID</th>
                                <th>Participant Name</th>
                                <th>Grade</th>
                                <th>Actions</th>
                            </tr>
                            <?php foreach ($course['Grades'] as $grade) : ?>
                                <tr>
                                    <td><?= $grade['Participant_ID']; ?></td>
                                    <td><?= $grade['Participant_Name']; ?></td>
                                    <td><?= $grade['Grade']; ?></td>
                                    <td>
                                        <a href="ChangeGrade/change_grade.php?course_id=<?= $course_id; ?>&participant_id=<?= $grade['Participant_ID']; ?>" class="change-grade-button">
                                            Change Grade
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No data available in Course Grading table.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
function formatCourse($code, $name) {
    return sprintf('<span>%s -</span> %s', $code, $name);
}
