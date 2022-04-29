<?php
include_once '../db/connect.php';
include_once '../includes/header.php';
session_start();

$i=$_POST['edit'];

$login=$_POST['login'.$i];
$klasa=$_POST['klasa'.$i];
$grupa=$_POST['grupa'.$i];
$imie=$_POST['imie'.$i];
$nazwisko=$_POST['nazwisko'.$i];
$admin=$_POST['admin'.$i];
unset($_POST);
$sql="SELECT * FROM konta WHERE `login`='".$login."' and klasa='".$klasa."' and grupa='".$grupa."' and imie='".$imie."' and nazwisko='".$nazwisko."' and `admin`='".$admin."'";
$rezultat=$mysqli->query($sql); 

echo $login." ".$klasa." ".$grupa." ".$imie." ".$nazwisko." ".$admin."<br>";
if ($rezultat->num_rows==0){
    $update="UPDATE konta SET `login`='".$login."',klasa='".$klasa."',grupa='".$grupa."',imie='".$imie."',nazwisko='".$nazwisko."',admin='".$admin."' WHERE id='".$i."'";
    $rezultat2=$mysqli->query($update) or die ("nie");
    if($rezultat2){
        header("Location: paneladmin.php");
    }
    
}
else{
    header("Location: paneladmin.php");
}




?>