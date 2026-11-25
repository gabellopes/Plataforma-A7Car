<?php 
$sql = new mysqli("sql202.infinityfree.com", "if0_42899475", "a7carMulti", "if0_42899475_concessionaria");
if ($sql->connect_errno) {
    echo "Falha na conexão: (" . $sql->connect_errno . ") " . $sql->connect_error;
}
?>