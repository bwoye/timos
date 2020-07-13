<?php
include '../includes/mypaths.php';
spl_autoload_register(function ($class_name) {
    include_once MODELS . DS . $class_name . ".php";
});

$response = array("error" => true);
// $pp = Employers::getMember('13');
// print_r($pp);
if (isset($_POST['adding'])) {
    $fk = new Medicalreport($_POST);
    $fk->addRec();
} else if (isset($_POST['delete'])) {
    $fk = Medicalreport::getMember($_POST['idno']);
    $fk->delRec();
}else if(isset($_POST['removepic'])){
    $conn = Singleton::getInstance();
    $idno = $_POST['removepic'];
    $pp = Medicalreport::getMember($idno);
    $image = $pp->getValue('medattached');
    $imagepath = '../myuploads/'.$image;
    $conn->run("UPDATE ".TBL_MEDREPORT." SET medattached=:medattached WHERE idno=:idno",["medattached"=>'no',"idno"=>$idno]);

    unlink($imagepath);
}


//print_r($fk);
