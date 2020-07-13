<?php

include '../includes/mypaths.php';
spl_autoload_register(function ($class_name) {
    include_once MODELS . DS . $class_name . ".php";
});

$response = array("error" => true);
$conn = Singleton::getInstance();
//Check for empty fileds and reject

if (isset($_POST['adding'])) {

    //check fro empty filed;
    $bad = true;
    //print_r($_POST);
    foreach ($_POST as $key => $value) {
        if (empty($value)) {
            echo $key . " is empty";
            $response['errmsg'] = "enter all missing fields"; 
            $bad = true;           
            break;
        } else{
            $bad = false;
        }   
    }

    if(!$bad){
        //Save record here
        $pp = new Bloggers($_POST);
        $response = $pp->addRecord(); 
    } 
}elseif(isset($_POST['viewing'])){
    $response = Bloggers::getAll();
}elseif(isset($_POST['idelete'])){
    $idno = $_POST['idelete'];
    $qq = $conn->run("DELETE FROM ".TBL_BLOG." WHERE idno=:idno",["idno"=>$idno]);
}
 else {
    $response['errmsg'] = "something is wrong";
}

echo json_encode($response);
