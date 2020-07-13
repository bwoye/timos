<?php
//session_start();
include '../includes/mypaths.php';
spl_autoload_register(function ($class_name) {
    include_once MODELS . DS . $class_name . ".php";
});



$conn = Singleton::getInstance();

$response = array('error'=>true);
if(!$conn){
    $response['errmsg'] = "Unable to log into databases";
}else if(isset($_POST['editing'])){
    $pp = new District($_POST);
    $pp->editRec();

}else if(isset($_POST['adding'])){
    $pp = new District($_POST);
    print_r($pp);
    $pp->addRecord();
}else if(isset($_POST['delete'])){
    $conn->run("DELETE FROM districts WHERE distcode=?",[$_POST['delete']]);
    
    $bb = $conn->run("SELECT COUNT(*) FROM districts");
    $kk = $bb->fetch(PDO::FETCH_NUM);
    $response['counts'] = $kk[0];
}else{
    $pk = $conn->run("SELECT * FROM districts ORDER BY distname");
    for($j=0;$pp=$pk->fetch(PDO::FETCH_ASSOC);$j++){
        $response['districts'][] = $pp;
    }
}

// $vv =  Array ( 'distcode' => 0 ,'distname' => 'bwoye', 'Region' => 'no' ) ;
// $kl = new  District($vv);
// $kl->addRecord();

echo json_encode($response);