<?php
if(!isset($mensagemWhatsApp)){
    $mensagemWhatsApp = " ";
}
$telefone = "5511973320504";

$urlWhatsApp = "https://wa.me/" . $telefone . "?text=" . urlencode($mensagemWhatsApp);

?>