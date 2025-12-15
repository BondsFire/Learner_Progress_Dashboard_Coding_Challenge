<!DOCTYPE html>
<?php
    echo '<a>'.$learners.'</a>';
?>



<body>
<table>
<tr>

    <caption>Learner Progress</caption>
    <th>Full Name</th>
    <th>Courses 
    <div class="dropdown">
        <button onclick="myFunction()" class="dropbtn">Dropdown</button>
        <div id="myDropdown" class="dropdown-content">
        <input type="text" placeholder="Search.." id="myInput" onkeyup="filterFunction()">
            <?php
            
                foreach ($courses as $course) {
                    echo '<a >'.$course->name.'</a>';
                }
            ?>
        </div>
</div></th>
    
    

</tr>
@foreach($learners as $learner) 
           
           <tr>
            <td>{{ $learner->firstname}} {{ $learner->lastname}}</td>
           <td>
            <table>
                <th>Name</th>
                <th>Progress (%)</th>
                @foreach($learner->courses as $course)
                <tr>
                    <td>{{$course->name}}</td>
                    <td>{{$course->pivot->progress}}</td>
                
                </tr>
                @endforeach 
            </table>
           </td>
           </tr>      
 @endforeach

</table>


</body>


<style>
.dropbtn {
  background-color: #04AA6D;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
  cursor: pointer;
}

.dropbtn:hover, .dropbtn:focus {
  background-color: #3e8e41;
}

#myInput {
  box-sizing: border-box;
  background-image: url('searchicon.png');
  background-position: 14px 12px;
  background-repeat: no-repeat;
  font-size: 16px;
  padding: 14px 20px 12px 45px;
  border: none;
  border-bottom: 1px solid #ddd;
}

#myInput:focus {outline: 3px solid #ddd;}

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

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropdown a:hover {background-color: #ddd;}

.show {display: block;}
</style>

<script>
 
function myFunction() {
    console.log('myfunction')
  document.getElementById("myDropdown").classList.toggle("show");
}

function filterFunction() {
  const input = document.getElementById("myInput");
  const filter = input.value.toUpperCase();
  const div = document.getElementById("myDropdown");
  const a = div.getElementsByTagName("a");
  for (let i = 0; i < a.length; i++) {
    txtValue = a[i].textContent || a[i].innerText;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      a[i].style.display = "";
    } else {
      a[i].style.display = "none";
    }
  }
}
</script>