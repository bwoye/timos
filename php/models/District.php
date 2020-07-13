<?php
/*
+----------+-------------+------+-----+---------+----------------+
| Field    | Type        | Null | Key | Default | Extra          |
+----------+-------------+------+-----+---------+----------------+
| distcode | int(3)      | NO   | PRI | NULL    | auto_increment |
| distname | varchar(50) | YES  |     | NULL    |                |
| Region   | varchar(50) | YES  |     | NULL    |                |
+----------+-------------+------+-----+---------+----------------+
*/

class District extends DataObject
{
    protected $data = array(
        "distcode" => 0,
        "distname" => '',
        "Region" => ''
    );

    public static function getMember($distcode)
    {
        $conn = parent::connect();
        $fr = $conn->run("SELECT * FROM " . TBL_DISTRICTS . "  WHERE distcode=:distcode", ["distcode" => $distcode]);
        $pp = $fr->fetch(PDO::FETCH_ASSOC);
        return new District($pp);
    }

    public static function getAll()
    {
        $conn = Singleton::getInstance();
        $response = array();
        $pp = $conn->run("SELECT * FROM " . TBL_DISTRICTS . " ORDER BY distname");

        for ($j = 0; $f = $pp->fetch(PDO::FETCH_ASSOC); $j++) {
            $response[] = $f;
        }
        return $response;
    }

    public function addRecord()
    {
        $this->data['distcode'] = NULL;
        $conn = parent::connect();
        $response = array("error"=>true);
        $conn->beginTransaction();
        try {
            $conn->run("INSERT INTO " . TBL_DISTRICTS. " VALUES(:distcode,:distname,:Region)", $this->data);
            $this->data['distcode'] = $conn->userInsert();
            $response['error'] = false;
            $response['errmsg'] = "Record inserted";
            $conn->commit();
        } catch (PDOException $e) {
            $conn->rollBack();
            $response['errmsg']= $e->getMessage();
            $response['error'] = true;
        }
        return $this->data;
    }

    public function editRec()
    {
        $conn = parent::connect();        
        $fg = $conn->run("UPDATE " . TBL_DISTRICTS . " SET distname=:distname,Region=:Region WHERE distcode=:distcode", $this->data);
        //print_r($this->data);
        $response['error'] = false;
        $response['errmsg'] = 'Record saved';
        return array_merge($this->data,$response);
    }

    public function delRec()
    {
        $conn = parent::connect();
        $distcode = $this->data['distcode'];
        $conn->run("DELETE FROM " . TBL_DISTRICTS . " WHERE distocde=:distcode", ["distcode" => $distcode]);
        return $distcode;
    }
}
