<?php
session_start();
if (!isset($_SESSION['user-id'])){header("Location: ../index.php");}
else{
    unset($_SESSION['user-id']);
    header("Location: ../index.php");
}
?>