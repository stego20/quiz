<?php
include_once '../db/connect.php';
session_start();
if (isset($_POST)){
    $name=$_POST['name'];
    $oceny=$_POST;
    array_shift($oceny);
    $oceny=serialize($oceny);
    $sql="SELECT `name` FROM quizy WHERE `name`='".$name."'order by id DESC limit 1";
    $rezultat=$mysqli->query($sql);
    if ($rezultat->num_rows==0 ){
        
            $insert="INSERT INTO quizy VALUES('null','".$name."','".$_SESSION['user-id']."','".$oceny."')";

            if($rezultat=$mysqli->query($insert) or die ($mysqli_error.__LINE__)){
                $query = $sql="SELECT id FROM quizy WHERE name='".$name."' AND id_n ='".$_SESSION['user-id']."'";
                $run = $mysqli->query($query);
                $id = mysqli_fetch_row($run);
                $_SESSION['id']=$id[0];
                header("Location: ../pytania/dashboard.php");
            };


        }
        else{
            $_SESSION['quiz_o_nazwie']="quiz o takiej nazwie już istnieje";
            header("Location: add_quiz.php");
        }
    }


    ?>