
<?php
Session_start();
function verifica($atributo, $coluna, $variavel, $mensagem, $link){
include __DIR__ . "/Conexao.php";
$verifica = $sql->prepare("SELECT $atributo FROM $coluna WHERE $atributo = ?");
$verifica->bind_param("s", $variavel);
$verifica->execute();
$resultado = $verifica->get_result();

if ($resultado->num_rows > 0) {
    $_SESSION['erro_cadastro'] = "$mensagem";
    $_SESSION['erro'] = true;
    header("$link");
    exit;
}
}
function select($atributo, $coluna, $variavel){
    include __DIR__ . "/Conexao.php";
    $busca = $sql->prepare("SELECT * FROM $coluna WHERE $atributo = ?");
    $busca->bind_param("s", $variavel);
    $busca->execute();
    $resultado = $busca->get_result();
    return $resultado;
}

?>