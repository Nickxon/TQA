<?php
require_once '../process/init.php';

// Check if they're NOT logged in because they're not allowed here if they aren't.
if (!isset($_SESSION['user'])) {
  header('location: /');
}

// Check if we have received a post request of REGISTER.
if(isset($_POST['register'])) {
  // Let's go ahead and map all those values to an array so we can save it with ease.
  $saveModel = [];

  // Loop through the $_POST global variable and get the KEY and VALUE pairs.
  // Assign it to the save model
  foreach($_POST as $key => $value) {
    // Register will cause an error as it's not part of the columns in the database. This is just an identifer.
    if($key === 'register') {
      continue;
    }

    $saveModel[$key] = $value;
  }

  // Check if the ID passed in already exists, summon an error if so.
  $idAlreadyExists = $database->count('students', ['id' => $saveModel['id']]) > 0;
  if($idAlreadyExists) {
    $_SESSION['error'] = 'Student ID already exists.';
    return;
  }

  // Insert otherwise and navigate to the dashboard.
  $database->insert('students', $saveModel);

  header('location: /dashboard.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create a Student</title>
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
    <label for="student_id">ID</label>
    <input type="text" name="student_id" id="student_id" required/>
  </div>
  <div>
    <label for="full_name">Full Name</label>
    <input type="text" name="full_name" id="full_name" required/>
  </div>
  <div>
    <label for="contact_number">Contact Number</label>
    <input type="text" name="contact_number" id="contact_number" required/>
  </div>
  <div>
    <label for="gender">Gender</label>
    <select name="gender" required>
      <option disabled default>Select a gender...</option>
      <option value="Male">Male</option>
      <option value="Female">Female</option>
    </select>
  </div>
  <div>
    <label for="birthdate">Birth Date</label>
    <input type="date" name="birthdate" id="birthdate" required/>
  </div>
  <div>
    <label for="birthplace">Birth Place</label>
    <input type="text" name="birthplace" id="birthplace" required/>
  </div>
  <div>
    <label for="address">Address</label>
    <input type="text" name="address" id="address" required/>
  </div>
  <div>
    <label for="guardian">Guardian</label>
    <input type="text" name="guardian" id="guardian" required/>
  </div>
  <div>
    <label for="relation_to_guardian">Relationship to Guardian</label>
    <input type="text" name="relation_to_guardian" id="relation_to_guardian" required/>
  </div>
  
  <div>
    <label for="guardian_contact">Guardian Contact</label>
    <input type="text" name="guardian_contact" id="guardian_contact" required/>
  </div>
  <button name="register" type="submit">Create</button>
</form>
</body>
</html>
