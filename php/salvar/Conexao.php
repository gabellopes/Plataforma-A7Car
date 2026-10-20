<?php 
$sql = new mysqli("localhost", "root", "", "concessionaria");
if ($sql->connect_errno) {
    echo "Falha na conexão: (" . $sql->connect_errno . ") " . $sql->connect_error;
}
//Proteção Csp
//header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline';");
//header("Content-Security-Policy: default-src 'self'; script-src 'self';");


?>
