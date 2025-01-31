<?php
require_once 'database.php';
require_once 'categories.php';
require_once 'functions.php';

$db = Database::getInstance();
$error = $success = '';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Skot – Personal Wallet</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>