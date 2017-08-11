<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Create Product</title>
  <link href="./lib/css/bootstrap.min.css" rel="stylesheet">
  <script
    src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<body>
<div class="container">
  <h1>Read Products</h1>
  <?php
  //Include the database connection
  include './config/database.php';

  $action = isset($_GET['action']) ? $_GET['action'] : "";

  // if it was redirected from delete.php
  if ($action == 'deleted') {
    echo "<div class='alert alert-success'>Record was deleted.</div>";
  }

  $sql = "SELECT id,name,description,price FROM products ORDER BY id";
  $stmt = $con->prepare($sql);

  //Execute statement
  $stmt->execute();

  $res = $stmt->rowCount();


  // link to create record form
  echo "<a href='create.php' class='btn btn-primary m-b-1em'>Create New Product</a>";

  if ($res > 0) {
    echo <<<EOD
      <br>
<table class="table">
<thead>
<tr>
<th>Id</th>
<th>Name</th>
<th>Description</th>
<th>Price</th>
<th>Action</th>
</thead>
</tr>
EOD;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      echo "<tbody><tr>";
      echo "<td>{$id}</td>";
      echo "<td>{$name}</td>";
      echo "<td>{$description}</td>";
      echo "<td>{$price}</td>";
      echo "<td>
<a href='read_one.php?id={$id}' class='btn btn-success btn-sm'>Read</a> | 
<a href='update.php?id={$id}' class='btn btn-warning btn-sm'>Update</a> | 
<a onclick='delete_rec({$id})' class='btn btn-danger btn-sm' data-toggle=\"modal\" data-target=\"#myModal\">Delete</a> 
</td>";
      echo "</tr></tbody>";
    }
  }
  ?>
</div>
<script
  src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="./lib/js/bootstrap.min.js"></script>
<script type='text/javascript'>
  function delete_rec(id) {
    var answer = confirm('Are you sure?');
    if (answer) {
      // if user clicked ok,
      // pass the id to delete.php and execute the delete query
      window.location = 'delete.php?id=' + id;
    }
  }
</script>
</body>
</html>
