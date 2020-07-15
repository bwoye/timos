<?php

include '../includes/connector.php';
$conn = Singleton::getInstance();
$response = array();
$pp = $conn->run("SELECT * FROM usertypes");

for($j = 0 ;$k=$pp->fetch(PDO::FETCH_ASSOC);$j++){
    $response[] = $k;
}
echo json_encode($response);