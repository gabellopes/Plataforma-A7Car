<?php
    SESSION_START();
    
    if($_SESSION['user_email'] !== 'admin@gmail.com'){
             header("Location: ../user/Login.php");
            exit;
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulações</title>
</head>
<body>
      <?php include __DIR__ . "/_Aside.php"; ?>
      <h1>SIMULAÇÕES</h1>
</body>
</html>