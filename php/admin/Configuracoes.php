<?php
    SESSION_START();
    
    if($_SESSION['user_email'] !== 'admin@gmail.com'){
             header("Location: ../user/Login.php");
            exit;
        }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Configurações</title>
    <link rel="stylesheet" href="../../css/adimin.css">
</head>
<body>
    <?php include __DIR__ . "/_Aside.php"; ?>
    
</body>
</html>