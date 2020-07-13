<?php
include '../includes/mypaths.php';
spl_autoload_register(function ($class_name) {
    include_once MODELS . DS . $class_name . ".php";
});


$conn = Singleton::getInstance();
$response=array();
if(isset($_POST['dists'])){
    $response['districts'] = District::getAll();
}else if(isset($_POST['distdel'])){
    $mydels = $_POST['distdel'];
    $pt = $conn->run("SELECT * FROM ".TBL_EMPLOYERS." WHERE distcode=:distcode",["distcode"=>$mydel]);
    if($pt->rowCount() > 0){
        $response['errmsg'] = "Cannot delete District";
        exit();
    }else{
        $conn->run("DELETE FROM ".TBL_DISTRICTS." WHERE distcode=:distcode",["distcode"=>$mydel]);
        $response['errmsg'] ="District Deleted";
    }
}else if(isset($_POST['distadd'])){
    $pp = new District($_POST);
    $pp->addRecord();
}else if(isset($_POST['editdist'])){
    $pp = new District($_POST);
    //print_r($pp);
    $response = $pp->editRec();
}elseif(isset($_POST['masaza'])){
    $response['sazas'] = Subcounty::getAllInCounty($_POST['masaza']);        
}elseif(isset($_POST['bpbody'])){
    $vv = $conn->run("SELECT * FROM myparts ORDER BY bparts");
    for($i=0;$m=$vv->fetch(PDO::FETCH_ASSOC);$i++){
        $response['bparts'][] = $m;
    }
}elseif(isset($_POST['cts'])){

    $response = Mycountries::getAll();

}

//injury places here
elseif(isset($_POST['addinginj'])){
    $pp = new Injurynature($_POST);
    $response = $pp->addRec();
}else if(isset($_POST['editinj'])){
    $pp = new Injurynature($_POST);
    $response = $pp->editRec();
}

//Accident places in here
elseif(isset($_POST['accidents'])){

    $response['places'] = Accplaces::getAll();

}

//Edit existing accident place
else if(isset($_POST['editaccident'])){
    $pp = new Accplaces($_POST);
    $response = $pp->editAccident();
}

//Let us put new accident report
else if(isset($_POST['newaccident'])){
    $pp = new Accplaces($_POST);
    $response = $pp->addNew();
}

//Accidents end here
elseif(isset($_POST['injnature'])){

    $response = Injurynature::getAll();

}elseif(isset($_POST['editsubs'])){

    $pp = new Subcounty($_POST);
    //print_r($pp);
    $response = $pp->editRec();

}elseif(isset($_POST['addsubs'])){

    $pp = new Subcounty($_POST);    
    $response = $pp->addRecord();

}elseif(isset($_POST['injedit'])){
    $pp = new Bodyinjure($_POST);    
    $response = $pp->editRec();
}

//Accident types begins here
else if(isset($_POST['acctype'])){
    $response = Acctypes::getAll();
}

else if(isset($_POST['editacctype'])){
    $pp = new Acctypes($_POST);
    $response = $pp->editRec();
}

else if(isset($_POST['acctypeadd'])){
    $pp = new Acctypes($_POST);
    $response = $pp->addRecord();
}

//Accident agents begin here


echo json_encode($response);
