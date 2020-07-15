<?php
//session_start();
include '../includes/mypaths.php';
spl_autoload_register(function ($class_name) {
    include_once MODELS . DS . $class_name . ".php";
});



$conn = Singleton::getInstance();

$response = array('error' => true);
if (!$conn) {
    $response['errmsg'] = "Unable to log into databases";
} else if(isset($_POST['lookup'])){
    $distcode = $_POST['lookup'];
    $kk = $conn->run("SELECT * FROM ".TBL_PROJDETAILS." WHERE projid IN (SELECT projid FROM ".TBL_ACCREPORT." WHERE distcode=:distcode)",["distcode"=>$distcode]);
    
    for($j=0;$m=$kk->fetch(PDO::FETCH_ASSOC);$j++){
        $response[] = $m;
    }
}

echo json_encode($response);
