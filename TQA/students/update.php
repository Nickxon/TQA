<?php
require_once '../process/init.php';

if (!isset($_SESSION['user'])) {
  header('location: /');
}

$user = $database->get('students', '*', ['id' => $_GET['id']]);

if(isset($_POST['update'])) {
  $saveModel = [];

  foreach($_POST as $key => $value) {
    if($key === 'update') {
      continue;
    }

    $saveModel[$key] = $value;
  }

  $idAlreadyExists = $database->count('students', ['id[!]' => $saveModel['id']]) > 0;
  if($idAlreadyExists) {
    $_SESSION['error'] = 'Student ID already exists.';
    return;
  }

  $database->update('students', $saveModel);

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
    <input type="text" name="student_id" id="student_id" required value="<?= $user['id'] ?>"/>
  </div>
  <div>
    <label for="full_name">Full Name</label>
    <input type="text" name="full_name" id="full_name" value="<?= $user['full_name'] ?>" required/>
  </div>
  <div>
    <label for="contact_number">Contact Number</label>
    <input type="text" name="contact_number" id="contact_number" value="<?= $user['contact_number'] ?>" required/>
  </div>
  <div>
    <label for="gender">Gender</label>
    <select name="gender" required>
      <option disabled selected>Select a gender...</option>
      <option value="Male" <?= $user['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
      <option value="Female"  <?= $user['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
    </select>
  </div>
  <div>
    <label for="birthdate">Birth Date</label>
    <input type="date" name="birthdate" id="birthdate" value="<?= $user['birthdate'] ?>" required/>
  </div>
  <div>
    <label for="birthplace">Birth Place</label>
    <input type="text" name="birthplace" id="birthplace"value="<?= $user['birthplace'] ?>" required/>
  </div>
  <div>
    <label for="address">Address</label>
    <input type="text" name="address" id="address" value="<?= $user['address'] ?>" required/>
  </div>
  <div>
    <label for="guardian">Guardian</label>
    <input type="text" name="guardian" id="guardian" value="<?= $user['guardian'] ?>"required/>
  </div>
  <div>
    <label for="relation_to_guardian">relation_to_guardian</label>
    <input type="text" name="relation_to_guardian" id="relation_to_guardian" value="<?= $user['relation_to_guardian'] ?>" required/>
  </div>
  <div>
    <label for="guardian_contact">Guardian Contact</label>
    <input type="text" name="guardian_contact" id="guardian_contact" value="<?= $user['guardian_contact'] ?>" required/>
  </div>
  <button name="update" type="submit">Save</button>
</form>
</body>
</html>
