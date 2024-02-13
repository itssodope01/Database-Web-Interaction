function clearSearch() {
    document.getElementById('search').value = ''; 
}

function toggleSearchHistory() {
    const dropdown = document.getElementById('searchHistoryDropdown');
    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
}


function getSearchHistory() {
    return JSON.parse(localStorage.getItem('searchHistory')) || [];
}

function displaySearchHistory() {
const searchHistory = getSearchHistory();
const historyContainer = document.getElementById('searchHistory');


historyContainer.innerHTML = '';

searchHistory.forEach(query => {
const item = document.createElement('a');
const url = "search_results.php?search=" + encodeURIComponent(query); 
item.textContent = query;
item.href = url;
item.classList.add('search-history-item'); 


item.addEventListener('click', (event) => {
    event.preventDefault(); 
    const clickedQuery = event.target.textContent;
    removeFromSearchHistory(clickedQuery); 
    addToSearchHistory(clickedQuery); 
    window.location.href = url; 
});


item.style.display = 'block';
historyContainer.appendChild(item);
});
}


function removeFromSearchHistory(query) {
let searchHistory = getSearchHistory();
const index = searchHistory.indexOf(query);
if (index !== -1) {
searchHistory.splice(index, 1); 
localStorage.setItem('searchHistory', JSON.stringify(searchHistory)); 
}
}



function clearSearchHistory() {
    localStorage.removeItem('searchHistory');
    displaySearchHistory();
}


function addToSearchHistory(query) {
    let searchHistory = getSearchHistory();
    searchHistory.unshift(query);
    localStorage.setItem('searchHistory', JSON.stringify(searchHistory));
    displaySearchHistory();
}

function toggleSearchHistory() {
    var dropdown = document.getElementById("searchHistoryDropdown");
    var button = document.querySelector(".search-history-button");
    dropdown.classList.toggle("flipped");
    button.classList.toggle("flipped");
}