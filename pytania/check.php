<?php
include_once '../includes/header.php';
include_once '../db/connect.php';
session_start();
?>
<?php
$id = $_SESSION['id'];
if(isset($_POST["usu"])){
    $_SESSION["usuwanie"]+=1;
}
if(isset($_POST["submit"])){
    $file = $_FILES['img'];
    if($file["name"]){
        
        $fileTmpName = $_FILES['img']['tmp_name'];
        $fileName = $_FILES["img"]["name"];
        $fileExt = explode(".",$fileName);
        $ext = strtolower(end($fileExt));
        $fileName = uniqid("",true).".".$ext;
        
        $upload = '../foto/'.$fileName;
    
        move_uploaded_file($fileTmpName,$upload);
        
        $nrpyt = $_SESSION["operator"]+$_SESSION["count"]-$_SESSION["usuwanie"];
        $post = $_POST["pytanie"];
        $query = "INSERT INTO questions VALUES('$id','$nrpyt','$post','$upload')";
        $run=$mysqli->query($query) or die ;
    }
    else{
        $nrpyt = $_SESSION["operator"]+$_SESSION["count"]-$_SESSION["usuwanie"];
        $post = $_POST["pytanie"];
        $query = "INSERT INTO questions VALUES('$id','$nrpyt','$post',NULL)";
        $run=$mysqli->query($query);
    }
    
    for ($i=0; $i < 4; $i++) { //na sztywno
        if(!isset($_POST[$i+10])){
            $post = $_POST[$i];
            $query="INSERT INTO choices VALUES('$id','$nrpyt',0,'$post')";
            $run=$mysqli->query($query);
        }
        else{
            $query = "INSERT INTO choices";
            $post = $_POST[$i];
            $query="INSERT INTO choices VALUES('$id','$nrpyt',1,'$post')";
            $run=$mysqli->query($query);
        }
    }
    
    
}
if($_SESSION["end"]>=$_SESSION["operator"]){
    $textpyt = 0;
    $iscorrect = 10;
    $pytanie = $_SESSION["pytania"][$_SESSION["operator"]][0];
    // echo $pytanie."<br>";
    $_SESSION["operator"]+=1;
    $odp = array();
    foreach ($_SESSION["odpowiedzi"] as $key) {
        if($key[0]==$pytanie){
            array_push($odp,$key);
            array_shift($_SESSION["odpowiedzi"]);
        }
        elseif($key[0]>$pytanie){
            break;
        }
    }
    // print_r($odp);
    
}
else{
    unset($_SESSION["pytania"]);
    unset($_SESSION["odpowiedzi"]);
    unset($_SESSION["operator"]);
    unset($_SESSION["end"]);
    unset($_SESSION["count"]);
    unset($_SESSION["usuwanie"]);
    header("Location:gettxt.php");
}
?>
<header>
    <div class="container">
        <h1>Testowanie Pytań(nazwa robocza)</h1>
    </div>

</header>

    <main>
<div class="container">
    <div class="current">Pytanie nr.<?php echo $_SESSION["operator"];?> </div>
    <form action="check.php" method="post" enctype="multipart/form-data">
        <label for="pytanie">Pytanie:</label>
        <input id="pytanie" name ="pytanie" type="text" value="<?php echo $pytanie = $_SESSION["pytania"][$_SESSION["operator"]-1][1]; ?>">
        <br><label>Odpowiedzi (zaznaczone- poprawna):</label><br>
        <?php foreach ($odp as $key) {?>
            <input type="checkbox" name="<?php echo $iscorrect;?>" value="<?php echo $key[1];?>"<?php if($key[1]==1){echo"checked";}?>><input name="<?php echo $textpyt;?>" type="text" value="<?php echo $key[2]; ?>"><br>
        <?php $textpyt+=1; $iscorrect+=1;}?>
        <p>
            <label for="img" class="form-label" >Zdjęcie do Pytania</label>
            <input id="img" class="form-control" type="file" name="img">
        </p>
        <input type="submit" value="submit" name="submit" class="btn btn-success"/>
        <input type="submit" value="pomiń/usuń" name="usu" class="btn btn-success"/>
    </form>
    </div>
    </main>
</div>
<?php include_once '../includes/footer.php'; ?>
