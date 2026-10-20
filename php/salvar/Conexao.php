<?php 
$sql = new mysqli("localhost", "root", "", "concessionaria");
if ($sql->connect_errno) {
    echo "Falha na conexão: (" . $sql->connect_errno . ") " . $sql->connect_error;
}
?>