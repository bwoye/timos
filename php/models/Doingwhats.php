<?php
/*
+---------+--------------+------+-----+---------+----------------+
| Field   | Type         | Null | Key | Default | Extra          |
+---------+--------------+------+-----+---------+----------------+
| what    | int(11)      | NO   | PRI | NULL    | auto_increment |
| actions | varchar(100) | YES  |     | NULL    |                |
+---------+--------------+------+-----+---------+----------------+
2 rows in set (0.00 sec)
*/

class Doingwhats extends DataObject
{
    protected $data = array(
        "what" => 0,
        "actions" => '',
    );

    public static function getMember($what)
    {
        $conn = parent::connect();
        $fr = $conn->run("SELECT * FROM " . TBL_DOWHAT . "  WHERE what=:what", ["what" => $what]);
        $pp = $fr->fetch(PDO::FETCH_ASSOC);
        return new District($pp);
    }

    public static function getAll()
    {
        $conn = Singleton::getInstance();
        $response = array();
        $pp = $conn->run("SELECT * FROM " . TBL_DOWHAT );

        for ($j = 0; $f = $pp->fetch(PDO::FETCH_ASSOC); $j++) {
            $response[] = $f;
        }
        return $response;
    }

    public function addRecord()
    {
        $this->data['what'] = NULL;
        $conn = parent::connect();
        $mt = 0;
        $conn->beginTransaction();
        try {
            $conn->run("INSERT INTO " . TBL_DOWHAT. " VALUES(:what,:distname,:Region", $this->data);
            $mt = $conn->userInsert();
            $conn->commit();
        } catch (PDOException $e) {
            $conn->rollBack();
        }
        return $mt;
    }

    public function editRec()
    {
        $conn = parent::connect();
        
        $fg = $conn->run("UPDATE " . TBL_DOWHAT . " SET actions=:actions WHERE what=:what", $this->data);
        return $this->data['what'];
    }

    public function delRec()
    {
        $conn = parent::connect();
        $what = $this->data['what'];
        $conn->run("DELETE FROM " . TBL_DOWHAT . " WHERE distocde=:distcode", ["distcode" => $what]);
        return $what;
    }
}
