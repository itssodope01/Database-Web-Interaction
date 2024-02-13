<?php
session_start();


if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

//Including database connection
include('db_connection.php');
include('db_operations.php');
include('SearchBar/search.php');

$courseData = fetchCourseData1();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="scripts.js"></script>

    <script>
        window.onload = function() {
            loadTable('TableData/Participants.php');
        };
    </script>
    <link rel="stylesheet" href="styles.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Data</title>

</head>
<body>

<!-- Buttons for other tables -->
<a href="AddParticipant/add_participant.php" class="add-participant-button">
    <button>Add Participant</button>
</a>
<a href="javascript:void(0);" class="view-table-button" onclick="loadTable('TableData/Participants.php')">
    <button>Participants</button>
</a>
<a href="javascript:void(0);" class="view-table-button" onclick="loadTable('TableData/Positions.php')">
    <button>Positions</button>
</a>
<a href="javascript:void(0);" class="view-table-button" onclick="loadTable('TableData/Lecturers.php')">
    <button>Lecturers</button>
</a>
<a href="javascript:void(0);" class="view-table-button" onclick="loadTable('TableData/Institutions.php')">
    <button>Institutions</button>
</a>
<a href="javascript:void(0);" class="view-table-button" onclick="loadTable('TableData/Courses.php')">
    <button>Courses</button>
</a>
<a href="javascript:void(0);" class="view-table-button" onclick="loadTable('TableData/CourseGrading.php')">
    <button>Course Grading</button>
</a>

<div class="left-container">

    <h1>Course Data</h1>
    <table>
        <tr>
            <th>Lecturer</th>
            <th>Course</th>
            <th>Date</th>
            <th>Participants

            </th>
        </tr>

        <?php
        //Displaying data in HTML table
        foreach ($courseData as $row) {
            echo "<tr>";
            echo "<td>" . $row["Lecturer"] . "</td>";
            echo "<td>" . $row["Course"] . "</td>";
            echo "<td>" . $row["Date"] . "</td>";
            echo '<td class="participants">' . implode(", ", array_slice(explode(", ", $row["Participants"]), 0, 2)) . '</td>'; // Display only first two participants
            echo "</tr>";
            // If there are more than two participants, display them in subsequent rows
            $participants = explode(", ", $row["Participants"]);
            if (count($participants) > 2) {
                for ($i = 2; $i < count($participants); $i++) {
                    echo "<tr>";
                    echo '<td colspan="3"></td>'; // Empty cells for Lecturer, Course, and Date columns
                    echo '<td class="participants">' . $participants[$i] . '</td>';
                    echo "</tr>";
                }
            }
        }
        ?>
    </table>
</div>

<div class="right-container">

    <div id="dynamic-table-container"></div></div>
<div id="changePositionModal" class="modal">
    <h2>Change Position</h2>
    <form id="changePositionForm" onsubmit="submitForm(event)">
        <label for="new_position">Select New Position:</label>
        <select name="new_position" id="new_position">
            <?php

            $positionsSql = "SELECT * FROM Positions";
            $positionsResult = $conn->query($positionsSql);

            if ($positionsResult->num_rows > 0) {
                $positions = $positionsResult->fetch_all(MYSQLI_ASSOC);
                foreach ($positions as $position) {
                    echo '<option value="' . $position['ID_Positions'] . '">' . $position['Position'] . '</option>';
                }
            }
            ?>
        </select>
        <input type="hidden" name="participant_id" id="participant_id">

        <div class="modal-buttons">
            <button type="submit">Change Position</button>
            <button type="button" onclick="closeModal()">Close</button>
        </div>
    </form>
</div>
<div id="removeParticipantModal" class="modal">
    <h2>Remove Participant</h2>
    <p>Are you sure you want to remove this participant?</p>

    <div class="modal-buttons">
        <button onclick="removeParticipantConfirmed()">Yes, Remove</button>
        <button type="button" onclick="closeRemoveParticipantModal()">Cancel</button>
    </div>
</div>
<div id="overlay" class="overlay"></div>

</body>
</html>
