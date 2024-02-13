<?php
include('..\db_connection.php');

session_start();


if (!isset($_SESSION['username'])) {
    header("Location: ..\index.php");
    exit();
}

$sql = "SELECT C.ID_Courses, C.Course_Code, C.Course_Name, L.ID_Lecturers, CONCAT(L.Title, ' ', L.Initial_Name, ' ', L.Family_Name) AS Lecturer
        FROM Courses C
        INNER JOIN Lecturers L ON C.ID_Lecturers = L.ID_Lecturers";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $coursesData = array();
    while ($row = $result->fetch_assoc()) {
        $coursesData[] = $row;
    }
} else {
    $coursesData = array();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script src="..\scripts.js"></script>
    <link rel="stylesheet" href="..\styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses Data</title>
</head>
<body>
    <div class="container">
        <h1>Courses Data</h1>

        <!-- Toggle button to switch between showing IDs and names -->
        <div class="toggle-container">
            <button class="toggle-button" onclick="toggleNames2()">Toggle Names</button>
        </div>

        <?php if (!empty($coursesData)) : ?>
            <table id="coursesTable">
                <tr>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Lecturer</th>
                </tr>
                <?php foreach ($coursesData as $course) : ?>
                    <tr>
                        <td><?= $course['Course_Code']; ?></td>
                        <td><?= $course['Course_Name']; ?></td>
                        <!-- Initially display lecturer ID -->
                        <td class="lecturer-id"><?= $course['ID_Lecturers']; ?></td>
                        <!-- Initially hide lecturer name -->
                        <td class="lecturer-name" style="display: none;">
                            <?= $course['Lecturer']; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else : ?>
            <p>No data available in Courses table.</p>
        <?php endif; ?>
    </div>
</body>
</html>
