<?php
include_once '../db/connect.php';
include_once '../includes/header.php';
session_start();
echo $_GET['n'];
$sql="DELETE FROM `konta` WHERE `id`='". $_GET['n']."'";
$rezultat=$mysqli->query($sql);
header("Location: paneladmin.php");
?>