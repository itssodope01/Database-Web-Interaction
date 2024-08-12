<!DOCTYPE html>
<html lang="en">
<head>
<script src="..\SearchBar\searchScript.js"></script>
    <link rel="stylesheet" href="..\SearchBar\SearchStyles.css">
    <script src="..\scripts.js"></script>
    <style>
        .search-form {
            left: 430px;
        }

        .search-icon, .clear-icon {
            top: 50%;
        }
    </style>
</head>
<body>
    
    <!-- Search Form -->
    <div class="search-form">
            <form id="searchForm" method="get" action="SearchBar/search_results.php">
                <input type="text" name="search" id="search" class="search-input" placeholder="Search for records">
                <img class="search-icon" src="..\SearchBar\icons\search-icon.svg" alt="Search" onclick="submitSearch()">
                <img class="clear-icon" src="..\SearchBar\icons\clear-icon.svg" alt="Clear" onclick="clearSearch()">
            </form>
        </div>
    </div>

    <script>
      function submitSearch() {
        document.getElementById('searchForm').submit();
    }
    </script>
</body>
</html>
