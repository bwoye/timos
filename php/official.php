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
} else {
    if ($_SESSION['utype'] == "Os") {
        //Get the number for permissions
 
        //Populate the districts
        //select a.empid,a.distcode,a.empname,b.distname from employers a  left join districts b using(distcode) where a.empid in (select empid from projdetails where projid in (select projid from accreport));
        $dist = $conn->run("SELECT a.distcode,b.distname FROM " . TBL_EMPLOYERS . " a LEFT JOIN ".TBL_DISTRICTS. " b USING(distcode) WHERE a.empid IN (SELECT empid FROM " . TBL_PROJDETAILS . " WHERE projid IN (SELECT projid FROM ".TBL_ACCREPORT."))");
        for ($j = 0; $km = $dist->fetch(PDO::FETCH_ASSOC); $j++) {
            $response['districts'][] = $km;
        }
    } else if ($_SESSION['utype'] == "Ad") {
    } else if ($_SESSION['utype'] == "Os") {
    } else if ($_SESSION['utype'] == "DO") {
    }
}
echo json_encode($response);
