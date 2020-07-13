<?php
/*
+----------------+--------------+------+-----+---------+-------+
| Field          | Type         | Null | Key | Default | Extra |
+----------------+--------------+------+-----+---------+-------+
| accid          | varchar(8)   | NO   | PRI | NULL    |       |
| accdate        | timestamp    | YES  |     | NULL    |       |
| acctime        | time         | YES  |     | NULL    |       |
| accplace       | int(5)       | YES  |     | 0       |       |
| acctype        | int(5)       | YES  |     | 0       |       |
| accagent       | int(5)       | YES  |     | 0       |       |
| accresult      | varchar(20)  | YES  |     | NULL    |       |
| accinjuries    | int(4)       | YES  |     | 0       |       |
| bodyinjury     | int(5)       | YES  |     | NULL    |       |
| supportimage   | varchar(100) | YES  |     | no      |       |
| hospital       | varchar(50)  | YES  |     | NULL    |       |
| accdescription | varchar(50)  | YES  |     | NULL    |       |
| workno         | varchar(5)   | YES  |     | yes     |       |
| doingwhat      | int(4)       | YES  |     | 0       |       |
+----------------+--------------+------+-----+---------+-------+
14 rows in set (0.00 sec)
*/
//include_once '../../includes/mypaths.php';
class Accdetails extends DataObject
{
    protected $data = array(
        "accid"=>'',
        "accdate"=>'0000-00-00',
        "acctime"=>'00:00',
        "accplace"=>0,
        "acctype"=>0,
        "accagent"=>0,
        "accresult"=>'',
        "accinjuries"=>0,
        "bodyinjury"=>0,
        "supportimage"=>'',
        "hospital"=>'',
        "accdescription"=>'',
        "workno"=>'',
        "doingwhat"=>0
    );
    /**
     * Return the accident deatails of one employee fro reporting editing or deleteing
     * retuns an object of type accident
     */
    public static function getMember($accid)
    {
        $conn = parent::connect();
        $fr = $conn->run("SELECT * FROM " . TBL_ACCDETAILS. "  WHERE accid=:accid", ["accid" => $accid]);
        //$response = array("error"=>true);
       $kk = $fr->fetch(PDO::FETCH_ASSOC);
        return new Accdetails($kk);
    }

    public static function getAll()
    {
        //Do i need a list of all accrdetails?
        $conn = parent::connect();
        //$pp = $conn->run("SELECT * FROM ".tbl)
        
    }

    /**
     * Add an accdent report for existing victim. Do not alllow to add when 
     * idno is none 
     */
    public function addRecord()
    {
        $response=array("error"=>true);
        $conn = parent::connect();
        $this->data['supportimage'] = 'no';
        $conn->beginTransaction();
        try{
            $conn->run("INSERT INTO ".TBL_ACCDETAILS." VALUES(:accid,:accdate,:acctime,:accplace,:acctype,:accagent,:accresult,:accinjuries,:bodyinjury,:supportimage,:hospital,:accdescription,:workno,:doingwhat)",$this->data);
            $conn->commit();
            $response['error'] = false;
            $response['errmsg'] = "Medical record inserted";
        }catch(PDOException $e){
            $conn->rollBack();
            echo $e->getMessage();
        }
        return $response;        
    }

    public function editRec()
    {
        $conn = parent::connect();
        unset($this->data['supportimage']);
        $conn->run("UPDATE ".TBL_ACCDETAILS." SET accdate=:accdate,acctime=:acctime,accplace=:accplace,acctype=:acctype,accagent=:accagent,accresult=:accresult,accinjuries=:accinjuries,bodyinjury=:bodyinjury,hospital=:hospital,accdescription=:accdescription,workno=:workno,doingwhat=:doingwhat WHERE accid=:accid",$this->data);
        $response['error'] = false;
        $response['errmsg'] = "Record was updated";
        return $response; 
    }

    public function delRec()
    {
       
    }   
}

