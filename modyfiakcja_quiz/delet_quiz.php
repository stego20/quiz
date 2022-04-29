<?php
include_once '../db/connect.php';
include_once '../includes/header.php';
session_start();

$id_quiz=$_GET['n'];
if(!isset($_GET['n'])){
    header("location: index.php");
}
$delete="DELETE FROM choices WHERE id_quiz='".$id_quiz."'";
$deletechoice=$mysqli->query($delete) or die(" coś poszło nie tak");
$delete="DELETE FROM questions WHERE id_quiz='".$id_quiz."'";
$deletequest=$mysqli->query($delete) or die(" coś poszło nie tak");
$delete="DELETE FROM quizy WHERE id='".$id_quiz."'";
$deletequiz=$mysqli->query($delete) or die(" coś poszło nie tak");
header("Location: modify_quiz.php");

?>