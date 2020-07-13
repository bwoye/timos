<?php
/*
+----------+-------------+------+-----+---------+----------------+
| Field    | Type        | Null | Key | Default | Extra          |
+----------+-------------+------+-----+---------+----------------+
| code     | int(5)      | NO   | PRI | NULL    | auto_increment |
| name     | varchar(25) | YES  |     | NULL    |                |
| distcode | int(5)      | YES  |     | 0       |                |
+----------+-------------+------+-----+---------+----------------+
3 rows in set (0.00 sec)
*/

class Subcounty extends DataObject
{
    protected $data = array(
        "code" => 0,
        "name" => '',
        "distcode" => 0
    );

    public static function getMember($code)
    {
        $conn = parent::connect();
        $fr = $conn->run("SELECT * FROM " . TBL_SUBCOUNTY . "  WHERE code=:code", ["code" => $code]);
        $pp = $fr->fetch(PDO::FETCH_ASSOC);
        return new Subcounty($pp);
    }

    public static function getAll()
    {
        $conn = Singleton::getInstance();
        $response = array();
        $pp = $conn->run("SELECT * FROM " . TBL_SUBCOUNTY . " ORDER BY name");

        for ($j = 0; $f = $pp->fetch(PDO::FETCH_ASSOC); $j++) {
            $response[] = $f;
        }
        return $response;
    }

    public function addRecord()
    {
        $this->data['code'] = null;
        $response=array("error"=>true);
        $conn = parent::connect();
        $mt = 0;
        $conn->beginTransaction();
        try {
            $conn->run("INSERT INTO " . TBL_SUBCOUNTY . " VALUES(:code,:name,:distcode)", $this->data);
            $mt = $conn->userInsert();
            $conn->commit();
            $this->data['code'] = $mt;
            $response['error'] = false;
            $response['errmsg'] = 'Record inserted';
        } catch (PDOException $e) {
            $conn->rollBack();
            $response['errmsg']=$e->getMessage();
        }
        $response = array_merge($response,$this->data);
        return $response;
    }

    public function editRec()
    {
        //unset($this->data['distcode']);
        $conn = parent::connect();
        $fg = $conn->run("UPDATE " . TBL_SUBCOUNTY . " SET name=:name,distcode=:distcode WHERE code=:code", $this->data);
        return $this->data;
    }

    public function delRec()
    {
        $conn = parent::connect();
        $code = $this->data['code'];
        $conn->run("DELETE FROM " . TBL_SUBCOUNTY . " WHERE code=:code", ["code" => $code]);
        return $code;
    }

    public static function getAllInCounty($distcode){
        $response = array();
        $conn = parent::connect();
        $qq = $conn->run("SELECT * FROM ".TBL_SUBCOUNTY." WHERE distcode=:distcode",["distcode"=>$distcode]);
        for($j=0;$m=$qq->fetch(PDO::FETCH_ASSOC);$j++){
            $response[] = $m;
        }

        return $response;
    }

    
}

