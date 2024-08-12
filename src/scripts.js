//pritam.php
function removeParticipant(participantId) {
    openRemoveParticipantModal(participantId);
}

function openRemoveParticipantModal(participantId) {
    document.getElementById('removeParticipantModal').style.display = 'block';
    document.getElementById('overlay').style.display = 'block';
    document.getElementById('participant_id').value = participantId;
}

function removeParticipantConfirmed() {
    var participantId = document.getElementById('participant_id').value;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("dynamic-table-container").innerHTML = this.responseText;
            closeRemoveParticipantModal();
        }
    };
    xhttp.open("GET", 'RemoveParticipant/removeparticipant.php?id=' + participantId, true);
    xhttp.send();
}

function closeRemoveParticipantModal() {
    document.getElementById('removeParticipantModal').style.display = 'none';
    document.getElementById('overlay').style.display = 'none';
}

function loadTable(table) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("dynamic-table-container").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", table, true);
    xhttp.send();
}

function changePosition(participantId) {
    openModal(participantId);
}

function openModal(participantId) {
    document.getElementById('changePositionModal').style.display = 'block';
    document.getElementById('overlay').style.display = 'block';
    document.getElementById('participant_id').value = participantId;
}

function closeModal() {
    document.getElementById('changePositionModal').style.display = 'none';
    document.getElementById('overlay').style.display = 'none';
}

function submitForm(event) {
    event.preventDefault();
    var formData = new FormData(document.getElementById('changePositionForm'));
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("dynamic-table-container").innerHTML = this.responseText;
            closeModal();
        }
    };
    xhttp.open("POST", 'ChangePosition/changeposition_ajax.php', true);
    xhttp.send(formData);
}



//Data Insetion Script (Pritam_data_insert.php)
function updateGradeOptions() {
    var courseSelect = document.getElementById("courseSelect");
    var gradeSelect = document.getElementById("gradeSelect");
    var selectedCourseId = courseSelect.value;    
gradeSelect.innerHTML = "";
if (selectedCourseId === "1" | selectedCourseId === "3" | selectedCourseId === "4") { 
    var grades = ["2.0", "2.5", "3.0", "3.5", "4.0", "4.5", "5.0"];
for (var i = 0; i < grades.length; i++) {
    var option = document.createElement("option");
        option.value = grades[i];
        option.text = grades[i];
        gradeSelect.add(option);
    }
} else if (selectedCourseId === "2") { 
    var options = ["Passed", "Not Passed"];
for (var i = 0; i < options.length; i++) {
    var option = document.createElement("option");
        option.value = options[i];
        option.text = options[i];
        gradeSelect.add(option);
    }
} 
}

//toggle

function toggleNames() {
    var table = document.getElementById("gradingTable");
    var courseIDCells = table.getElementsByClassName("course-id");
    var participantIDCells = table.getElementsByClassName("participant-id");
    var courseNameCells = table.getElementsByClassName("course-name");
    var participantNameCells = table.getElementsByClassName("participant-name");

    for (var i = 0; i < courseIDCells.length; i++) {
        if (courseIDCells[i].style.display === "none") {
            courseIDCells[i].style.display = "table-cell";
            participantIDCells[i].style.display = "table-cell";
            courseNameCells[i].style.display = "none";
            participantNameCells[i].style.display = "none";
        } else {
            courseIDCells[i].style.display = "none";
            participantIDCells[i].style.display = "none";
            courseNameCells[i].style.display = "table-cell";
            participantNameCells[i].style.display = "table-cell";
        }
    }
}

function toggleNames2() {
    var table = document.getElementById("coursesTable");
    var lecturerIDCells = table.getElementsByClassName("lecturer-id");
    var lecturerNameCells = table.getElementsByClassName("lecturer-name");

    for (var i = 0; i < lecturerIDCells.length; i++) {
        if (lecturerIDCells[i].style.display === "none") {
            lecturerIDCells[i].style.display = "table-cell";
            lecturerNameCells[i].style.display = "none";
        } else {
            lecturerIDCells[i].style.display = "none";
            lecturerNameCells[i].style.display = "table-cell";
        }
    }
}

function toggleNames3() {
    var table = document.getElementById("lecturersTable");
    var institutionIDCells = table.getElementsByClassName("institution-id");
    var institutionNameCells = table.getElementsByClassName("institution-name");

    for (var i = 0; i < institutionIDCells.length; i++) {
        if (institutionIDCells[i].style.display === "none") {
            institutionIDCells[i].style.display = "table-cell";
            institutionNameCells[i].style.display = "none";
        } else {
            institutionIDCells[i].style.display = "none";
            institutionNameCells[i].style.display = "table-cell";
        }
    }
}


function showGrades(courseId) {
    var innerTable = document.getElementById('grades_' + courseId);
    if (innerTable.style.display === 'none') {
        innerTable.style.display = 'block';
    } else {
        innerTable.style.display = 'none';
    }
}
function toggleGrades(courseId) {
    var gradesTable = document.getElementById('grades_' + courseId);
    if (gradesTable.style.maxHeight) {
        gradesTable.style.maxHeight = null;
    } else {
        gradesTable.style.maxHeight = gradesTable.scrollHeight + "px";
    }
}
