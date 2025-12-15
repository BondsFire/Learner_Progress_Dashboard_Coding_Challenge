<!DOCTYPE html>

<head class="headCl">
<div class="optionsContainer">

  <div class="dropdown">
        <button onclick="toggleDropdownCourses()" class="dropbtn">Courses</button>
        <div id="myDropdown" class="dropdown-content">
        <input type="text" placeholder="Search.." id="searchInput" onkeyup="filterDropdownCourses()">
            <?php
                echo '<ul style="list-style-type:none" >';
                echo '<li onClick="handleFilterLearnersByCourse(\'\')">--Clear--</li>';
                foreach ($courses as $course) {
                    echo '<li onClick="handleFilterLearnersByCourse(\''.$course->name.'\')">'.$course->name.'</li>';
                }
                echo '</ul>';
            ?>
        </div>
  </div>

  <div class="sortBy">
    <button onclick="toggleSortProgress()" class="toglebtn">Progress</button>
  </div>

  </div>


</head>
<body class="bodyCl">
<div class="mainContainer">

<div id="tableContainer"></div>



</body>


<style>
.dropbtn {
  background-color: #c69930;
  color: white;
  padding: 16px;
  margin: 16px;
  font-size: 16px;
  border: none;
  cursor: pointer;
}

.bodyCl {
  margin:0px;
}
.headCl {
  background-color: #272727;
}


.toglebtn {
  background-color: #c69930;
  color: white;
  padding: 16px;
  margin: 16px;
  font-size: 16px;
  border: none;
  cursor: pointer;
}

.optionsContainer {
  display: flex;
  flex-direction: row;
  justify-content: center;
  background-color: #272727;
}
.mainContainer {
  display: flex;
  flex-direction: row;
  justify-content: center;
  font-family: Open Sans, sans-serif;
  background-color: #fbf8f1;
  padding: 16px;
}
.tableContainer {
  margin: 16px;


}

.dropbtn:hover, .dropbtn:focus {
  background-color: #a48338ff;
}

#searchInput {
  box-sizing: border-box;
  background-image: url('searchicon.png');
  background-position: 14px 12px;
  background-repeat: no-repeat;
  font-size: 16px;
  padding: 14px 20px 12px 45px;
  border: none;
  border-bottom: 1px solid #ddd;
}
/* #fbf8f1 */
#searchInput:focus {outline: 3px solid #ddd;}

.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f6f6f6;
  min-width: 230px;
  overflow: auto;
  border: 1px solid #ddd;
  z-index: 1;
}

.dropdown-content li {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown li:hover {background-color: #ddd;}

.show {display: block;}
</style>

<script>

const learnerData = <?php echo json_encode($learners); ?>;
const userEnrolment = <?php echo json_encode($enrolments); ?>;
const userCourses = <?php echo json_encode($courses); ?>;
var courseProgress = <?php echo json_encode($progress); ?>;
var courseFilter = <?php echo json_encode($courseFilter); ?>;
var tableData= []

// console.log(learnerData)
// console.log(userEnrolment)
// console.log(userCourses)
console.log(courseProgress)
console.log(courseFilter)

function filterLearnersByCourse(newCourseFilter) {
    
  learnerList = [] 

  console.log(newCourseFilter)
    
    
  if(newCourseFilter != null && newCourseFilter != ''){
    selectedCourse = userCourses.find(course => course.name === newCourseFilter)
    console.log(selectedCourse)
    userEnrolment.forEach(enrolment => {
      if(enrolment.course_id === selectedCourse.id){
        foundLearner = learnerData.find(learner => learner.id === enrolment.learner_id)
        foundLearner.course = selectedCourse
        foundLearner.progress = enrolment.progress
        learnerList.push(foundLearner)
      }
    });
    
  }else{
    userEnrolment.forEach(enrolment => {
      var foundLearner = learnerData.find(learner => learner.id === enrolment.learner_id);
      foundLearner.course = userCourses.find(course => course.id === enrolment.course_id);
      foundLearner.progress = enrolment.progress;
      learnerList.push(structuredClone(foundLearner))
      
    });
  }

  

  tableData = learnerList.map(learner=> {
      return{
        fullName: learner.firstname + ' ' + learner.lastname,
        course: learner.course.name,
        progress: learner.progress,
      }
    });

    tableData.sort((a, b)=> a.fullName.localeCompare(b.fullName));
    return tableData
    
}

function sortByProgress(data) {

  if(courseProgress != null && courseProgress != '')
    data.sort((a, b)=> b.progress-a.progress );
  

  return data

}




generateTable(sortByProgress(filterLearnersByCourse(courseFilter)))
 
function toggleDropdownCourses() {
  document.getElementById("myDropdown").classList.toggle("show");
  document.getElementById("searchInput").value = document.getElementById("searchInput").ariaPlaceholder;
  filterDropdownCourses()
}

function handleFilterLearnersByCourse (filter) {
  
  toggleDropdownCourses()
  generateTable(sortByProgress(filterLearnersByCourse(filter)))

}

function toggleSortProgress() {
  courseProgress = courseProgress? null: 'y'
  generateTable(sortByProgress(tableData))

}

function filterDropdownCourses() {
  const input = document.getElementById("searchInput");
  const filter = input.value.toUpperCase();
  const div = document.getElementById("myDropdown");
  const a = div.getElementsByTagName("li");
  for (let i = 0; i < a.length; i++) {
    txtValue = a[i].textContent || a[i].innerText;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      a[i].style.display = "";
    } else {
      a[i].style.display = "none";
    }
  }
}

function generateTable(dataArray) {
    
    document.getElementById('tableContainer').replaceChildren();
    const table = document.createElement('table');
    table.setAttribute('border', '1'); // Optional: Add a border for visibility
    table.setAttribute('name', 'Learner Progress') 
    
    // 1. Create and append the table header (thead)
    const thead = table.createTHead();
    const headerRow = thead.insertRow();
    
    // Get headers from the keys of the first object
    const headers = Object.keys(dataArray[0]);
    headers.forEach(headerText => {
        const th = document.createElement('th');
        th.textContent = headerText;
        headerRow.appendChild(th);
    });
    
    // 2. Create and append the table body (tbody)
    const tbody = table.createTBody();
    dataArray.forEach(item => {
        const row = tbody.insertRow();
        Object.values(item).forEach(value => {
            const cell = row.insertCell();
            cell.textContent = value;
            cell.style.padding = '5px'
        });
    });
    
    // 3. Append the built table to the container in the DOM
    document.getElementById('tableContainer').appendChild(table);
}
</script>