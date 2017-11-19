<!DOCTYPE html>
<html lang="en">
    <head>
      <meta charset="UTF-8"></meta>
      <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
      <link rel="icon" href="/favicon.ico" type="image/x-icon">
      <link href="assets/CSS/styles.css" rel="stylesheet"></link>
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
        <div class="page" id="account-info">
                
        <?php
          $msg = "";    
          $username = getuser();
          if (isset($_POST['up_button'])) {            
            $email = $_POST['email'];
            $name = $_POST['name'];
            $password = $_POST['password'];
            $password_confirm = $_POST['password-confirm'];
            if(empty($email) or empty($name) or empty($password) or empty($password_confirm)){
              $msg = "*One or more fields are empty, please try again";
            }
            else if ($password != $password_confirm) {
              $msg = '*Passwords do not match';
            }
            else {
              $query = mysql_query("UPDATE users SET name='$name',email='$email',password='$password' WHERE username='$username'");
              if ($query)
                $msg = "Update Succeeded!";
              else
                $msg = mysql_error();
            }
          }        
        
          $query = mysql_query("SELECT name,email FROM users WHERE username='$username'");
          $run = mysql_fetch_array($query);
          $name = $run[0];
          $email= $run[1];
          
         ?> 
              
          <h1>Account Info</h1>
          <div class="user-information">
            <h2>User Information</h2>
            <label>Username :</label>
            <p> <?php echo $username;  ?>  </p> 
            <label>Name :</label>
            <p><?php echo $name;  ?> </p>
            <label>Email :</label>
            <p><?php echo $email;  ?> </p>
          </div>
          <form id="up-form" method="post" name="upform">
          <div class="update-information">
            <h2>Update Information</h2>
            <label>Name :</label>
            <input type="text" name="name" id="name" placeholder=""/>
            <label>Email :</label>
            <input type="email" name="email" id="email" placeholder=""/>
            <label>Password :</label>
            <input type="password" name="password" id="password" placeholder=""/>
            <label>Confirm Password :</label>
            <input type="password" name="password-confirm" id="password-confirm" placeholder=""/>
            <div class="options">
              <input type="submit" name="up_button" value="Update" id="submit" />
            </div>
            <div class="feedback">
            <?php  echo $msg; ?>
            </div>
          </div>
          </form>
        </div>
      </div>
    </body>
    <footer class="footer">
      <div id="company-name"><img src="assets/images/icon.png" alt="Utah Icon" />Utah Technologies</div>
      <div id="copyright">@Copyright 2016</div>
    </footer>
</html>
