<?php

if (isset($_POST['submit'])) {
    include_once "classes/connector.php";

    $conn = Singleton::getInstance();
    $userid = $_POST['userid'];
    $pkword = $_POST['pkword'];
    $fulname = $_POST['fulname'];
    $uemail = $_POST['utype'];


    // echo $userid.'<br>';
    // echo $pkword.'<br>';
    // echo $fulname.'<br>';
    // echo $uemail.'<br>';
    //  exit();
    //Error handlers


    if (empty($userid) || empty($fulname) || empty($utype) || empty($pkword)) {
        header("location: ../signup.php?signup=empty");
        exit();
    } else {
        //Check valid fulname
        if (!preg_match("/^[a-zA-Z].*$/", $fulname)) {
            header("Location: ../signup.php?signup=invalidName");
            exit();
        } else {
            //Check for valid email
            if (!filter_var($uemail, FILTER_VALIDATE_EMAIL)) {
                header("Location: ../signup.php?signup=invalidEmail");
                exit();
            } else {
                //Check for duplicate username
                $sql = $conn->run("SELECT * FROM users WHERE userid=?", [$userid]);
                if ($sql->rowCount() > 0) {
                    header("Location: ../signup.php?signup=usertaken");
                    exit();
                } else {
                    //Hash the password
                    $hashedPass = password_hash($pkword, PASSWORD_DEFAULT);

                    $conn->run("INSERT INTO users VALUES(?,?,?,?)", [$userid, $fulname, $hashedPass, $utype]);

                    header("Location: ../signup.php?signup=success");
                    exit();
                }
            }
        }
    }
} else {
    header("Location: ../signup.php?error=registrationerror");
    exit();
}
