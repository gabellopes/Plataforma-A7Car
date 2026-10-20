<?php
SESSION_START();
    if($_SESSION['user_email'] !== 'admin@gmail.com'){
            header("Location: ../../user/Login.php");
            exit;
        }

include __DIR__ . "../../Conexao.php";



$id = trim($_GET['id'] ?? '');
$caminho = trim($_GET['caminho']); 
$caminhoRelativo = "../../../..$caminho";



/*MODIFICAR QUANDO PUBLICAR*/
if(file_exists($caminhoRelativo)){
    try{ 
    $stmt = $sql->prepare("DELETE FROM colaborador WHERE id_col = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    unlink($caminhoRelativo);

    header("Location: ../../admin/Colaboradores.php");
    exit;
    }catch(Exception $e){
                    $_SESSION['erro_cadastro'] = "Erro ao tentar excluir colaborador";
                    $_SESSION['erro'] = true;
                    header("Location: ../../admin/Colaboradores.php");
                    }
}else{
        $_SESSION['erro_cadastro'] = "Erro ao tentar excluir colaborador, imagem não encontrada";
        $_SESSION['erro'] = true;
        header("Location: ../../admin/Veiculos.php");
        exit;
}

?>