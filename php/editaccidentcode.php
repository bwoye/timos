<?php
include '../includes/mypaths.php';

spl_autoload_register(function ($class_name) {
    include_once MODELS . DS . $class_name . ".php";
});

$response = array();
$conn = Singleton::getInstance();

if(isset($_POST['person'])){
    $kk = $conn->run("SELECT * FROM ".TBL_ACCREPORT."   WHERE accid=:accid",["accid"=>$_POST['person']]);
    $response['accreport'] = $kk->fetch(PDO::FETCH_ASSOC);

    $jk = $conn->run("SELECT * FROM ".TBL_EMPWAGES." WHERE accid=:accid",["accid"=>$_POST['person']]);
    $response['mywages'] = $jk->fetch(PDO::FETCH_ASSOC);
    
    $jk = $conn->run("SELECT * FROM ".TBL_ACCDETAILS." WHERE accid=:accid",["accid"=>$_POST['person']]);
    $response['accdetails'] = $jk->fetch(PDO::FETCH_ASSOC);
    
}else if(isset($_POST['empid'])){
    $ff = $conn->run("SELECT * FROM ".TBL_PROJDETAILS. " WHERE empid=:empid",["empid"=>$_POST['empid']]);
    for($j=0;$k=$ff->fetch(PDO::FETCH_ASSOC);$j++){
        $response['projects'][] = $k;
    }
}else if(isset($_POST['myedits'])){

    $nr = $_POST;

    $kk = new Accreport($nr);

    $kk->editRec();

    $pp= new Empwages($nr);
    $pp ->editWage();

    $vv = new Accdetails($nr);
    $vv ->editRec();

}else if(isset($_POST['manyperson'])){
    $jj = $conn->run("SELECT * FROM ".TBL_ACCREPORT. " WHERE projid=:projid",["projid"=>$_POST['manyperson']]);
    for($j=0;$m=$jj->fetch(PDO::FETCH_ASSOC);$j++){
        $response['mperson'][] = $m;
    }

    $kk = $conn->run("SELECT * FROM ".TBL_JOBS);
    for($j=0;$v=$kk->fetch(PDO::FETCH_ASSOC);$j++){
        $response['jobs'][] = $v;
    }
}else{
    $response['employers'] = Employers::getAll();
}

echo json_encode($response);

/*$nr= array("monthly"=>"250000","weekly"=>"325","daily"=>"0","accid"=>"fr1","accdate"=>"2020-03-13","acctime"=>"05:00","accplace"=>null,"accagent"=>"10","accdescription"=>"players","workno"=>"yes","doingwhat"=>"18","acctype"=>"10","accresult"=>"minor injury","accinjuries"=>"13","bodyinjury"=>"22","hospital"=>"mulago","projid"=>"2ka","injpname"=>"fred mugole","injempadd"=>"p.o box 241","jobtitle"=>null,"natid"=>"45213","race"=>"black","nextofkin"=>"john tabuti","kinphone"=>"","gender"=>"M","empage"=>"50","distcode"=>"27","saza"=>"347","village"=>"mawoito","myedits"=>"yes");


$kk = new Accreport($nr);
//print_r($kk);

$kk->editRec();

$pp= new Empwages($nr);

$pp ->editWage();

$vv = new Accdetails($nr);

$vv ->editRec();-*/