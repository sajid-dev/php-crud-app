<?php

include './config/database.php';

try {
  $id = isset($_GET['id']) ? $_GET['id'] : die('Error: Record id not found');

  $sql = "DELETE FROM products WHERE id=$id";
  $stmt = $con->prepare($sql);
  if ($stmt->execute()) {
    header('Location:read.php');
  }
  else {
    echo "unable to delete";
  }
} catch (PDOException $exception) {
  echo $exception->getMessage();
}