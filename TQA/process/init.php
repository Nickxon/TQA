<?php
  // We need this to keep track of if they're logged in or not.
  session_start();

  require_once "Medoo.php";
  
  use Medoo\Medoo;
  
  $database = new Medoo([
    'type' => 'mysql',
    'host' => 'localhost',
    'database' => 'student_registration',
    'username' => 'root',
    'password' => '',
  ]);