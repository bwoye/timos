<?php
/*
+-----------+-------------+------+-----+---------+----------------+
| Field     | Type        | Null | Key | Default | Extra          |
+-----------+-------------+------+-----+---------+----------------+
| injnature | int(11)     | NO   | PRI | NULL    | auto_increment |
| nature    | varchar(30) | YES  |     | NULL    |                |
+-----------+-------------+------+-----+---------+----------------+
*/
class Injurynature extends DataObject
{
    protected $data = array(
        "injnature"=>0,
        "nature"=>''
    );

    /**
     * Creating an object of injnature type
     * param injnature
     * return object
     */
    public static function getMember($injnature){
        $conn = parent::connect();
        $pp = $conn->run("SELECT * FROM ".TBL_INJURIES." WHERE injnature=:injnature",["injnature"=>$injnature]);
        $vv = $pp->fetch(PDO::FETCH_ASSOC);
        return new Injurynature($vv);
    }

    // public static function getAll(){
    //     $conn = parent::connect();
    //     $pp = $conn->run("SELECT * FROM ".TBL_INJURIES." ORDER BY nature");

    // }

    /**
     * For adding new record to injurynature table
     */
    public function addRec(){
        $conn = parent::connect();
        $conn->beginTransaction();
        try{
            $this->data['injnature'] = null;
            $conn->run("INSERT INTO ".TBL_INJURIES." VALUES(:injnature,:nature)",$this->data);
            $this->data['injnature'] = $conn->userInsert();
            $conn->commit();
            return $this->data;
        }catch(PDOException $e){
            $conn->rollBack();
            echo "Error Saving "+$e->getMessage();            
        }
    }

    /**
     * For updating table injurynature
     * 
     */
    public function editRec(){
        $conn = parent::connect();
        $conn->run("UPDATE ".TBL_INJURIES." SET nature=:nature WHERE injnature=:injnature",$this->data);
        return $this->data;
    }

    public static function getAll(){
        $conn= parent::connect();
        $mk = $conn->run("SELECT * FROM ".TBL_INJURIES ." ORDER BY nature ");
        for($v = 0;$k=$mk->fetch(PDO::FETCH_ASSOC);$v++){
            $response[] = $k;
        }

        return $response;
    }

}