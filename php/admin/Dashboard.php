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
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../../css/adimin.css">
</head>
<body>
<?php include __DIR__ . "/_Aside.php"; ?>
    <div id="DM1">
        <div id="DSM">
            <div id="DT"><h1>Dashboard</h1></div>
            <?php

            include_once "../salvar/Conexao.php";

                    $stmt = $sql->prepare("SELECT COUNT(id_car) FROM carro WHERE status_car = 0");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $numcar = $result->fetch_assoc();

                    $stmt = $sql->prepare("SELECT COUNT(id_cli) FROM cliente");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $numcli = $result->fetch_assoc();

                    $stmt = $sql->prepare("SELECT COUNT(id_col) FROM colaborador");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $numcol = $result->fetch_assoc();

                    $stmt = $sql->prepare("SELECT COUNT(id_ven) FROM vendas");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $numven = $result->fetch_assoc();

                    $stmt = $sql->prepare("SELECT COUNT(id_simu) FROM simulacao");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $numsimu = $result->fetch_assoc();
            echo"
            <div class='DI'>
                <br><br><br>
                <div class='DIE'>
                    <img src='' alt=''>
                    <h1>Veículos</h1>
                    <p>".$numcar['COUNT(id_car)']."</p>
                </div>
                <div class='DIE'>
                    <img src='' alt=''>
                    <h1>Clientes</h1>
                    <p>".$numcli['COUNT(id_cli)']."</p>
                </div>
                <div class='DIE'>
                    <img src='' alt=''>
                    <h1>Colaboradores</h1>
                    <p>".$numcol['COUNT(id_col)']."</p>
                </div>
                 <div class='DIE'>
                    <img src='' alt=''>
                    <h1>Vendidos</h1>
                    <p>".$numven['COUNT(id_ven)']."</p>
                </div>
                 <div class='DIE'>
                    <img src='' alt=''>
                    <h1>Simuações</h1>
                    <p>".$numsimu['COUNT(id_simu)']."</p>
                </div>
             ";?>   
            </div><!-- final dos elementos-->

            <div id="DI2">
                <div class="DIE2">
                    <p></p>
                </div>
                <div class="DIE2">
                    <p></p>
                </div>
            </div>

        </div>
    </div>
</body>
</html>