
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

    if( $link != ""){
    header("$link");
    exit;}else{
    return $resultado;
    }
  
}
}

function verificarImagem($imagem, $pasta, $link, $caminho){
    if (!isset($imagem) || $imagem['error'] === UPLOAD_ERR_NO_FILE) {
        $_SESSION['erro_cadastro'] = "Nenhuma imagem foi enviada.";
        $_SESSION['erro'] = true;
        header("$link");
        exit;
    }

    $arquivo = $imagem;
    
    if ($arquivo['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['erro_cadastro'] = "Erro no upload do arquivo.";
        $_SESSION['erro'] = true;
        header("$link");
        exit;
    }

    if ($arquivo['size'] > 5 * 1024 * 1024) {
        $_SESSION['erro_cadastro'] = "A imagem deve ter no máximo 5 MB.";
        $_SESSION['erro'] = true;
        header("$link");
        exit;
    }
    
    $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
    if (!in_array($extensao, ['jpg', 'jpeg', 'png', 'webp'])) {
        $_SESSION['erro_cadastro'] = "Formato não permitido. Apenas JPG, JPEG, PNG ou WEBP.";
        $_SESSION['erro'] = true;
        header("$link");
        exit;
    }
    
    $pastaDestino = $caminho . $pasta . '/';
    if (!is_dir($pastaDestino)) {
        mkdir($pastaDestino, 0755, true);
    }
    
    $nomeNovo = uniqid('img_') . '.' . $extensao;
    $caminhoCompleto = $pastaDestino . $nomeNovo;
    
    if (!move_uploaded_file($arquivo['tmp_name'], $caminhoCompleto)) {
        $_SESSION['erro_cadastro'] = "Erro ao salvar a imagem no servidor.";
        $_SESSION['erro'] = true;
        header("$link");
        exit;
    }

    return '/a7car/img/uploads/' . $pasta . '/' . $nomeNovo;
}
?>