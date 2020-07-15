<?php
/*
+----------------+--------------+------+-----+---------+-------+
| Field          | Type         | Null | Key | Default | Extra |
+----------------+--------------+------+-----+---------+-------+
| accid          | varchar(8)   | NO   | PRI | NULL    |       |
| projid         | varchar(8)   | YES  | MUL | NULL    |       |
| injpname       | varchar(50)  | YES  |     | NULL    |       |
| accdate        | timestamp    | YES  |     | NULL    |       |
| acctime        | time         | YES  |     | NULL    |       |
| natid          | varchar(20)  | YES  |     | NULL    |       |
| nextofkin      | varchar(50)  | YES  |     | NULL    |       |
| kinphone       | varchar(15)  | YES  |     | NULL    |       |
| race           | int          | YES  |     | 0       |       |
| injempadd      | varchar(100) | YES  |     | NULL    |       |
| gender         | varchar(6)   | NO   |     | NULL    |       |
| empage         | int          | YES  |     | 0       |       |
| jobtitle       | int          | YES  | MUL | 0       |       |
| distcode       | int          | YES  |     | 0       |       |
| saza           | int          | YES  |     | 0       |       |
| village        | varchar(25)  | YES  |     | NULL    |       |
| acctype        | int          | YES  |     | NULL    |       |
| accagent       | int          | YES  |     | NULL    |       |
| accresult      | varchar(20)  | YES  |     | NULL    |       |
| hospital       | varchar(50)  | YES  |     | NULL    |       |
| workno         | varchar(5)   | YES  |     | NULL    |       |
| accinjuries    | int          | YES  |     | 0       |       |
| bodyinjury     | int          | YES  |     | NULL    |       |
| accplace       | int          | YES  |     | 0       |       |
| accdescription | varchar(50)  | YES  |     | NULL    |       |
| doingwhat      | int          | YES  |     | 0       |       |
| monthly        | int          | YES  |     | 0       |       |
| wdaily         | int          | YES  |     | 0       |       |
| wweekly        | int          | YES  |     | 0       |       |
| empid          | varchar(8)   | YES  |     | NULL    |       |
| seen           | varchar(3)   | YES  |     | No      |       |
+----------------+--------------+------+-----+---------+-------+
31 rows in set (0.00 sec)
*/
//include_once '../../includes/mypaths.php';
class Accreport extends DataObject
{
    protected $data = array(
        "accid"=>'',
        "projid"=>'',
        "injpname"=>'',
        "accdate"=>'0000-00-00',
        "acctime"=>'00-00',
        "natid"=>'',
        "nextofkin"=>'',
        "kinphone"=>'',
        "race"=>0,
        "injempadd"=>'',
        "gender"=>'',
        "empage"=>0,
        "jobtitle"=>0,
        "distcode"=>0,
        "saza"=>0,
        "village"=>'',
        "acctype"=>0,
        "accagent"=>0,
        "accresult"=>'',
        "hospital"=>'',
        "workno"=>'',
        "accinjuries"=>0,
        "bodyinjury"=>0,
        "accplace"=>0,
        "accdescription"=>'',
        "doingwhat"=>0,
        "monthly"=>0,
        "wdaily"=>0,
        "wweekly"=>0,
        "empid"=>'',
        "seen"=>'No'  
    );

    public static function getMember($accid)
    {
        $conn = Singleton::getInstance();
        $fr = $conn->run("SELECT * FROM " . TBL_ACCREPORT . "  WHERE accid=:accid", ["accid" => $accid]);
        $pp = $fr->fetch(PDO::FETCH_ASSOC);
        return new Accreport($pp);
    }

    public static function getAll()
    {
        $conn = Singleton::getInstance();

        $pp = $conn->run("SELECT * FROM " . TBL_ACCREPORT);

        for ($j = 0; $f = $pp->fetch(PDO::FETCH_ASSOC); $j++) {
            $response[] = $f;
        }
        return $response;
    }

    public function addRec()
    {
        $conn = parent::connect();
        $response = array("error" => true);

        $mys = substr($this->data['injpname'], 0, 2);
        $cont = true;
        $num = 1;

        do {
            $ct = $mys . $num;
            $fr = $conn->run("SELECT accid FROM " . TBL_ACCREPORT . " WHERE accid=:ct", ["ct" => $ct]);
            if ($fr->rowCount() > 0) {
                $num += 1;
            } else {
                $this->data['accid'] = $ct;
                $cont = false;
            }
        } while ($cont);

        $conn->beginTransaction();
        try {
            $conn->run("INSERT INTO " . TBL_ACCREPORT . " VALUES(:accid,:projid,:injpname,:accdate,:acctime,:natid,:nextofkin,:kinphone,:race,:injempadd,:gender,:empage,:jobtitle,:distcode,:saza,:village,:acctype,:accagent,:accresult,:hospital,:workno,:accinjuries,:bodyinjury,:accplace,:accdescription,:doingwhat,:monthly,:wdaily,:wweekly,:empid,:seen)", $this->data);
            $conn->commit();
            $response['accid'] = $this->data['accid'];
            $response['error'] = false;
            $response['errmsg'] = "Record is inserted";
        } catch (PDOException $e) {
            $conn->rollBack();
            $response['errmsg'] = "Error adding record";
            $response['error'] = true;
            $response['dberror'] = $e->getMessage();
        }

        try{
            $conn->run("INSERT INTO ".TBL_IMAGES." VALUES(:idno,:accid)",["idno"=>NULL,"accid"=>$this->data["accid"]]);
        }catch(PDOException $g){
            $response["error"] = true;
        }
        return $response;
    }

    public static function getforProject($projid)
    {
        $conn = Singleton::getInstance();
        $fr = $conn->run("SELECT * FROM " . TBL_ACCREPORT . " WHERE projid=:projid", ["projid" => $projid]);
        $response = array();
        for ($j = 0; $pp = $fr->fetch(PDO::FETCH_ASSOC); $j++) {
            $response[] = $pp;
        }
        return $response;
    }

    public function editRec()
    {
        $conn = parent::connect();

        unset($this->data['seen']);

        $pp = $conn->run("UPDATE " . TBL_ACCREPORT . " SET projid=:projid,injpname=:injpname,accdate=:accdate,acctime=:acctime,natid=:natid,nextofkin=:nextofkin,kinphone=:kinphone,race=:race,injempadd=:injempadd,gender=:gender,empage=:empage,jobtitle=:jobtitle,distcode=:distcode,saza=:saza,village=:village,acctype=:acctype,accagent=:accagent,accresult=:accresult,hospital=:hospital,workno=:workno,accinjuries=:accinjuries,bodyinjury=:bodyinjury,accplace=:accplace,accdescription=:accdescription,doingwhat=:doingwhat,monthly=:monthly,wdaily=:wdaily,wwekly=:wweekly,empid=:empid WHERE accid=:accid",$this->data);

       
        if ($pp) {
            $response['error'] = false;
            $response['errmsg'] = "Record updated";
        } else {
            $response['errmsg'] = "Record not updated";
        }

        return $response;
    }

    public function delRec()
    {
        $conn = parent::connect();
        $accid = $this->data['accid'];
        $conn->run("DELETE FROM " . TBL_ACCREPORT . " WHERE accid=:accid", ["accid" => $accid]);
    }

    public static function counts()
    {
        $conn = parent::connect();
        $fr = $conn->run("SELECT COUNT(*) FROM " . TBL_ACCREPORT);
        $mm = $fr->fetch(PDO::FETCH_NUM);
        return $mm[0];
    }
}

// $pk = Accreport::getMember('Sa1');
// $response=$pk;
// echo json_encode($pk);
