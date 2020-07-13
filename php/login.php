<?php
session_start();

if (isset($_POST['submit'])) {
    include_once "../includes/connector.php";
    $conn = Singleton::getInstance();

    $userid = $_POST['userid'];
    $kpass = $_POST['kpass'];

    //Error handlers
    //Check for empty inputs

    if (empty($userid) || empty($kpass)) {
        header('Location: ../index.php?login=empty');
        exit();
    } else {
        //Check if user exists
        $pp = $conn->run("SELECT * FROM users WHERE userid=?", [$userid]);
        if ($pp->rowCount() < 1) {
            header("Location: ../index.php?login=error");
            exit();
        } else {
            $kk = $pp->fetch();
            //Dehashin password
            $hashedPwd = password_verify($kpass, $kk->kpass);

            if (!$hashedPwd) {
                header("Location: ../index.php?login=error");
                exit();
            } else if ($hashedPwd) {
                //Login in user here
                $_SESSION['userid'] = $kk->userid;                
                $_SESSION['utype'] = $kk->utype;
                $_SESSION['fulname'] = $kk->fulname;
                header("Location: ../index.php?login=success");
                exit();
            }
        }
    }
} else {
    header("Location: ../index.php?login=error");
    exit();
}
