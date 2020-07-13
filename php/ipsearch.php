<?php
include '../includes/mypaths.php';
spl_autoload_register(function ($class_name) {
    include_once MODELS . DS . $class_name . ".php";
});

//$_POST['searching'] = "bw";
$response = array();
if(isset($_POST['selected'])){
    
}else{
    $conn = Singleton::getInstance();
    $pr = $conn->run("SELECT idno,injpname FROM ".TBL_ACCREPORT);

    for($j=0;$fr=$pr->fetch(PDO::FETCH_ASSOC);$j++){
        $response['iperson'][] = $fr;
    }
}

echo json_encode($response);