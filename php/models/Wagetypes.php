<?php
/*
+----------+-------------+------+-----+---------+----------------+
| Field    | Type        | Null | Key | Default | Extra          |
+----------+-------------+------+-----+---------+----------------+
| wagetype | int(11)     | NO   | PRI | NULL    | auto_increment |
| wagename | varchar(15) | YES  |     | NULL    |                |
+----------+-------------+------+-----+---------+----------------+
*/

class Wagetypes extends DataObject
{
    protected $data = array(
        "wagetype" => 0,
        "wagename" => ''        
    );

    public static function getMember($wagetype)
    {
        $conn = parent::connect();
        $fr = $conn->run("SELECT * FROM " . TBL_WAGETYPES . "  WHERE wagetype=:wagetype", ["wagetype" => $wagetype]);
        $pp = $fr->fetch(PDO::FETCH_ASSOC);
        return new Wagetypes($pp);
    }

    public static function getAll()
    {
        $conn = Singleton::getInstance();
        $response = array();
        $pp = $conn->run("SELECT * FROM " . TBL_WAGETYPES );

        for ($j = 0; $f = $pp->fetch(PDO::FETCH_ASSOC); $j++) {
            $response[] = $f;
        }
        return $response;
    }

    public function addRecord()
    {
        $this->data['wagetype'] = NULL;
        $conn = parent::connect();
        $mt = 0;
        try {
            $conn->run("INSERT INTO " . TBL_WAGETYPES. " VALUES(:wagetype,:wagename", $this->data);
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
       
        $fg = $conn->run("UPDATE " . TBL_WAGETYPES . " SET wagename=:wagename WHERE wagetype=:wagetype", $this->data);
        return $this->data['wagetype'];
    }

    public function delRec()
    {
        $conn = parent::connect();
        $wagetype = $this->data['wagetype'];
        $conn->run("DELETE FROM " . TBL_WAGETYPES . " WHERE wagetype=:wagetype", ["wagetype" => $wagetype]);
        return $wagetype;
    }
}

// echo json_encode(Wagetypes::getAll());
