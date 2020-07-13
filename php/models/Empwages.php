<?php
/*
+---------+------------+------+-----+---------+-------+
| Field   | Type       | Null | Key | Default | Extra |
+---------+------------+------+-----+---------+-------+
| accid   | varchar(8) | NO   | PRI | NULL    |       |
| monthly | int(10)    | YES  |     | 0       |       |
| weekly  | int(10)    | YES  |     | 0       |       |
| daily   | int(10)    | YES  |     | 0       |       |
+---------+------------+------+-----+---------+-------+
4 rows in set (0.00 sec)
*/

class Empwages extends DataObject
{
    protected $data = array(
        "accid" => '',
        "monthly" => 0,
        "weekly" => 0,
        "daily" => 0
    );


    /**
     * Get all payments for this accident victim
     */
    public static function getMember($accid)
    {
        $conn = parent::connect();
        $fr = $conn->run("SELECT * FROM " . TBL_EMPWAGES . "  WHERE accid=:accid", ["accid" => $accid]);
        $pp = $fr->fetch(PDO::FETCH_ASSOC);
        return new Empwages($pp);
    }

    public function addRecord()
    {

        $conn = parent::connect();
        $response = array("error" => true);
        $mt = 0;
        $conn->beginTransaction();
        try {
            $conn->run("INSERT INTO " . TBL_EMPWAGES . " VALUES(:accid,:monthly,:weekly,:daily)", $this->data);
            $mt = $conn->userInsert();
            $this->data['accid'] = $mt;
            $conn->commit();
            $response['error'] = false;
            $response['errmsg'] = "Record was added";
        } catch (PDOException $e) {
            $conn->rollBack();
            $response['errmsg'] = "Record not added " . $e->getMessage();
        }

        return $response;
    }

    public function delRec()
    {
        $conn = parent::connect();
        $accid = $this->data['accid'];
        $conn->run("DELETE FROM " . TBL_EMPWAGES . " WHERE accid=:accid", ["accid" => $accid]);
        return $accid;
    }

    public function editWage(){
        $conn =parent::connect();
        $kk = $conn->run("UPDATE ".TBL_EMPWAGES." SET monthly=:monthly,weekly=:weekly,daily=:daily WHERE accid=:accid",$this->data);
    }
}

// echo json_encode(Wagetypes::getAll());
