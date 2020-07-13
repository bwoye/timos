<?php
/*
+--------------+--------------+------+-----+-------------------+-------------------+
| Field        | Type         | Null | Key | Default           | Extra             |
+--------------+--------------+------+-----+-------------------+-------------------+
| idno         | int(11)      | NO   | PRI | NULL              | auto_increment    |
| emailadd     | varchar(100) | YES  |     | NULL              |                   |
| phone        | varchar(12)  | YES  |     | NULL              |                   |
| fulname      | varchar(35)  | YES  |     | NULL              |                   |
| employer     | varchar(200) | YES  |     | NULL              |                   |
| accplace     | varchar(50)  | YES  |     | NULL              |                   |
| description  | text         | YES  |     | NULL              |                   |
| datereported | timestamp    | YES  |     | CURRENT_TIMESTAMP | DEFAULT_GENERATED |
+--------------+--------------+------+-----+-------------------+-------------------+
8 rows in set (0.00 sec)
*/

class Bloggers extends DataObject
{
    protected $data = array(
        "idno"=>0,
        "emailadd"=>'',
        "phone"=>'',
        "fulname"=>'',
        "employer"=>'',
        "accplace"=>'',
        "description"=>'',
        "datereported"=>'',
        "dateaccident"=>''
    );

    public static function getMember($idno)
    {
        $conn = parent::connect();
        $fr = $conn->run("SELECT * FROM " . TBL_BLOG . "  WHERE idno=:idno", ["idno" => $idno]);
        $pp = $fr->fetch(PDO::FETCH_ASSOC);
        return new Bloggers($pp);
    }

    public static function getAll()
    {
        $conn = Singleton::getInstance();
        $response = array();
        $pp = $conn->run("SELECT * FROM " . TBL_BLOG . " ORDER BY datereported DESC");

        for ($j = 0; $f = $pp->fetch(PDO::FETCH_ASSOC); $j++) {
            $response[] = $f;
        }
        return $response;
    }

    public function addRecord()
    {
        $this->data['idno'] = NULL;
        unset($this->data['datereported']);   //=null;
        echo "<br>This is from object";
        print_r($this->data);
        $conn = parent::connect();
        $response=array();
        $conn->beginTransaction();
        try {
            /*
            This is from objectArray ( [idno] => [emailadd] => bwoye@yahoo.com [phone] => 0772501326 [fulname] => sam bwoye [employer] => kaliro construction [accplace] => kaliro [description] => This man feel from the roof top of a building [dateaccident] => 2020-06-28 ) 
            */
            $conn->run("INSERT INTO " . TBL_BLOG. " (idno,emailadd,phone,fulname,employer,accplace,description,dateaccident)  VALUES(:idno,:emailadd,:phone,:fulname,:employer,:accplace,:description,:dateaccident)", $this->data);
            $getit = $conn->userInsert();
            $conn->commit();
            $response[] = $this::getMember($getit);
            $response['error'] = false;
            $response['errmsg'] = "Record saved";
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
        unset($this->data['datereported']);
        $fg = $conn->run("UPDATE " .TBL_BLOG. " SET emailadd=:emailadd,phone=:phone,fulname=:fulname,employer=:employer,accplace=:accplace,description=:description,dateaccident=:dateaccident WHERE idno=:idno", $this->data);
        return $this->data;
    }

    public function delRec()
    {
        $conn = parent::connect();
        $distcode = $this->data['idno'];
        $conn->run("DELETE FROM " .TBL_BLOG. " WHERE idno=:idno", ["idno" => $distcode]);
        return $distcode;
    }
}