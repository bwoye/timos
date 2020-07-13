<?php
include '../includes/mypaths.php';
spl_autoload_register(function ($class_name) {
    include_once MODELS . DS . $class_name . ".php";
});

$response = array();

if(isset($_POST['adding'])){
    $pr = new Accdetails($_POST);
    $response = $pr->addRecord();
    echo json_encode($response);

}else if(isset($_POST['deleting'])){
    $conn = Singleton::getInstance();
    $conn->run("DELETE FROM ".TBL_ACCDETAILS." WHERE idno=:idno",["idno"=>$_POST['deleting']]); 

}elseif(isset($_POST['editing'])){
    $pk = new Accreport($_POST);
    $pk->editRec();
}elseif(isset($_POST['remove'])){
    $conn= Singleton::getInstance();
    $pk = Accdetails::getMember($_POST['remove']);
    $rfile = '../myuploads/'.$pk->getValue("supportimage");
    $conn->run("UPDATE ".TBL_ACCDETAILS." SET supportimage=:supportimage WHERE idno=:idno",["supportimage"=>"no","idno"=>$_POST['remove']]);
    unlink($rfile);
}