<?php
include "funcoes.php";
include "Conexao.php";

//NECESSARIO - VALIDAÇÃO DE LOGIN USER

$idCar = trim($_GET['id']);
$idUsu = trim($_SESSION['user_id']);
$status = trim($_GET['status']);

echo "id do usuario" . "->" . $idUsu;

    if($status == 0){

        $stmt = $sql->prepare("INSERT INTO favorito (id_usu, id_car) VALUES (?, ?) ");
        $stmt->bind_param("ii", $idUsu, $idCar);
        $stmt->execute();
        echo "Sucesso";


    }else{
        $_SESSION['erro_cadastro'] = "Erro ao favoritar";
        $_SESSION['erro'] = true;
        header("Location: ../user/catalogo.php");
    }

/*CREATE TABLE IF NOT EXISTS `favorito` (
  `id_fav` int NOT NULL AUTO_INCREMENT,
  `id_usu` int NOT NULL,
  `id_car` int NOT NULL,
  PRIMARY KEY (`id_fav`),
  KEY `id_usu` (`id_usu`),
  KEY `id_car` (`id_car`),
  CONSTRAINT `favorito_ibfk_1` FOREIGN KEY (`id_usu`) REFERENCES `usuario` (`id_usu`),
  CONSTRAINT `favorito_ibfk_2` FOREIGN KEY (`id_car`) REFERENCES `carro` (`id_car`)
) */
?>