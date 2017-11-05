<?php
  $dbhost = 'localhost';
  $dbuser = 'root';
  $dbpassword = '';
  $dbname = 'orders';
  $link = mysql_connect($dbhost, $dbuser, $dbpassword);
  echo "success in database connection.";

  // select the specific database name we want to access.
  if (!mysql_select_db($dbname)) die(mysql_error());
    echo "success in database selection.";
  // add a table to the selected database
  $result = "CREATE TABLE IF NOT EXISTS users
  (
  id int auto_increment primary key,
  name varchar(50),
  username varchar(50),
  email varchar(100),
  password varchar(50),
  crewtype varchar(50),
  accessid varchar(50)
)";
  if (mysql_query($result)) {
     echo "TABLE created.";
  }
  else {
     echo "Error in CREATE TABLE.";
  }

  // select the specific database name we want to access.
  if (!mysql_select_db($dbname)) die(mysql_error());
    echo "success in database selection.";
  // add a table to the selected database
  $resultTwo = "CREATE TABLE IF NOT EXISTS incidents
  (
  id int auto_increment primary key,
  crewid varchar(10),
  supervisor varchar(50),
  datefound varchar(12),
  cleanup varchar(50),
  address varchar(50),
  building varchar(50),
  submitter varchar(50) references users(username),
  gps varchar(50),
  moniker varchar(50),
  images int
)";

  if (mysql_query($resultTwo)) {
     echo "TABLE Two created.";
  }
  else {
     echo "Error in CREATE TABLE TWO.";
  }
?>
