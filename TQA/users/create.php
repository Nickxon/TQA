<?php
require_once '../process/init.php';

if(!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  header('location: /');
}

if (isset($_POST['register'])) {
  $userModel = [
	'role' => strip_tags($_POST['role']),
    'first_name' => strip_tags($_POST['first_name']),
    'last_name' => strip_tags($_POST['last_name']),
    'username' => strip_tags($_POST['username'])
  ];

  $doesUserExist = $database->count('users', ['username' => $_POST['username']]) > 0;
  if ($doesUserExist) {
    $_SESSION['error'] = 'Username already exists';
    return;
  }

  if ($_POST['password'] !== $_POST['password_confirm']) {
    $_SESSION['error'] = 'Password and password confirm does not match.';
    header('location: /users/create.php');
    return;
  }

  $userModel['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);

  if ($database->insert('users', $userModel)) {
    header('location: /dashboard.php');
  }
  else {
    $_SESSION['error'] = 'An unknown error has occurred.';
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
</head>
<body>
<form method="POST">
  <?php
  if(isset($_SESSION['error'])) {
    echo $_SESSION['error'];
    unset($_SESSION['error']);
  }
  ?>
  <div>
    <label for="role">Role</label>
    <select name="role">
      <option disabled selected>Select a role...</option>
      <option value="admin">Admin</option>
      <option value="staff">Staff</option>
    </select>
  </div>
  <div>
    <label for="first_name">First Name</label>
    <input type="text" name="first_name" id="first_name" required/>
  </div>
  <div>
    <label for="last_name">Last Name</label>
    <input type="text" name="last_name" id="last_name" required/>
  </div>
  <div>
    <label for="username">Username</label>
    <input type="text" name="username" id="username" required/>
  </div>
  <div>
    <label for="password">Password</label>
    <input type="password" name="password" id="password" required/>
  </div>
  <div>
    <label for="password_confirm">Password Confirm</label>
    <input type="password" name="password_confirm" id="password_confirm"/>
  </div>
  <button name="register" type="submit">Create</button>
</form>
</body>
</html>
