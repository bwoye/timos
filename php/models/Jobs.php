<?php
/*
+-------------+-------------+------+-----+---------+----------------+
| Field       | Type        | Null | Key | Default | Extra          |
+-------------+-------------+------+-----+---------+----------------+
| jobid       | int(11)     | NO   | PRI | NULL    | auto_increment |
| description | varchar(25) | YES  |     | NULL    |                |
+-------------+-------------+------+-----+---------+----------------+
2 rows
*/

class Jobs extends DataObject
{
    protected $data = array(
        "jobid" => 0,
        "description" => ''
    );

    public static function getMember($jobid)
    {
        $conn = parent::connect();
        $fr = $conn->run("SELECT * FROM " . TBL_JOBS . "  WHERE jobid=:jobid", ["jobid" => $jobid]);
        $pp = $fr->fetch(PDO::FETCH_ASSOC);
        return new Jobs($pp);
    }

    public static function getAll()
    {
        $conn = Singleton::getInstance();
        $response = array();
        $pp = $conn->run("SELECT * FROM " . TBL_JOBS . " ORDER BY description");

        for ($j = 0; $f = $pp->fetch(PDO::FETCH_ASSOC); $j++) {
            $response[] = $f;
        }
        return $response;
    }

    public function addRecord()
    {
        $this->data['jobid'] = NULL;
        $conn = parent::connect();
        $mt = 0;
        $conn->beginTransaction();
        try {
            $conn->run("INSERT INTO " . TBL_JOBS. " VALUES(:jobid,:description", $this->data);
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
        unset($this->data['Region']);
        $fg = $conn->run("UPDATE " . TBL_JOBS . " SET description=:description WHERE jobid=:jobid", $this->data);
        return $this->data['jobid'];
    }

    public function delRec()
    {
        $conn = parent::connect();
        $jobid = $this->data['jobid'];
        $conn->run("DELETE FROM " . TBL_JOBS . " WHERE jobid=:jobid", ["jobid" => $jobid]);
        return $jobid;
    }
}
