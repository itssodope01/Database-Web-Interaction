<?php

include('..\db_connection.php');
session_start();


if (!isset($_SESSION['username'])) {
    header("Location: ..\index.php");
    exit();
}


$searchResults = [];


function genericSearch($table, $columns, $searchQuery) {
    global $conn;
    $searchQuery = $conn->real_escape_string($searchQuery);
    $searchTerms = preg_split('/[ ,.]+/', $searchQuery);
    $conditions = [];
    foreach ($searchTerms as $term) {
        foreach ($columns as $column) {
            $conditions[] = "$column LIKE '%$term%'";
        }
    }
    $sql = "SELECT * FROM $table WHERE " . implode(" OR ", $conditions);
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}
function searchCoursesByCriteria($searchQuery) {
    global $conn;

    
    $sql = "SELECT * FROM courses 
            INNER JOIN lecturers ON courses.ID_Lecturers = lecturers.ID_Lecturers
            INNER JOIN institutions ON lecturers.ID_Institutions = institutions.ID_Institutions";

    
    $searchTerms = preg_split('/[ ,.]+/', $searchQuery);

  
    $conditions = [];

    foreach ($searchTerms as $term) {
        $term = $conn->real_escape_string($term);

        // Conditions for searching by lecturer's name
        $conditions[] = "lecturers.Initial_Name LIKE '%$term%' OR lecturers.Family_Name LIKE '%$term%'";

        // Conditions for searching by institution's name
        $conditions[] = "institutions.Name LIKE '%$term%'";

        // Conditions for searching by course title
        $conditions[] = "courses.Course_Name LIKE '%$term%'";

        // Conditions for searching by course date (if the term matches a date format)
        if (strtotime($term)) {
            $searchDate = date('Y-m-d', strtotime($term));
            $conditions[] = "courses.Date = '$searchDate'";
        }
    }

   
    if (!empty($conditions)) {
        $sql .= " WHERE " . implode(" OR ", $conditions);
    }

    
    $result = $conn->query($sql);

   
    if ($result->num_rows > 0) {
        $courses = $result->fetch_all(MYSQLI_ASSOC);
        return $courses;
    } else {
        return [];
    }
}


if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $searchQuery = $_GET['search'];

    $searchResults['participants'] = genericSearch("participants", ["First_name", "Last_name"], $searchQuery);
    $searchResults['positions'] = genericSearch("positions", ["Position"], $searchQuery);
    $searchResults['courses'] = genericSearch("courses", ["Course_Name"], $searchQuery);
    $searchResults['lecturers'] = genericSearch("lecturers", ["Initial_Name", "Family_Name"], $searchQuery);
    $searchResults['institutions'] = genericSearch("institutions", ["Name"], $searchQuery);
    $searchResults['searchCoursesByCriteria'] = searchCoursesByCriteria($searchQuery);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="..\styles.css">
    <link rel="stylesheet" href="..\SearchBar\SearchStyles.css">
    <script src="..\SearchBar\searchScript.js"></script>
    <script src="..\scripts.js"></script>
    <style>
        .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-left: 80px;
        }

        .results-box {
            border: 3px solid #000; 
            border-radius: 10px; 
            padding: 20px; 
            background-color: #fff; 
            margin: 20px 650px 20px 100px !important; 
            overflow: auto;
            height: 400px;
        }

        .results-box .no-results {
    margin-top: 20px;
    padding: 10px; 
}
    </style>
</head>
<body>
<!-- Search Bar -->
<div class="container">
        <!-- Back to Homepage Button -->
        <div class="back-button">
            <a href="..\pritam.php">Back to Homepage</a>
        </div>

        
        <div class="search-form">
            <form id="searchForm" method="get" action="search_results.php">
                <input type="text" name="search" id="search" class="search-input" placeholder="Search for records">
                <img class="search-icon" src="icons/search-icon.svg" alt="Search" onclick="submitSearch()">
                <img class="clear-icon" src="..\SearchBar\icons\clear-icon.svg" alt="Clear" onclick="clearSearch()">
            </form>
        </div>
        </div>

    <!-- Search history dropdown button -->
    <div class="search-history-dropdown">
        <button class="search-history-button" onclick="toggleSearchHistory()">Search History</button>
        <div class="search-history-content" id="searchHistoryDropdown">
        <button class="clear-history-button" onclick="clearSearchHistory()">Clear Search History</button>
        <ul class="search-history-list" id="searchHistory"></ul>
        </div>
    </div>
    


<!-- Display Search Results -->
<div class="results-box">
    <div class="results">
        <?php if (empty($searchResults)): ?>
            <p>No matching records found.</p> 
        <?php else: ?>
            <?php $displayedUrls = []; ?> 
            <?php foreach ($searchResults as $category => $results): ?>
                <?php if (!empty($results)): ?>
                    <?php foreach ($results as $result): ?>
                        <?php
                        
                        switch ($category) {
                            case 'participants':
                                $url = "participant_details.php?id=" . $result['ID_Participants'];
                                $name = $result['First_name'] . ' ' . $result['Last_name'];
                                $detail = 'Participant detail';
                                $icon = 'icons/participant.svg'; 
                                break;
                            case 'positions':
                                $url = "position_details.php?id=" . $result['ID_Positions'];
                                $name = $result['Position'];
                                $detail = 'Position detail';
                                $icon = 'icons/position.svg'; 
                                break;
                            case 'courses':
                            case 'searchCoursesByCriteria':
                                $url = "course_details.php?id=" . $result['ID_Courses'];
                                $name = $result['Course_Name'];
                                $detail = 'Course detail';
                                $icon = 'icons/course.svg'; 
                                break;
                            case 'lecturers':
                                $url = "lecturer_details.php?id=" . $result['ID_Lecturers'];
                                $name = $result['Initial_Name'] . ' ' . $result['Family_Name'];
                                $detail = 'Lecturer detail';
                                $icon = 'icons/lecturer.svg'; 
                                break;
                            case 'institutions':
                                $url = "institution_details.php?id=" . $result['ID_Institutions'];
                                $name = $result['Name'];
                                $detail = 'Institution detail';
                                $icon = 'icons/institution.svg'; 
                                break;
                            default:
                                $url = "#";
                                $name = "Unknown";
                                $detail = '';
                                $icon = '';
                                break;
                        }
                        ?>
                        <?php
                        
                        if (!in_array($url, $displayedUrls)):
                            $displayedUrls[] = $url; 
                        ?>
                            <div class="result-item">
                                <a href="<?php echo $url; ?>">
                                    <img class="icon" src="<?php echo $icon; ?>" alt="<?php echo $category; ?>">
                                    <?php echo $name; ?>
                                </a>
                                <span class="detail"><?php echo substr($detail, 0, 60); ?>...</span>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <?php if (empty($searchResults) || array_sum(array_map('count', $searchResults)) === 0): ?>
        <p class="no-results">No matching records found.</p>
        <?php endif; ?>
</div>

    <script>

function submitSearch() {
    const searchQuery = document.getElementById('search').value.trim();
    if (searchQuery !== '') {
        addToSearchHistory(searchQuery);
        document.getElementById('searchForm').submit();
    }
}

displaySearchHistory();
    </script>
</body>
</html>