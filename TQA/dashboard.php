<?php
require_once 'process/init.php';

if (!isset($_SESSION['user'])) {
  header('location: /');
}

$students = $database->select('students', '*', [
  'ORDER' => [
    $_GET['sort'] ?? 'id' => 'ASC']
  ]
);

$users = $database->select('users', '*');


if(isset($_GET['delete']) && isset($_GET['id']) && $_SESSION['user']['role'] === 'admin') {
  $database->delete('students', ['id' => $_GET['id']]);
}

if(isset($_GET['deleteUser']) && isset($_GET['id']) && $_SESSION['user']['role'] === 'admin') {
  $database->delete('users', ['id' => $_GET['id']]);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>EPCST</title>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');
        .font-family-karla { font-family: karla; }
        .bg-sidebar { background: #3d68ff; }
        .cta-btn { color: #3d68ff; }
        .upgrade-btn { background: #1947ee; }
        .upgrade-btn:hover { background: #0038fd; }
        .active-nav-link { background: #1947ee; }
        .nav-item:hover { background: #1947ee; }
        .account-link:hover { background: #3d68ff; }
    </style>
</style>
</head>


<body class="bg-white font-family-karla flex">

    <div class="w-full flex flex-col h-screen overflow-y-hidden">

     <!-- Desktop Header -->
     <header>
    <!--Nav-->
    <nav aria-label="menu nav" class="bg-gray-800 pt-2 md:pt-1 pb-1 px-1 mt-0 h-auto fixed w-full z-20 top-0">

        <div class="flex flex-wrap items-center">
            <div class="flex flex-shrink md:w-1/3 justify-center md:justify-start text-white">
            <h1 class="text-3xl ml-2 text-white pb-6">Welcome,    <?= $_SESSION['user']['first_name'] . ' (' . $_SESSION['user']['role'] . ') ' ?></h1>
                    <span class="text-xl pl-2"></span>
                </a>
            </div>

            <div class="flex flex-1 md:w-1/3 justify-center md:justify-start text-white px-2">
             
                 
            </div>

            <div class="flex w-full pt-2 content-center justify-between md:w-1/3 md:justify-end">
                <ul class="list-reset flex justify-between flex-1 md:flex-none items-center">
                    <li class="flex-1 md:flex-none md:mr-3">
                        <a class="inline-block py-2 px-4 text-white no-underline" href="/process/logout.php">Logout</a>
                    </li>             
                </ul>
            </div>
        </div>

    </nav>
</header>

        <div class="w-full overflow-x-hidden border-t flex flex-col">
            <main class="w-full flex-grow p-6">

                <div class="w-full mt-12">
                    <p class="text-xl pb-3 flex items-center">
                        <i class="fas fa-user mr-3"></i> Students
                    </p>
                    <div class="bg-white overflow-auto">
                      
                    <button class="px-2 py-2 mt-4  text-white bg-blue-600 rounded-lg hover:bg-blue-900" type="submit" name="login"><a href="/students/create.php">Create Student</a></button>

                        <table class="min-w-full bg-white text-center mt-4">
                            <thead class="bg-gray-800 text-white">
                            <tr>
    <th><a href="?sort=id" >ID</a></th>
    <th><a href="?sort=full_name">Full Name</th>
    <th>Contact Number</th>
    <th><a href="?sort=gender">Gender</a></th>
    <th><a href="?sort=birthdate">Birth Date</a></th>
    <th><a href="?sort=birthplace">Birth Place</a></th>
    <th>Address</th>
    <th>Guardian</th>
    <th>Relationship to Guardian</th>
    <th>Guardian Contact</th>
    <th>Action</th>

  </tr>
  </thead>
  <tbody>
  <?php if (count($students) > 0): ?>
    <?php foreach ($students as $student): ?>
      <tr>
        <td><?= $student['student_id'] ?></td>
        <td><?= $student['full_name'] ?></td>
        <td><?= $student['contact_number'] ?></td>
        <td><?= $student['gender'] ?></td>
        <td><?= $student['birthdate'] ?></td>
        <td><?= $student['birthplace'] ?></td>
        <td><?= $student['address'] ?></td>
        <td><?= $student['guardian'] ?></td>
        <td><?= $student['relation_to_guardian'] ?></td>
        <td><?= $student['guardian_contact'] ?></td>
        <td>
        <button class="px-2 py-2 mt-4 text-white bg-green-600 rounded-lg hover:bg-green-900 " type="submit" name="login"><a href="/students/update.php?id=<?= $student['id']; ?>">Update</a></button>
          <?php if ($_SESSION['user']['role'] === 'admin'): ?>
            <span></span>

            <button class="px-2 py-2 mt-4 text-white bg-red-600 rounded-lg hover:bg-red-900" type="submit" name="login"> <a href="/dashboard.php?id=<?= $student['id']; ?>&delete">Delete</a></button>
          <?php endif; ?>
        </td>

      </tr>
    <?php endforeach; ?>
  <?php else: ?>
    <tr>
      <td colspan="10">No Students</td>
    </tr>
  <?php endif; ?>
  </tbody>
</table>
              </div>
      </div>
</main>
               
<hr>
<?php if($_SESSION['user']['role'] === 'admin'): ?>

<main class="w-full flex-grow p-6">

                <div class="w-full mt-12">
                    <p class="text-xl pb-3 flex items-center m">
                        <i class="fas fa-user mr-3"></i> Users
                    </p>
                    <div class="bg-white overflow-auto">
                    <button class="px-2 py-2 mt-4 mb-4 text-white bg-blue-600 rounded-lg hover:bg-blue-900 flex-end " type="submit"> <a href="/users/create.php">Create User</a></button>

    <table class="min-w-full bg-white text-center">
      <thead class="bg-gray-800 text-white">
        <tr>
          <th >ID</th>
          <th>Role</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Username</th>
          <th>Action</th>
       </tr>
  </thead>
  <tbody>
  <?php foreach($users as $user): ?>
      <?php if($user['id'] !== $_SESSION['user']['id']): ?>
      <tr>
        <td><?= $user['id']; ?></td>
        <td><?= $user['role']; ?></td>
        <td><?= $user['first_name']; ?></td>
        <td><?= $user['last_name']; ?></td>
        <td><?= $user['username']; ?></td>
        <td>
        <button class="px-2 py-2 mt-4 text-white bg-green-600 rounded-lg hover:bg-green-900" type="submit" name="login"><a href="/users/update.php?id=<?= $user['id'] ?>">Update</a></button>
        <button class="px-2 py-2 mt-4 text-white bg-red-600 rounded-lg hover:bg-red-900" type="submit" name="login"> <a href="/dashboard.php?id=<?= $user['id'] ?>&deleteUser">Delete</a> </button>
        </td>
      </tr>
    <?php endif; ?>
    <?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>
              </div>
      </div>
</main>
<table>
  <thead>
    
  </thead>
  <tbody>
    
</div>
</div>

<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
    <!-- ChartJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>

    <script>
        var chartOne = document.getElementById('chartOne');
        var myChart = new Chart(chartOne, {
            type: 'bar',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        var chartTwo = document.getElementById('chartTwo');
        var myLineChart = new Chart(chartTwo, {
            type: 'line',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
</body>
</html>
