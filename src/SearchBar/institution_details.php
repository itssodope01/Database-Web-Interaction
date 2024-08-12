<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\SearchBar\details.css">
    <title>Institution Details</title>
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
            
            $institutionId = $_GET['id'];

           
            $sqlInstitution = "SELECT * FROM institutions WHERE ID_Institutions = $institutionId";
            $resultInstitution = $conn->query($sqlInstitution);

            
            if ($resultInstitution->num_rows > 0) {
                $institution = $resultInstitution->fetch_assoc();

                
                echo "<h1>Institution Details</h1>";
                echo "<p><strong>ID:</strong> " . $institution['ID_Institutions'] . "</p>";
                echo "<p><strong>Name:</strong> " . $institution['Name'] . "</p>";
                echo "<p><strong>Address:</strong> " . $institution['Address1'] . ", " . $institution['Address2'] . "</p>";
            } else {
                echo "<p>Institution not found.</p>";
            }
        } else {
            echo "<p>Institution ID not provided.</p>";
        }
        ?>
    </div>
</body>
</html>
