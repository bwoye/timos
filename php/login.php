<?php
session_start();

if (isset($_POST['submit'])) {
    include_once "../includes/connector.php";
    $conn = Singleton::getInstance();

    $userid = $_POST['userid'];
    $kpass = $_POST['kpass'];
    $mytype = $_POST['mytypes'];

    if (empty($userid) || empty($kpass)) {
        header('Location: ../index.php?login=empty');
        exit();
    } else {
  
        if($mytype == "office"){
     
            $pp = $conn->run("SELECT * FROM users WHERE userid=?", [$userid]);
            if($pp->rowCount() == 1){
                $kk = $pp->fetch();
                
                $hashedPwd = password_verify($kpass, $kk->kpass);
    
                if (!$hashedPwd) {
                    header("Location: ../index.php?login=error");
                    exit();
                } else{
            
                    $_SESSION['userid'] = $kk->userid;                
                    $_SESSION['utype'] = $kk->utype;
                    $_SESSION['fulname'] = $kk->fulname;

                    echo $_SESSION['utype'].", ".$_SESSION['userid'].", ".$_SESSION['fulname'];
                    
                    //This landing page is different
                    if($_SESSION['utype'] == "DO"){
                        //Go to district officer's page
                        echo "<br>This is page is for listing all employers and contracts in the district";
                        exit();
                    }else if($_SESSION['utype'] == "OSH"){
                        //Osh login things
                        echo "<br>this is the OSH who is allowed to see all district going ons";
                    }else if($_SESSION['utype'] == "Ad"){
                        echo "<br>this is page for over all Admin and  owner of system";
                        //Admin login things
                    }else{
                        unset($_SESSION['userid'],$_SESSION['utype']);
                        header("Location: ../index.php?login=error");
                        exit(); 
                    }
                    
                }
            }else{
                //no user with those credentials
                unset($_SESSion['userid'],$_SESSION['utype']);
                header("Location: ../index.php?login=error");
                exit();
            }

        } else{
            //Authentitcate user first
            $mm = $conn->run("SELECT * FROM employers WHERE uemail=:uemail",["uemail"=>$userid]);
            if($mm->rowCount() == 1){
                $vv =$mm->fetch();
                print_r($vv);
                if($hashedPwd = password_verify($kpass, $vv->epass)){
                    $_SESSION['userid'] = $kk->userid;                
                    $_SESSION['utype'] = 'FR';
                    $_SESSION['empname'] = $vv->empname;
                    $_SESSION['empid'] = $vv->empid;
                    header("Location: ../accidentreport.php");
                    exit();
                }else{
                    echo "<br>User not find";
                    exit();
                }
            }else{
                echo "<br>something went wrong";
                //header("Location: ../index.php?login=error");
                exit();
            }  
        }
    }
}
else{
    header("Location: ../index.php?login=error");
    exit();
}