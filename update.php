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
  <h2>Update Record</h2>
  <?php
  $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
  //include database connection file
  include './config/database.php';
  $sql = "SELECT name,description,price FROM products WHERE id=$id";
  $stmt = $con->prepare($sql);
  $stmt->execute();
  $res = $stmt->rowCount();
  ?>
  <?php if ($res > 0): ?>
    <form
      action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>"
      method="post">
      <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
        <div class="form-group">
          <label for="name" class="control-label">Name</label>
          <input type="text" name="name" id="name" class="form-control"
                 value="<?php echo $row['name'] ?>">
        </div>
        <div class="form-group">
          <label for="description" class="control-label">Description</label>
          <input type="text" id="description" name="description"
                 class="form-control" value="<?php echo $row['description'] ?>">
        </div>
        <div class="form-group">
          <label for="price" class="control-label">Price</label>
          <input type="text" name="price" id="price" class="form-control"
                 value="<?php echo $row['price']; ?>">
        </div>
      <?php endwhile; ?>
      <button type=" submit" class="btn btn-primary">Save</button>
      <a href="read.php" class="btn btn-info">Back to read products...</a>
    </form>
  <?php endif; ?>
</div>
</body>
</html>
<?php

if ($_POST) {
  try {
    $sql_update = "UPDATE products SET name=:name, description=:description, price=:price WHERE id=:id";

    $stmt_update = $con->prepare($sql_update);

    //Posted Values
    $name = htmlspecialchars(strip_tags($_POST['name']));
    $description = htmlspecialchars(strip_tags($_POST['description']));
    $price = htmlspecialchars(strip_tags($_POST['price']));

    //Bind parameters
    $stmt_update->bindParam(':name', $name);
    $stmt_update->bindParam(':description', $description);
    $stmt_update->bindParam(':price', $price);
    $stmt_update->bindParam(':id', $id);

    //Execute statement
    if ($stmt_update->execute()) {
      header('Location:read.php');
    }
    else {
     echo 'Unable to update';
    }
  } catch (PDOException $exception) {
    die('Error' . $exception->getMessage());
  }
}

?>