<?php
/*
+-------------+--------------+------+-----+---------+----------------+
| Field       | Type         | Null | Key | Default | Extra          |
+-------------+--------------+------+-----+---------+----------------+
| machineid   | int(11)      | NO   | PRI | NULL    | auto_increment |
| machinename | varchar(100) | YES  |     | NULL    |                |
+-------------+--------------+------+-----+---------+----------------+
2 rows in
*/

class Accmachines extends DataObject
{
    protected $data = array(
        "typeno"=>0,
        "nametype"=>''
    );

    public static function getMember($typeno)
    {
        $conn = parent::connect();
        $fr = $conn->run("SELECT * FROM " . TBL_ACCMACHINE . "  WHERE typeno=:typeno", ["typeno" => $typeno]);
        $pp = $fr->fetch(PDO::FETCH_ASSOC);
        return new Accmachines($pp);
    }

    public static function getAll()
    {
        $conn = Singleton::getInstance();
        $response = array();
        $pp = $conn->run("SELECT * FROM " . TBL_ACCMACHINE . " ORDER BY nametype");

        for ($j = 0; $f = $pp->fetch(PDO::FETCH_ASSOC); $j++) {
            $response[] = $f;
        }
        return $response;
    }

    // public function addRecord()
    // {
    //     $this->data['distcode'] = NULL;
    //     $conn = parent::connect();
    //     $mt = 0;
    //     $conn->beginTransaction();
    //     try {
    //         $conn->run("INSERT INTO " . TBL_DISTRICTS. " VALUES(:distcode,:distname,:Region", $this->data);
    //         $mt = $conn->userInsert();
    //         $conn->commit();
    //     } catch (PDOException $e) {
    //         $conn->rollBack();
    //     }
    //     return $mt;
    // }

    // public function editRec()
    // {
    //     $conn = parent::connect();
    //     unset($this->data['Region']);
    //     $fg = $conn->run("UPDATE " . TBL_DISTRICTS . " SET distname=:distname WHERE distcode=:distcode", $this->data);
    //     return $this->data['distcode'];
    // }

    // public function delRec()
    // {
    //     $conn = parent::connect();
    //     $distcode = $this->data['distcode'];
    //     $conn->run("DELETE FROM " . TBL_DISTRICTS . " WHERE distocde=:distcode", ["distcode" => $distcode]);
    //     return $distcode;
    // }
}