<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\SearchBar\details.css">
    <title>Position Details</title>
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
           
            $positionId = $_GET['id'];

            
            $sqlPosition = "SELECT pos.ID_Positions, pos.Position, par.First_name, par.Last_name, par.ID_Participants
                            FROM positions pos
                            LEFT JOIN participants par ON pos.ID_Positions = par.ID_Positions
                            WHERE pos.ID_Positions = $positionId";
            $resultPosition = $conn->query($sqlPosition);

           
            if ($resultPosition->num_rows > 0) {
                $positionData = $resultPosition->fetch_assoc();

               
                echo "<h1>Position Details</h1>";
                echo "<p><strong>Position ID:</strong> " . $positionData['ID_Positions'] . "</p>";
                echo "<p><strong>Position Name:</strong> " . $positionData['Position'] . "</p>";

               
                echo "<h2>Participants under this Position:</h2>";
                if ($positionData['First_name'] != null) {
                    echo "<ul>";
                    do {
                        echo "<li> <a href='participant_details.php?id=" . $positionData['ID_Participants'] . "'>" . $positionData['First_name'] . " " . $positionData['Last_name'] . "</a></li>";
                    } while ($positionData = $resultPosition->fetch_assoc());
                    echo "</ul>";
                } else {
                    echo "<p>No participants found under this position.</p>";
                }
            } else {
                echo "<p>Position not found.</p>";
            }
        } else {
            echo "<p>Position ID not provided.</p>";
        }
        ?>
    </div>
</body>
</html>
