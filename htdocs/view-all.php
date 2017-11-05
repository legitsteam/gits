<!DOCTYPE html>
<html lang="en">
    <head>
      <meta charset="UTF-8"></meta>
      <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
      <link rel="icon" href="/favicon.ico" type="image/x-icon">
      <link href="assets/css/styles.css" rel="stylesheet"></link>
      <script src="assets/javascript/javascript.js"></script>
      <?php
        include 'connect.php';
        include 'function.php';
        if(!loggedin()) {
          header('location: index.php');
        }
      ?>
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
        <div class="page" id="all-incidents">
          <h1>All Incidents</h1>
          <table id="tablenote" class="table table-striped table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" width="100%">
            <thead>
                <tr>
                    <th></th>
                    <th>Submitter</th>
                    <th>Crew ID</th>
                    <th>Supervisor's Name</th>
                    <th>City</th>
                    <th>Zipcode</th>
                    <th>Date Found</th>
                    <th>Clean Up</th>
                    <th>Moniker</th>
                    <th>Images</th>
                </tr>
            </thead>
            <tbody>
             <?php
               $result = mysql_query("select * from incidents");
               while($row = mysql_fetch_array($result)){
                 echo "<tr><td>".$row['id'];
                 echo "</td><td>".$row['submitter'];
                 echo "</td><td>".$row['crewid'];
                 echo "</td><td>".$row['supervisor'];    
                 echo "</td><td>city";          
                 echo "</td><td>zip"; 
                 echo "</td><td>".$row['datefound'];      
                 echo "</td><td>".$row['cleanup'];
                 echo "</td><td>".$row['moniker'];
                 echo "</td><td><a href=#>".$row['images'];
                 echo "</a></td></tr>";
               }                  

             ?>
            </tbody>
          </table>
          <input type="button" value="Download full .csv" id="csv-download" onclick=""/>
        </div>
        <!-- Footer (for copyright and what not) -->
      </div>
    </body>
    <footer class="footer">
      <div id="company-name"><img src="assets/images/icon.png" alt="Utah Icon" />Utah Technologies</div>
      <div id="copyright">@Copyright 2016</div>
    </footer>
</html>