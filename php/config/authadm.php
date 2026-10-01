<?php


if(SESSION_STATUS()  === PHP_SESSION_NONE){
    SESSION_START();
}
if($_SESSION['user_email'] !== 'admin@gmail.com'){
            header("Location: ../../user/Login.php");
            exit;
        }

?>