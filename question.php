<?php
//question
if(!isset($_SESSION['id_sesji']) and !isset($_SESSION['user']) and !isset($_SESSION['user-id'])){
include_once 'db/connect.php';
session_start();
//print_r($_SESSION["kolejnosc"]);

if(!isset($_SESSION['start'])){
    $_SESSION['start']=gmdate('H:i:s',time()+3600);
}

if(!isset($_SESSION['test'])){
    $_SESSION['test']=0;
}

if($_SESSION["oper"]==0){
    ($_SESSION)['score']=0;
}
    

$choices=array();

//Furtka na wybór timera zależnie od typu Quizu
$decy = 0;
if ($decy == 0) 
{
    echo('<script src="js/QuizTimer.js"></script>');
}
elseif ($decy == 1) 
{
    echo('<script src="js/QuestionTimer.js"></script>');
}

$oper=$_SESSION["oper"]+1;
$pyt = $_SESSION["kolejnosc"][$_SESSION["oper"]];
$query = "SELECT QuestionText, img FROM questions WHERE id_quiz='".$_SESSION['id_quiz_gra']."' AND QuestionNumber='".$pyt."'";
// echo $query;

$run = $mysqli->query($query) or die($mysqli_error.__LINE__);
$pytanie = mysqli_fetch_row($run);
$x =$oper;

$query = "SELECT choiceText FROM choices WHERE id_quiz='".$_SESSION['id_quiz_gra']."' AND QuestionNumber='".$pyt."'";
$run = $mysqli->query($query) or die($mysqli_error.__LINE__);
$odp = array();
while($row = $run->fetch_assoc()){
    array_push($odp, $row["choiceText"]);
};


$size = sizeof($odp);
$_SESSION["size"] = $size;

$kangurekKao = array();
while(sizeof($kangurekKao)!=sizeof($odp)){
    $rand = rand(0,sizeof($odp)-1);
    if (!in_array($odp[$rand],$kangurekKao)){
        array_push($kangurekKao,$odp[$rand]);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit-no">
    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/question.css">
    <title>Quiz</title>
</head>
<body>
</body>
</html>
<!-- wyświetlanie na stronie -->
<header>
    <div class="container">
        <h1> PHP Quizer</h1>
        <p id="timer">00:00</p>
    </div>
</header>

<main>
    <div class="container">
        <div class="current">Question <?php echo $oper //nr pyt;?> of <?php echo $_SESSION["total"] ;?> </div>
        <p class="question"><?php echo $pytanie[0];?> </p>

        <?php
        if($pytanie[1]!=NULL){
            $src = substr($pytanie[1],3);
            echo "<div style='text-align:center;'><img style='widith:100px; height:100px;' src='".$src."'></div>";
        }
        ?>
        <?php
        if($size!=0){
        ?>
        <form action="process.php" method="post">
            <ul class="choices">
                <?php
                    foreach ($kangurekKao as $key){?>
                        <li><input type="radio" name="choice" value="<?php  echo $key;?>"><?php  echo $key;?></li>
                <?php }; ?>
            </ul>
            <input id="NextQuest" type="submit" value="submit" class="btn btn-success"/>
            <input type="hidden" name="number" value="<?php echo $oper;?>" />
            <input type="hidden" id='sciagal' name="sciagal" value="<?php echo $oper;?>" />
            <input type="hidden" name="QuestionText" value="<?php echo $qtext["QuestionText"];?>" />
        </form>
        <?php }
        else{?>
            <form action="process.php" method="post" id="otwarte">
            <ul class="choices">
                <textarea rows = "4" cols = "40"  	name="otwarta" form_id="otwarte"></textarea>
            </ul>
            <input id="NextQuest" type="submit" value="submit" class="btn btn-success"/>
            <input type="hidden" name="number" value="<?php echo $oper;?>" />
            <input type="hidden" id='sciagal' name="sciagal" value="<?php echo $oper;?>" />
            <input type="hidden" name="QuestionText" value="<?php echo $qtext["QuestionText"];?>" />
        </form>
        <?php
        }
        ?>
    </div>
</main>
</div>

<?php

//   Ktoś niech to ogranie bo potrzebne w tabeli z wynikami ucznia miejsce na "Próby ściągania" = Tak/Nie

//   $host = 'localhost';
//   $user = 'root';
//   $pass = '';
//   $dbname = 'Cheating';
//   $conn = new mysqli($host, $user, $pass, $dbname) or die("nie połączono");
//   $sql = "INSERT INTO Wyniki (Proby) VALUES ('Tak');";

?>

<script>
  var controller = 0;
  var sciagal=0;
  let button=document.getElementById('sciagal');
  $( "html" )
    .mouseenter(function() 
    {})
    .mouseleave(function() 
    {
      controller = controller+1;
      if (controller >= 3) 
      {
          sciagal++;
            
        button.value=sciagal;
          // alert("Jebać kapusi");
          controller = 0;            
      }
    });
</script> 

<?php 
// include_once 'includes/footer.php'; 
}
else
{
    header("logowanie/logowanie.php");
}
?>