<?php
/*
+--------------+--------------+------+-----+---------+-------+
| Field        | Type         | Null | Key | Default | Extra |
+--------------+--------------+------+-----+---------+-------+
| projid       | varchar(8)   | NO   | PRI | NULL    |       |
| empid        | varchar(8)   | YES  |     | NULL    |       |
| projname     | varchar(100) | YES  |     | NULL    |       |
| projnature   | varchar(100) | YES  |     | NULL    |       |
| projtype     | varchar(50)  | YES  |     | NULL    |       |
| projdistrict | int(4)       | YES  |     | NULL    |       |
| projlocation | varchar(100) | YES  |     | NULL    |       |
| projowner    | varchar(100) | YES  |     | NULL    |       |
| certno       | varchar(30)  | YES  |     | NULL    |       |
+--------------+--------------+------+-----+---------+-------+
9 rows in set (0.00 sec)
*/

// include '../../includes/mypaths.php';

// spl_autoload_register(function ($class_name) {
//     include_once MODELS . DS . $class_name . ".php";
// });

class Projdetails extends DataObject
{
    protected $data = array(
        "projid" => '',
        "empid"=>'',
        "projname" => '',
        "projnature" => '',
        "projtype" => '',
        "projdistrict" => 0,
        "projlocation" => '',
        "projowner" => '',
        "certno" => ''
    );

    public static function getMember($projid)
    {
        $conn = Singleton::getInstance();
        $fr = $conn->run("SELECT * FROM " . TBL_PROJDETAILS . "  WHERE projid=:projid", ["projid" => $projid]);
        $pp = $fr->fetch(PDO::FETCH_ASSOC);
        return new Projdetails($pp);
    }

    public static function getAll()
    {
        $conn = Singleton::getInstance();
        $response = array();
        $pp = $conn->run("SELECT * FROM " . TBL_PROJDETAILS);

        for ($j = 0; $f = $pp->fetch(PDO::FETCH_ASSOC); $j++) {
            $response[] = $f;
        }

        return $response;
    }

    public static function getForCompany($empid){
        $conn = Singleton::getInstance();
        $response = array();
        $ff = $conn->run("SELECT a.*,b.distname FROM ".TBL_PROJDETAILS." a LEFT JOIN ".TBL_DISTRICTS." b ON a.projdistrict=b.distcode WHERE a.empid=:empid",["empid"=>$empid]);
        for($j=0;$h=$ff->fetch(PDO::FETCH_ASSOC);$j++){
            $response[] = $h;
        }
        return $response;
    }

    public function addRecord()
    {
        $conn = parent::connect();
        $id = 1;
        $fword = substr($this->data['projname'], 0, 2);
        $go = true;
        $fr = "SELECT * FROM " . TBL_PROJDETAILS . " WHERE projid=?";
        $projid = '';
        do {
            $projid = $id . $fword;
            $dw = $conn->run($fr, [$projid]);
            if ($dw->rowCount() > 0) {
                $id += 1;
            } else {
                $this->data['projid'] = $projid;
                $go = false;
            }
        } while ($go);

        $conn->run("INSERT INTO " . TBL_PROJDETAILS . " VALUES(:projid,:empid,:projname,:projnature,:projtype,:projdistrict,:projlocation,:projowner,:certno)", $this->data);
        return $projid;
    }

    public function editRec()
    {
        $conn = parent::connect();

        $conn->run("UPDATE " . TBL_PROJDETAILS . " SET empid=:empid,projname=:projname,projnature=:projnature,projtype=:projtype,projdistrict=:projdistrict,projlocation=:projlocation,projowner=:projowner,certno=:certno WHERE projid=:projid", $this->data);
    }

    public function delRec()
    {
        $conn = parent::connect();
        $projid = $this->data['projid'];
        $conn->run("DELETE FROM " . TBL_PROJDETAILS . " WHERE projid=:projid", ["projid" => $projid]);
        return $projid;
    }
}

// $response['injured'] = Projdetails::getForCompany('1ka');
// echo json_encode($response);
