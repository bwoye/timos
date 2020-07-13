<?php
include '../includes/mypaths.php';
spl_autoload_register(function ($class_name) {
    include_once MODELS.DS.$class_name . ".php";
});
$conn = Singleton::getInstance();
//$response=array("error"=>true);

if(isset($_POST['adding'])){
    $kk = new Empwages($_POST);
    $response= $kk->addRecord();
}else if(isset($_POST['deleting'])){
   $kk = Empwages::getMember($_POST['deleting']);
   $kk->delRec();
}elseif(isset($_POST['mytype'])) {   
   $kk = new Wagetypes($_POST);
   $kk->editRec();
   $response=array();
   $mk = $conn->run("SELECT * FROM ".TBL_WAGETYPES." ORDER BY wagename");
   for($k=0;$pp=$mk->fetch(PDO::FETCH_ASSOC);$k++){
        $response['wages'][] = $pp;
   }
}
echo json_encode($response);

