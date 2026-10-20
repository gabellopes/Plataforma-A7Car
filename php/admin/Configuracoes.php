<?php
    SESSION_START();
    
    if($_SESSION['user_email'] !== 'admin@gmail.com'){
            header("Location: ../user/Login.php");
            exit;
        }
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Clientes</title>
    <link rel="stylesheet" href="../../css/adimin.css">
    <link rel="stylesheet" href="../../css/ADMclientes.css">
</head>
<body>
    <?php include __DIR__ . "/_Aside.php";?>
            <div id="meio">
                <div id="titulo">
                <h1>CONFIGURAÇÕES</h1>
                </div>
            <div id="CE">
              
        </div> <!-- Final VT-->
            
</body>