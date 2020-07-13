<?php
include '../includes/mypaths.php';

spl_autoload_register(function ($class_name) {
    include_once MODELS.DS.$class_name . ".php";
});

$response=array();
if(isset($_POST['adding'])){
    $nArr = $_POST;
    $pk = new Accreport($_POST);
    $r = $pk->addRec();
    $nArr['idno'] = $r['idno'];
    $ff = new Accdetails($nArr);
    $ff->addRecord();
    $pp = new Medicalreport($nArr);
    $pp->addRec();

}else if(isset($_POST['editing'])){
    $nArr = $_POST;
    $pk = Accreport::getMember($_POST['idno']);
    $pk->editRec();
    
    $ff = Accdetails::getMember($nArr['idno']);
    $ff->editRec();

    $pp = Medicalreport::getMember($nArr['idno']);
    $pp->editRec();

}else if(isset($_POST['deleting'])){

}else if(isset($_POST['idpro'])){
    $response['injured'] = Accreport::getforProject($_post['idpro']);
}else{
    $response['employers'] = Employers::getAll();
    //$response['wages'] = Wagetypes::getAll();
    $response['districts'] = District::getAll();
    $response['bparts'] = Bodyinjure::getAll();
    $response['injnature'] = Injurynature::getAll();
    $response['accplaces'] = Accplaces::getAll();
    $response['acctypes'] = Acctypes::getAll();
    $response['accagent'] = Accagents::getAll();
    $response['jobs'] = Jobs::getAll();
    $response['doingwhat'] = Doingwhats::getAll();
}
echo json_encode($response);