<?php
include_once '../includes/header.php';
include_once '../db/connect.php';
session_start();
?>
<?php
$_SESSION["pytania"] = array();
$_SESSION["odpowiedzi"] = array();
?>
<?php
if(isset($_POST["submit"])){

    $sql3 = "SELECT * FROM questions WHERE id_quiz='".$_SESSION['id']."'";
    $questions = $mysqli->query($sql3) or die($mysqli->error.__LINE__);
    $count = $questions->num_rows;
    
    
    $pytania = array();
    $file = file_get_contents($_POST["questiontxt"]);
    $lines = explode("\n",$file);
    foreach ($lines as $key ) {
        $explode = explode("\t",$key);
        array_push($pytania,$explode);
    }
    array_shift($pytania);

    $odp = array();
    $file = file_get_contents($_POST["choicestxt"]);
    $lines = explode("\n",$file);
    foreach ($lines as $key ) {
        $explode = explode("\t",$key);
        array_push($odp,$explode);
    }
    array_shift($odp);

    $_SESSION["pytania"] = $pytania;
    $_SESSION["odpowiedzi"] = $odp;
    $_SESSION["operator"] = 0;
    $_SESSION["end"]=sizeof($pytania)-1;
    $_SESSION["count"]=$count;
    $_SESSION["usuwanie"]=0;
    header("Location:check.php");
}

?>
<mian>
    <div class = "container">
        <h2>Add A Question From TXT File</h2>
        <form action="gettxt.php" method="POST">
            <p>
                <label for="question" class="form-label" >Question TXT</label>
                <input id="question" class="form-control" type="file" required="required" name="questiontxt">
            </p>
            <p>
                <label for="choices" class="form-label">Choices TXT</label>
                <input id="choices" class="form-control" type="file" required="required" name="choicestxt">
            </p>
            <input type="submit" class="btn btn-primary" name="submit" value="Submit">
        </form>
        <a href="dashboard.php" class="btn btn-primary">Back</a>
    </div>
</mian>
<?php include_once '../includes/footer.php'; ?>