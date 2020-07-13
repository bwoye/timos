<?php
/*
+-----------+--------------+------+-----+---------+----------------+
| Field     | Type         | Null | Key | Default | Extra          |
+-----------+--------------+------+-----+---------+----------------+
| agentid   | int(11)      | NO   | PRI | NULL    | auto_increment |
| agentname | varchar(100) | YES  |     | NULL    |                |
+-----------+--------------+------+-----+---------+----------------+
2 rows
*/

class Accagents extends DataObject
{
    protected $data = array(
        "agentid"=>0,
        "agentname"=>''
    );

    public static function getMember($agentid)
    {
        $conn = parent::connect();
        $fr = $conn->run("SELECT * FROM " . TBL_ACCAGENTS . "  WHERE agentid=:agentid", ["agentid" => $agentid]);
        $pp = $fr->fetch(PDO::FETCH_ASSOC);
        return new Accagents($pp);
    }

    public static function getAll()
    {
        $conn = Singleton::getInstance();
        $response = array();
        $pp = $conn->run("SELECT * FROM " . TBL_ACCAGENTS . " ORDER BY agentname");

        for ($j = 0; $f = $pp->fetch(PDO::FETCH_ASSOC); $j++) {
            $response[] = $f;
        }
        return $response;
    }

    public function addRecord()
    {
        $this->data['agentid'] = NULL;
        $conn = parent::connect();
        $response=array();
        $conn->beginTransaction();
        try {
            $conn->run("INSERT INTO " . TBL_ACCAGENTS. " VALUES(:agentid,:agentname", $this->data);
            $this->data['agentid'] = $conn->userInsert();
            $conn->commit();
            return $this->data;
        } catch (PDOException $e) {
            $conn->rollBack();
            $response['error'] = true;
            $response['errmsg'] = $e->getMessage();
        }
        return $response;
    }

    public function editRec()
    {
        $conn = parent::connect();
        
        $fg = $conn->run("UPDATE " .TBL_ACCAGENTS. " SET accagent=:accagent WHERE agentid=:agentid", $this->data);
        return $this->data;
    }

    public function delRec()
    {
        $conn = parent::connect();
        $distcode = $this->data['agentid'];
        $conn->run("DELETE FROM " .TBL_ACCAGENTS.  " WHERE distocde=:distcode", ["distcode" => $distcode]);
        return $distcode;
    }
}