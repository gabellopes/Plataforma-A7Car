<?php

if($_SESSION['user_email'] !== 'admin@gmail.com'){
            header("Location: ../../user/Login.php");
            exit;
        }

?>