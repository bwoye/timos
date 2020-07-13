<?php
/*
+---------+-------------+------+-----+---------+----------------+
| Field   | Type        | Null | Key | Default | Extra          |
+---------+-------------+------+-----+---------+----------------+
| bno     | int(11)     | NO   | PRI | NULL    | auto_increment |
| injtype | varchar(20) | YES  |     | NULL    |                |
+---------+-------------+------+-----+---------+----------------+
*/

class Bodyinjure extends DataObject
{
    protected $data = array(
        "bno"=>null,
        "injtype"=>''
    );
    /**
     * Return the accident deatails of one employee fro reporting editing or deleteing
     * retuns an object of type accident
     */
    public static function getMember($idno)
    {
        $conn = parent::connect();
        $fr = $conn->run("SELECT * FROM " . TBL_BODYINJURE. "  WHERE bno=:idno", ["idno" => $idno]);
        $pp = $fr->fetch(PDO::FETCH_ASSOC);
        return new Bodyinjure($pp);
    }
    
    /**
     * Return all records from body injury table
     */
    public static function getAll()
    {
        //Do i need a list of all accrdetails?
        //$response= array();
        $conn = parent::connect();
        $rr = $conn->run("SELECT * FROM ".TBL_BODYINJURE." ORDER BY injtype");
        
        for($j=0;$h=$rr->fetch(PDO::FETCH_ASSOC);$j++){
            $response[] = $h;
        }
        return $response;
    }
    
    public function addRecord(){
        $this->data['bno'] = null;
        $conn = parent::connect();

        $conn->beginTransaction();
        try{
            $conn->run("INSERT INTO ".TBL_BODYINJURE." VALUES(:bno,:injtype)",$this->data);
            $this->data['bno'] = $conn->userInsert();
            $conn->commit();
            $response['errmsg'] = "record inserted";
            $response['error'] = false;
        }catch(PDOException $e){
            $conn->rollBack();
            $response['errmsg'] = $e->getMessage();
            $response['error'] = false;
        }

        $response=array_merge($response,$this->data);
        return $response;
    }

    public function editRec(){
        $conn = parent::connect();
        print_r($this->data);
        $conn->run("UPDATE ".TBL_BODYINJURE." SET injtype=:injtype WHERE bno=:bno",$this->data);
        return $this->data;
    }

    public function delete(){
        $conn=parent::connect();
        $conn->run("DELETE FROM ".TBL_BODYINJURE." WHERE bno=:bno",["bno"=>$this->data['bno']]);
    }
}
