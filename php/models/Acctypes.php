<?php
/*
+----------+--------------+------+-----+---------+----------------+
| Field    | Type         | Null | Key | Default | Extra          |
+----------+--------------+------+-----+---------+----------------+
| typeno   | int(11)      | NO   | PRI | NULL    | auto_increment |
| nametype | varchar(100) | YES  |     | NULL    |                |
+----------+--------------+------+-----+---------+----------------+
2 rows 
*/

class Acctypes extends DataObject
{
    protected $data = array(
        "typeno"=>0,
        "nametype"=>''
    );

    public static function getMember($typeno)
    {
        $conn = parent::connect();
        $fr = $conn->run("SELECT * FROM " . TBL_ACCTYPES . "  WHERE typeno=:typeno", ["typeno" => $typeno]);
        $pp = $fr->fetch(PDO::FETCH_ASSOC);
        return new Acctypes($pp);
    }

    public static function getAll()
    {
        $conn = Singleton::getInstance();
        $response = array();
        $pp = $conn->run("SELECT * FROM " . TBL_ACCTYPES . " ORDER BY nametype");

        for ($j = 0; $f = $pp->fetch(PDO::FETCH_ASSOC); $j++) {
            $response[] = $f;
        }
        return $response;
    }

    public function addRecord()
    {
        $this->data['typeno'] = NULL;
        $conn = parent::connect();
        $mt = 0;
        $conn->beginTransaction();
        try {
            $conn->run("INSERT INTO " . TBL_ACCTYPES. " VALUES(:typeno,:nametype", $this->data);
            $mt = $conn->userInsert();
            $this->data['typeno'] = $conn->userInsert();
            $conn->commit();
            return $this->data;
        } catch (PDOException $e) {
            $conn->rollBack();
        }
        return $mt;
    }

    public function editRec()
    {
        $conn = parent::connect();
        $fg = $conn->run("UPDATE " . TBL_ACCTYPES . " SET nametype=:nametype WHERE typeno=:typeno", $this->data);
        return $this->data;
    }

    public function delRec()
    {
        $conn = parent::connect();
        
        $conn->run("DELETE FROM " . TBL_ACCTYPES . " WHERE typeno=:typeno", ["typeno" => $this->data['typeno']]);
        return "record deleted";
    }
}