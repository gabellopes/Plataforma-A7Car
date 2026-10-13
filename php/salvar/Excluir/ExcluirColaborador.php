<?php
SESSION_START();
    if($_SESSION['user_email'] !== 'admin@gmail.com'){
            header("Location: ../../user/Login.php");
            exit;
        }

include __DIR__ . "../../Conexao.php";



$id = trim($_GET['id'] ?? '');






try{ 
$stmt = $sql->prepare("DELETE FROM colaborador WHERE id_col = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: ../../admin/Colaboradores.php");
exit;
}catch(Exception $e){
                $_SESSION['erro_cadastro'] = "Erro ao tentar excluir colaborador";
                $_SESSION['erro'] = true;
                header("Location: ../../admin/Colaboradores.php");
                }

?>