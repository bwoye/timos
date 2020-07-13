<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: ../index.php");
    exit();
}

if (!isset($_POST['submit'])) {
    header("Location: ../index.php");
    exit();
} else {
    $empname = $_POST['empname'];
    $phyadd = $_POST['phyadd'];
    $uemail = $_POST['uemail'];
    $emptel = $_POST['emptel'];
    $district = $_POST['district'];

    // echo $empname . '<br>';
    // echo $phyadd . '<br>';
    // echo $uemail . '<br>';
    // echo $emptel . '<br>';    

    if (empty($empname) || empty($phyadd) || empty($district) || empty($emptel)) {
        header("Location: ../empregister.php?empreg=emptyfields");
        exit();
    }else{
        include_once 'classes/connector.php';
        $conn = Singleton::getInstance();
        $sql = "INSERT INTO employers values(?,?,?,?,?,?)";
        $id = 1;
        $fword = substr($empname,0,2);
        $go = true;
        $fr = "SELECT * FROM employers WHERE employerid=?";
        $empid = '';
        do{
            $empid = $id.$fword;
            $dw = $conn->run($fr,[$empid]);    
            if($dw->rowCount() > 0){
                $id += 1;
            }else{
                $go = false;
            }               
        }while($go);

        $conn->run($sql,[$empid,$empname,$phyadd,$uemail,$emptel,$district]);
        header("Location: ../empregister.php?empreg=success");
        exit();
    }
}
