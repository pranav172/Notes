
<?php
// INSERT INTO `thought` (`sno`, `Thought`, `description`, `tstamp`) VALUES (NULL, 'sleepy', 'I haven\'t sleep for 2 days!', current_timestamp());
$insert = false;
//connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";
//create a connection 
$conn = mysqli_connect($servername, $username, $password, $database);
// Die if connection was not successful
if (!$conn){ //error handling
    die("Sorry we failed to connect: ". mysqli_connect_error());
}
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  $title = $_POST["title"]; //getting the value using $_POST method
  $description =  $_POST["desc"];
  
  //Sql query to be executed
  $sql = "INSERT INTO `thought` ( `Thought`, `description`) VALUES ( '$title', '$description')";
  
  //add a new record to the trip table in the database
  $result = mysqli_query($conn, $sql);
  if($result){
      $insert = true;
  }else{
      echo "The record was not created successfully". mysqli_error($conn);
  }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thought Capture - Capture your thought</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.5/css/dataTables.dataTables.min.css">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Thought Capture</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Contact Us</a>
              </li>
              
            </ul>
            <form class="d-flex" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
          </div>
        </div>
      </nav>

<?php
if ($insert){
  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success!</strong> Your thought has been inserted successfully
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
}
?>

<div class="container my-3">

        <h2>Add a Thought</h2>
        <form action = "/crud/index.php" method = "post">
            <div class="mb-3">
              <label for="title" class="form-label">Thought Title</label>
              <input type="text" class="form-control" id="title" name = "title" aria-describedby="emailHelp">
            </div>

            <div class="mb-3">
                <label for="desc" class="form-label">Thought description</label>
                <textarea class="form-control" id="desc" name = "desc" rows="3"></textarea>
              </div>
            <button type="submit" class="btn btn-primary">Add Note</button>
          </form>
       </div>
  <div class="container" my-4>
           
    <table class="table" id = "myTable">
      <thead>
      <tr>
      <th scope="col">S.no</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Actions</th>
    </tr>
    </thead>
  <tbody>
  <?php
    $sql = "SELECT * FROM `thought`";
    $result = mysqli_query($conn, $sql);
    $sno = 0;
    while($row = mysqli_fetch_assoc($result)){
    // $row = mysqli_fetch_assoc($result); //yeh sirf next row deta hai toh we'll use loop
    // echo var_dump($row);
    $sno = $sno + 1;
    echo  "<tr>
    <th scope='row'>" . $sno . "</th>
    <td >". $row['Thought'] . "</td>
    <td >" . $row['description'] . "</td>
    <td><a href='/edit'>Edit</a> <a href='/del'>Delete</a></td>
    </tr>";
    
  }
  ?>
  
  </tbody>
  </table>
</div>
<hr>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src = "//cdn.datatables.net/2.0.5/js/dataTables.min.js" > </script>
    <script>$(document).ready( function () {$('#myTable').DataTable();} );</script>
    
  </body>
</html>