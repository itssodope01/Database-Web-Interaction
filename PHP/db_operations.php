<?php
function fetchCourseData() {
    global $conn;
    $sql = "SELECT
    concat(Lecturers.Title, ' ',Lecturers.Initial_Name,' ',
    Lecturers.Family_Name) AS Lecturer,
    Courses.Course_Name AS Course,
    CONCAT(Courses.Date) AS Date,
    GROUP_CONCAT(CONCAT(Participants.First_name, ' ',
    Participants.Last_name) SEPARATOR ', ') AS Participants
FROM
    ((Courses
    INNER JOIN Lecturers ON Courses.ID_Lecturers = Lecturers.ID_Lecturers)
    INNER JOIN Institutions ON Lecturers.ID_Institutions = Institutions.ID_Institutions)
    INNER JOIN Course_Grading ON Courses.ID_Courses = Course_Grading.ID_Courses
    INNER JOIN Participants ON Course_Grading.ID_Participants = Participants.ID_Participants
GROUP BY
    Lecturers.Title, Lecturers.Initial_Name, Lecturers.Family_Name,
    Courses.Course_Name, Institutions.Name, Courses.Place, Courses.Date";

    $result = $conn->query($sql);

    $data = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}
