<?php
include('db_connection.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$customQueryResult = '';
$queryHistory = isset($_SESSION['query_history']) ? $_SESSION['query_history'] : array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customQuery = $_POST['custom_query'];

    try {
        if ($conn->multi_query($customQuery)) {
            do {
                //Storing and displaying the result of each query
                $result = $conn->store_result();

                if ($result) {
                    $customQueryResult .= "<h2>Custom Query Result:</h2><table>";
                    $customQueryResult .= "<tr>";

                    while ($fieldInfo = $result->fetch_field()) {
                        $customQueryResult .= "<th>{$fieldInfo->name}</th>";
                    }

                    $customQueryResult .= "</tr>";

                    while ($row = $result->fetch_assoc()) {
                        $customQueryResult .= "<tr>";
                        foreach ($row as $value) {
                            $customQueryResult .= "<td>$value</td>";
                        }
                        $customQueryResult .= "</tr>";
                    }

                    $customQueryResult .= "</table>";
                } else {
                    //Handling queries that don't return results
                    $customQueryResult .= "<p>Query executed successfully.</p>";
                }
            } while ($conn->more_results() && $conn->next_result());

            $queryHistory[] = array('query' => $customQuery, 'result' => $customQueryResult);
            $_SESSION['query_history'] = $queryHistory;
        } else {
            throw new Exception($conn->error);
        }
    } catch (Exception $e) {
        // Catch the exception and display a custom error message
        $customQueryResult .= "<p>ERROR: " . $e->getMessage() . "</p>";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Query</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Create Custom Query</h1>
    <div style="text-align: left; margin-bottom: 20px;">
        <!-- Return to Home Page button -->
        <a href="Pritam.php">
            <button>Return to Home Page</button>
        </a>
    </div>

    <form method="post" action="">
        <label for="custom_query">Enter Your Custom Query:</label>
        <textarea name="custom_query" id="custom_query" placeholder="Example: SELECT * FROM Participants WHERE ID_Participants > 5;"></textarea>

        <br>

        <input type="submit" value="Execute Query">
    </form>

    <?php echo $customQueryResult; ?>

    <div style="text-align: left; margin-top: 20px;">
    <button onclick="toggleQueryHistory()">Query History</button>
    <button onclick="clearQueryHistory()">Clear History</button>
</div>
<div id="queryHistory" style="display: none; margin-top: 20px;">
    <h2>Query History:</h2>
    <?php $reversedHistory = array_reverse($queryHistory); ?>
    <?php foreach ($reversedHistory as $historyItem) : ?>
        <p>
            <strong>Query:</strong> <?php echo htmlspecialchars($historyItem['query']); ?><br>
            <?php echo isset($historyItem['result']) ? $historyItem['result'] : 'No result'; ?>
        </p>
    <?php endforeach; ?>
</div>
<script>
    function toggleQueryHistory() {
        var queryHistoryDiv = document.getElementById('queryHistory');
        queryHistoryDiv.style.display = (queryHistoryDiv.style.display === 'none') ? 'block' : 'none';
    }

    function toggleQueryHistory() {
        var queryHistoryDiv = document.getElementById('queryHistory');
        queryHistoryDiv.style.display = (queryHistoryDiv.style.display === 'none') ? 'block' : 'none';
    }

    function clearQueryHistory() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                location.reload();
            }
        };
        xhttp.open("GET", 'clear_query_history.php', true);
        xhttp.send();
    }
</script>
</body>
</html>