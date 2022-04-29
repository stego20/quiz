<?php
include_once '../db/connect.php';
include_once '../includes/header.php';
session_start();

$i=$_POST['edit'];

$name=$_POST['name'.$i];
$data_start=$_POST['data-s'.$i];
$data_koniec=$_POST['data-k'.$i];
$grupa=$_POST['grupa'.$i];
$klasa=$_POST['klasa'.$i];
$data_start = date('Y-m-d H:i:s ', strtotime($data_start));
$data_koniec = date('Y-m-d H:i:s ', strtotime($data_koniec));
$id_sesji=$_POST['id-s'];
unset($_POST);
$sql="SELECT * FROM quizy WHERE `name`='".$name."'";
$rezultat=$mysqli->query($sql); 
$wiersz=$rezultat->fetch_assoc();
$id_quiz=$wiersz['id'];
echo gettype($data_start);
echo $name." ".$id_quiz." ".$data_start." ".$data_koniec." ".$grupa." ".$klasa." ".$id_sesji."<br>";
if ($rezultat->num_rows>=1){
    $update="UPDATE `kolejka` SET `name`='".$name."',`id_quiz`='".$id_quiz."',`data_start`='".$data_start."',`data_koniec`='".$data_koniec."',`klasa`='".$klasa."',`grupa`='".$grupa."' WHERE `id_sesji`='".$id_sesji."'";
    echo $update;
    $rezultat3=$mysqli->query($update) or die ("nie");
    
    if($rezultat3){
        header("Location: dashboard-zaplanowane.php");
    }
    
}
else{
    header("Location: dashboard-zaplanowane.php");
}




?>