<?php
    /*if($_SESSION['user_email'] !== 'admin@gmail.com'){
            header("Location: ../../user/Login.php");
            exit;
        }*/

require_once "../Conexao.php";
require_once "../funcoes.php";

if(SESSION_STATUS() !== PHP_SESSION_ACTIVE){
    SESSION_START();
}




$id = trim($_GET['id'] ?? '');
$caminho = trim($_GET['caminho']); 
$caminhoRelativo = "../../../..$caminho";

/*MODIFICAR QUANDO PUBLICAR*/
if(file_exists($caminhoRelativo)){
    try{
    $stmt = $sql->prepare("DELETE FROM carro WHERE id_car = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    unlink($caminhoRelativo);

    header("Location: ../../admin/Veiculos.php");
    exit;

    }catch(Exception $e){
                    $_SESSION['erro_cadastro'] = "Erro ao tentar excluir veiculo";
                    $_SESSION['erro'] = true;
                    header("Location: ../../admin/Veiculos.php");
                    exit;
                    }

}else{
        $_SESSION['erro_cadastro'] = "Erro ao tentar excluir veiculo, imagem não encontrada";
        $_SESSION['erro'] = true;
        header("Location: ../../admin/Veiculos.php");
        exit;
}


?>