<?php
include '../includes/mypaths.php';
if (isset($_POST['support'])) {

    if ($_FILES['file']['name'] != '') {
        $filename = $_FILES['file']['name'];
        $tmpfile = $_FILES['file']['tmp_name'];
        $ferror = $_FILES['file']['error'];
        $fsize = $_FILES['file']['size'];

        $allowed = array('jpg', 'jpeg', 'png', 'pdf');
        $fext = explode('.', $filename);
        $actualExt = end($fext);
        $fnew = uniqid('', true);
        $actname = '../myuploads/' . $fnew . "." . $actualExt;

        if (in_array($actualExt, $allowed)) {
            if (move_uploaded_file($tmpfile, $actname)) {
                $conn = Singleton::getInstance();
                $conn->run("UPDATE " . TBL_ACCDETAILS . " SET supportimage=:supportimage WHERE idno=:idno", ["supportimage" => $fnew . "." . $actualExt, "idno" => $_POST['support']]);
            }
            //$response['errmsg'] = "Image uploaded";
            //echo json_encode($response);
        }
    }
}else if(isset($_POST['medical'])){
    if ($_FILES['file']['name'] != '') {
        $filename = $_FILES['file']['name'];
        $tmpfile = $_FILES['file']['tmp_name'];
        $ferror = $_FILES['file']['error'];
        $fsize = $_FILES['file']['size'];

        $allowed = array('jpg', 'jpeg', 'png', 'pdf');
        $fext = explode('.', $filename);
        $actualExt = end($fext);
        $fnew = uniqid('', true);
        $actname = '../myuploads/' . $fnew . "." . $actualExt;

        if (in_array($actualExt, $allowed)) {
            if (move_uploaded_file($tmpfile, $actname)) {
                $conn = Singleton::getInstance();
                $pp = $conn->run("SELECT * FROM ".TBL_MEDREPORT." WHERE accid=:accid",["accid"=>$_POST['accid']]);
                if($pp->rowCount() < 1){
                    $conn->run("INSERT INTO ".TBL_MEDREPORT." VALUES(:idno,:accid,:medname)",["idno"=>NULL,"accid"=>$_POST['accid'],"medname"=>$fnew]);
                }else{
                    $conn->run("UPDATE ".TBL_MEDREPORT." SET medname=:medname WHERE accid=:accid",["medname"=>$fnew,"accid"=>$_POST['accid']]);
                }
               
            }
            //$response['errmsg'] = "Image uploaded";
            //echo json_encode($response);
        }
    }
}
