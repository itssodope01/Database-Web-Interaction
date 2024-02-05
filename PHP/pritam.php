<?php
//Including database connection
include('db_connection.php');
include('db_operations.php');

$courseData = fetchCourseData();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script src="scripts.js"></script>
<link rel="stylesheet" href="styles.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Data</title>

</head>
<body>
    <h1>Course Data</h1>
    <table>
        <tr>
            <th>Lecturer</th>
            <th>Course</th>
            <th>Date</th>
            <th>Participants 
                <a href="Pritam_data_insert.php" class="add-participant-button">
                    <button>Add Participant</button>
                </a>
            </th>
        </tr>

        <?php
        //Displaying data in HTML table
        foreach ($courseData as $row) {
            echo "<tr>";
            echo "<td>" . $row["Lecturer"] . "</td>";
            echo "<td>" . $row["Course"] . "</td>";
            echo "<td>" . $row["Date"] . "</td>";
            echo '<td>' . $row["Participants"] . '</td>';
            echo "</tr>";
        }
        ?>
    </table>
    <!-- Buttons for other tables -->
    <a href="javascript:void(0);" class="view-table-button" onclick="loadTable('Participants.php')">
        <button>View Participants</button>
    </a>
    <a href="javascript:void(0);" class="view-table-button" onclick="loadTable('Positions.php')">
        <button>View Positions</button>
    </a>
    <a href="javascript:void(0);" class="view-table-button" onclick="loadTable('Lecturers.php')">
        <button>View Lecturers</button>
    </a>
    <a href="javascript:void(0);" class="view-table-button" onclick="loadTable('Institutions.php')">
        <button>View Institutions</button>
    </a>
    <a href="javascript:void(0);" class="view-table-button" onclick="loadTable('Courses.php')">
        <button>View Courses</button>
    </a>
    <a href="javascript:void(0);" class="view-table-button" onclick="loadTable('CourseGrading.php')">
        <button>View Course Grading</button>
    </a>

    <a href="CreateQuery.php" class="view-table-button">
        <button>Custom Query</button>
    </a>

    <div id="dynamic-table-container"></div>
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
