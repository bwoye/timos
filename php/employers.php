<?php
include '../includes/mypaths.php';
spl_autoload_register(function ($class_name) {
    include_once MODELS.DS.$class_name . ".php";
});

$response=array("error"=>true);
// $pp = Employers::getMember('13');
// print_r($pp);
if(isset($_POST['adding'])){
    $nr = new Employers($_POST);  
    $pp = Employers::getMember($nr->addRecord());
    
    $kv = District::getMember($pp->getValue('distcode'));
    $xx = Employers::counts();
   
    $response['newrec']['empid'] = $pp->getValue('empid');
    $response['newrec']['empname'] = $pp->getValue('empname');
    $response['newrec']['phyadd'] = $pp->getValue('phyadd');
    $response['newrec']['distcode'] = $pp->getValue('distcode');
    $response['newrec']['uemail'] = $pp->getValue('uemail');
    $response['newrec']['distname'] = $kv->getValue('distname');
    $response['newrec']['emptel'] = $pp->getValue('emptel');
    $response['newrec']['many'] = $xx;
    //$response['newrec'][] = $pp;
    
}else if(isset($_POST['empid']) && !isset($_POST['deleting'])){
    $pp = new Employers($_POST);
    $pp->editRec();

    $kv = District::getMember($_POST['distcode']);
    $xx = Employers::getMember($_POST['empid']);
   
    $response['editRec']['empid'] = $xx->getValue('empid');
    $response['editRec']['empname'] = $xx->getValue('empname');
    $response['editRec']['phyadd'] = $xx->getValue('phyadd');
    $response['editRec']['distcode'] = $xx->getValue('distcode');
    $response['editRec']['uemail'] = $xx->getValue('uemail');
    $response['editRec']['distname'] = $kv->getValue('distname');
    $response['editRec']['emptel'] = $xx->getValue('emptel');

}else if(isset($_POST['deleting'])){
    $fr = Employers::getMember($_POST['deleting']);
    $fr->delRec();
}elseif(isset($_POST['getall'])){
    $conn = Singleton::getInstance();
    $fr = $conn->run("SELECT empid,empname FROM ".TBL_EMPLOYERS." ORDER BY  empname");
    for($j=0;$p=$fr->fetch(PDO::FETCH_ASSOC);$j++){
        $response['employers'][] = $p;
    }

}else{
    $response['error'] = false;
    $response['employers'] = Employers::getAll();
    $response['districts'] = District::getAll();
}

echo json_encode($response);