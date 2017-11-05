<!DOCTYPE html>
<html lang="en">
    <head>
      <meta charset="UTF-8"></meta>
      <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
      <link rel="icon" href="/favicon.ico" type="image/x-icon">
      <link href="assets/css/styles.css" rel="stylesheet">
      <script src="assets/javascript/javascript.js"></script>
      <?php
        include 'connect.php';
        include 'function.php';
        if(!loggedin()) {
          header('location: index.php');
        }
      ?>
      
      <script type="text/javascript">
      function formReset()
      {
         document.getElementById("addform").reset();
      }
      function formSubmit()
      {
         document.getElementById("addform").submit();
      }
      function addImg()
      {
        if (document.getElementsByName("img[]").length >= 10)
        {
          alert("Too many files.");
          return;
        }
      
        var input = document.createElement('input');   
        var br = document.createElement('br');
        input.setAttribute('type','file');
        input.setAttribute('name','img[]');   
        document.getElementById("lstimg").appendChild(br);
        document.getElementById("lstimg").appendChild(input);
      }
      
      </script>
    </head>
    <body>
      <div id="header">
        <div class="logo">
          <a href="home.php" title="Home">
            <img src="assets/images/header-logo.png" alt="Logo Banner" />
          </a>
        </div>
        <div class="menu-bar">
          <a class="logout" href="index.php" onclick="session_destory()"        title="Sign Out">Sign Out</a>
          <div class="dropdown">
            <button onclick="myFunction()" class="dropbtn">            
              <?php
                  if(loggedin()){
                      echo getuser();
                  }
              ?>
            </button>
            <div id="myDropdown" class="dropdown-content">
              <a href="userportal.php" title="User Portal">User Portal</a>
              <a href="accountinfo.php" title="Account Info">Account Info</a>
            </div>
          </div>
        </div>
        <form id="addform" method="post" name="addform" enctype="multipart/form-data">
        <div class="page" id="add-incident">
          <h1>File Incident</h1>
          <div class="crew-information">
            <h2>Crew Information</h2>
            <label>Crew ID :</label>
            <input type="text" name="crew-id" id="crew-id" placeholder="(1234)"/>
            <label>Supervisor name :</label>
            <input type="text" name="supervisor" id="supervisor" placeholder="(John Smith)"/>
            <label>Date found :</label>
            <input type="text" name="date" id="date" placeholder="(DD/MM/YYYY)"/>
            <label>Scale of cleanup effort :</label>
            <select name="cleaup" class="list" id="cleaup"><option value="not-set">(Not-set)</option><option value="Minor">Minor: Under 1 hour</option><option  value="Normal">Normal: 1-2 hours</option><option value="Major">Major: 2-3 hours </option><option value="Extensive">Extensive: 3-4 hours</option><option value="Monolithic">Monolithic: 4+ hours</option></select>
          </div>
          <div class="graffiti-information">
            <h2>Graffiti Information</h2>
            <label>Street address or nearest cross street of vandalism :</label>
            <input type="text" name="street-address" id="street-address" placeholder="(5555 Parkington Ave, Chester, AU 92910)"/>
            <label>Type of building or structure :</label>
            <select name="building" class="list" id="type-of-building"><option value="not-set">(Not-set)</option><option value="Apartment">Apartment</option><option value="Industrial">Industrial Zone</option><option value="Office">Office</option><option     value="Residential">Residence</option><option value="Vehicle">Vehicle</option></select>
            <label>GPS Coordinates <b>(required)</b> :</label>
            <input type="text" name="gps-coordinates" id="gps-coordinates" placeholder="(55.1234,-01.2893)"/>
            <label>Moniker :</label>
            <input type="text" name="moniker" id="moniker" placeholder="(cribz)"/>
          </div>
          <div class="image-upload">
            <h2>Image Upload</h2>
            <input type="button" value="Add Another Image" onclick="addImg()"/>
            <div id="lstimg"> 
            <input type="file" name="img[]" />
            </div>
            <p><b>NOTE:</b> no more than 10 images per submission. If there are different monikers, please report them with the same address/GPS coordinates but as different/individual incidents.</p>
          </div>
          <div class="options">
            <input type="button" value="Cancel" id="cancel" onclick="formReset()" />
            <input type="button" value="Submit" name="add_btn" onclick="formSubmit()" />
          </div>        
          <div class="feedback">
          <?php
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           
            $username = getuser();
            $crew = $_POST['crew-id'];
            $supervisor = $_POST['supervisor'];
            $fdate = $_POST['date'];
            $cleaup = $_POST['cleaup'];
            $addr = $_POST['street-address'];
            $building = $_POST['building'];
            $gps = $_POST['gps-coordinates'];
            $moniker = $_POST['moniker'];
            $image = 0;
            $imgerr = "";
            
            $imgfile = $_FILES['img'];

            if (!empty($imgfile) && count($imgfile['name']) > 0) {
              $cnt = count($imgfile['name']);

              for ($i = 0; $i < $cnt; $i++) {
                $tp = $imgfile['type'][$i];
                $err = $imgfile['error'][$i];
                $nm = $imgfile['name'][$i]; 
                
                if ($nm == "") {
                  continue;
                }
                else if ($err > 0) {  
                  $imgerr = "Error: ".$err;
                  break;
                } 
                else if ($tp != "image/gif" &&
                  $tp != "image/jpg" &&
                  $tp != "image/jpeg" &&
                  $tp != "image/png") {  
                  $imgerr = "Invalid file type, support jpg/png";
                  break;
                }
                $image = $image + 1;
              }
            }               
    
            
            if(empty($username) or empty($crew) or empty($supervisor) or
               empty($fdate) or empty($cleaup) or empty($addr) or
               empty($building) or empty($gps) or empty($moniker)) {
              echo "*One or more fields are empty, please try again";
            }
            else if ($imgerr != "") {
              echo $imgerr;
            }
            else {
              
               if (!mysql_query("INSERT INTO incidents VALUES (NULL, '$crew', '$supervisor', '$fdate', '$cleaup', '$addr', '$building', '$username', '$gps', '$moniker', $image)")) {  
                  echo mysql_error();
               }
               else {
                  
                 $query = mysql_query("SELECT LAST_INSERT_ID()");
                 $run = mysql_fetch_array($query);
                 $id = $run[0];    
                     
                 for ($i = 0; $i < $cnt; $i++) {
                   if ( $imgfile["name"][$i] != "") {
                     move_uploaded_file($imgfile["tmp_name"][$i],
                       "./$id" . "_" . $imgfile["name"][$i]);
                   }
                 }
          
                 echo "Add succeeded! $id";
               }
            
            
            }  
          }
          
            
          ?>
          </div>
        </div>   
        </form>
        
        <!-- Footer (for copyright and what not) -->
      </div>
    </body>
    <footer class="footer">
      <div id="company-name"><img src="assets/images/icon.png" alt="Utah Icon" />Utah Technologies</div>
      <div id="copyright">@Copyright 2016</div>
    </footer>
</html>