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
  <h1>Create Product</h1>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
        method="post">
    <div class="form-group">
      <label for="name" class="control-label">Name</label>
      <input type="text" name="name" id="name" class="form-control">
    </div>
    <div class="form-group">
      <label for="description" class="control-label">Description</label>
      <input type="text" id="description" name="description"
             class="form-control">
    </div>
    <div class="form-group">
      <label for="price" class="control-label">Price</label>
      <input type="text" name="price" id="price" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
    <a href="read.php" class="btn btn-info">Back to read products...</a>
  </form>
</div>
<script
  src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="./lib/js/bootstrap.min.js"></script>
</body>
</html>
<?php

if ($_POST) {

  //Include the database connection
  include './config/database.php';

  try {
    $sql = "INSERT INTO products SET name=:name, description=:description, price=:price, created=:created";

    $stmt = $con->prepare($sql);

    //Posted Values
    $name = htmlspecialchars(strip_tags($_POST['name']));
    $description = htmlspecialchars(strip_tags($_POST['description']));
    $price = htmlspecialchars(strip_tags($_POST['price']));

    //Created Date
    $created_date = date('Y-m-d H:i:s');

    //Bind parameters
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':created', $created_date);

    //Execute statement
    if ($stmt->execute()) {
      echo "<p>Recored inserted...</p>";
    }
    else {
      header('Location:read.php');
    }
  } catch (PDOException $exception) {
    die('Error' . $exception->getMessage());
  }
}

?>