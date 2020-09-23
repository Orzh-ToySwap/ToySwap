<?php
    session_start();
    session_destroy();
    $_SESSION['email']=null;
    header('Location: /ToySwap/html/pages/home/home.php') ;
?>