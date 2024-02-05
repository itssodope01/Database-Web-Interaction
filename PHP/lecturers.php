<?php
include('db_connection.php');


$sql = "SELECT * FROM Lecturers";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $lecturersData = array();
    while ($row = $result->fetch_assoc()) {
        $lecturersData[] = $row;
    }
} else {
    $lecturersData = array();
}

function getInstitutionName($institutionID) {
    global $conn;

    // Query to fetch institution name based on ID
    $sql = "SELECT Name FROM Institutions WHERE ID_Institutions = $institutionID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Return concatenated address as institution name
        return $row['Name'];
    } else {
        return 'Unknown Institution';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<script src="scripts.js"></script> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturers Data</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Lecturers Data</h1>

     <!-- Toggle button to switch between showing IDs and names -->
     <button class="toggle-button" onclick="toggleNames3()">Toggle Names</button>

<?php if (!empty($lecturersData)) : ?>
    <table id="lecturersTable">
        <tr>
            <th>Title</th>
            <th>Initial Name</th>
            <th>Family Name</th>
            <!-- Initially display ID -->
            <th class="institution-id">Institution ID</th>
            <!-- Initially hide name -->
            <th class="institution-name" style="display: none;">Institution Name</th>
        </tr>
        <?php foreach ($lecturersData as $lecturer) : ?>
            <tr>
                <td><?= $lecturer['Title']; ?></td>
                <td><?= $lecturer['Initial_Name']; ?></td>
                <td><?= $lecturer['Family_Name']; ?></td>
                <!-- Initially display ID -->
                <td class="institution-id"><?= $lecturer['ID_Institutions']; ?></td>
                <!-- Initially hide name -->
                <td class="institution-name" style="display: none;"><?= getInstitutionName($lecturer['ID_Institutions']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else : ?>
    <p>No data available in Lecturers table.</p>
<?php endif; ?>
</body>
</html>
