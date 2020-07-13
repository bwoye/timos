<?php
if (isset($_POST['submit'])) {

    $userid = $_POST['userid'];
    $utype = $_POST['utype'];
    $pkword = $_POST['pkword'];
    $fulname = $_POST['fulname'];

    // echo $userid.'<br>';
    // echo $pkword.'<br>';
    // echo $fulname.'<br>';
    // echo $utype.'<br>';
     //exit();

    if (empty($userid) || empty($fulname) || empty($pkword) || empty($utype)) {
        header("Location: ../signup.php?error=fillall");
        exit();
    } else {
        if (!preg_match("/^[a-zA-Z].*$/", $fulname)) {
            header("Location: ../signup.php?error=invalidName");
            exit();
        } else {
            //check if email is valid 
            // if (!filter_var($uemail, FILTER_VALIDATE_EMAIL)) {
            //     header("Location: ../signup.php?error=invalidEmail");
            //     exit();
            // } else {
            //Check if uemail is already taken
            include_once "classes/connector.php";
            $conn = Singleton::getInstance();
            $fr = $conn->run("SELECT * FROM users WHERE userid=?", [$userid]);

            if ($fr->rowCount() > 0) {
                header("Location: ../signup.php?error=userTaken");
                exit();
            } else {
                //Let us harsh password
                $harshedPass = password_hash($pkword, PASSWORD_DEFAULT);

                $conn->run("INSERT INTO users VALUES(?,?,?,?)", [$userid, $fulname, $harshedPass, $utype]);
                header("Location: ../signup.php?error=success");
            }
        }
        //}
    }
} else {
    header("Location: ../signup.php");
    exit();
}
