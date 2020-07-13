<?php
include '../includes/mypaths.php';

spl_autoload_register(function ($class_name) {
    include_once MODELS.DS.$class_name . ".php";
});

$response=array();
if(isset($_POST['adding'])){

    $pp = new Projdetails($_POST);
    //print_r($pp);
    $pp->addRecord();

}else if(isset($_POST['editing'])){
    
    $pp = new Projdetails($_POST);
    $pp->editRec();

}else if (isset($_POST['delete'])){

}elseif(isset($_POST['project'])){
   $response['projects'] = Projdetails::getForCompany($_POST['project']);
}else{
    $conn = Singleton::getInstance();
    $pr = $conn->run("SELECT a.*,b.distname FROM ".TBL_EMPLOYERS ." a LEFT JOIN ".TBL_DISTRICTS." b USING(DISTCODE) ORDER BY a.empname");

    for($j=0;$pp = $pr->fetch(PDO::FETCH_ASSOC);$j++){
        $response['employers'][] = $pp;
    }

    $response['districts'] = District::getAll();
}
echo json_encode($response);