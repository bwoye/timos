<?php
include '../includes/mypaths.php';

spl_autoload_register(function ($class_name) {
    include_once MODELS . DS . $class_name . ".php";
});

$response = array();
$conn = Singleton::getInstance();
$funny ='';
if (isset($_POST['adding'])) {
    $nArr = $_POST;

    //Do the accidenreport
    $pp = new Accreport($nArr);
    $response = $pp->addRec();
   

} else if (isset($_POST['deleting'])) {

} else if (isset($_POST['idpro'])) {
    // $response['injured'] = Accreport::getforProject($_POST['idpro']);
    $response['injured'] = Projdetails::getForCompany($_POST['idpro']);
   
    
}else if (isset($_POST['editing'])){
    $vk = $_POST;
    $pp = new Accreport($_POST);
    $pp->editRec();

    $pq = new Empwages($vk);
    $pq->editWage();

    $ff = new Accdetails($vk);
    $ff->editRec();

}else if (isset($_POST['projid'])) {

    $projid = $_POST['projid'];

    $jk = $conn->run("SELECT * FROM ".TBL_ACCREPORT."   WHERE projid=:projid",["projid"=>$projid]);
    for($jj = 0;$rr=$jk->fetch(PDO::FETCH_ASSOC);$jj++){
        $response['projacc'][] = $rr;
    }
    $response['scounts'] = Subcounty::getAll();

} else {
    $response['employers'] = Employers::getAll();
    //$response['wages'] = Wagetypes::getAll();
    //$response['districts'] = District::getAll();
    $response['bparts'] = Bodyinjure::getAll();
    $response['injnature'] = Injurynature::getAll();
    $response['accplaces'] = Accplaces::getAll();
    $response['acctypes'] = Acctypes::getAll();
    $response['accagent'] = Accagents::getAll();
    $response['jobs'] = Jobs::getAll();
    $response['doingwhat'] = Doingwhats::getAll();
    $response['scounts'] = Subcounty::getAll();

    $fr = $conn->run("SELECT * FROM mycountries");
    for($j=0;$mm=$fr->fetch(PDO::FETCH_ASSOC);$j++){
        $response['country'][] = $mm;
    }
    //$response['injured'] = Projdetails::getForCompany('1ka');
}

function uploads($file){
    if ($_FILES[$file]['name'] != '') {
        $filename = $_FILES['file']['name'];
        $tmpfile = $_FILES['file']['tmp_name'];
        $ferror = $_FILES['file']['error'];
        $fsize = $_FILES['file']['size'];

        $response['filing']['filename'] = $filename;

        $allowed = array('jpg', 'jpeg', 'png', 'pdf');
        $fext = explode('.', $filename);
        $actualExt = end($fext);
        $fnew = uniqid('', true);
        $actname = '../myuploads/' . $fnew . "." . $actualExt;
        $response['filing']['givenname'] = $actname;

        if (in_array($actualExt, $allowed)) {
            if (move_uploaded_file($tmpfile, $actname)) {
                $response['filing']['upload'] = 'Uploaded'; 
                // $conn = Singleton::getInstance();
                // $conn->run("UPDATE " . TBL_ACCDETAILS . " SET supportimage=:supportimage WHERE idno=:idno", ["supportimage" => $fnew . "." . $actualExt, "idno" => $_POST['support']]);
            }else{
                $response['filing']['upload'] = 'not uploaded';
            }
            //$response['errmsg'] = "Image uploaded";
            //echo json_encode($response);
            //echo "I have moved file";
        }
    }
}
echo json_encode($response);
/*$nk = array("injpname" => "Isiko patrickfaith masituula", "injempadd" => "p. o. box 44 iganga", "jobtitle" => "5", "natid" => "546987", "race" => "ugandan", "nextofkin" => "faith masituula", "gender" => "M", "empage" => "45", "distcode" => "4", "saza" => "256", "village" => "mayuge", "projid" => "1Ig", "accid" => "", "kinphone" => "0774830710", "monthly" => "570000", "weekly" => "0", "daily" => "0", "accdate" => "2020-05-25", "acctime" => "20:55", "accplace" => "3", "accagent" => "9", "accdescription" => "electirical wiring", "workno" => "yes", "doingwhat" => "16", "acctype" => "9", "accresult" => "severe burns", "accinjuries" => "4", "bodyinjury" => "6", "hospital" => "iganga refferal", "adding" => "yes");*/

//Array ( [accid] => fr1 [projid] => 2ka [injpname] => fred mugole [natid] => 45213 [nextofkin] => john tabuti [kinphone] => 0772501326 [race] => black [injempadd] => p.o box 241 [gender] => M [empage] => 50 [jobtitle] => 1 [distcode] => 27 [saza] => 347 [village] => mawoito )*/


/*$pp = new Accreport($nk);
$response = $pp->addRec();
$nk['accid'] = $response['accid'];

$pq = new Empwages($nk);
print_r($pq);
$mm = $pq->addRecord();

$ff = new Accdetails($nk);
$ff->addRecord();*/
