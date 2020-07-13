<?php
/*
+----------+--------------+------+-----+---------+----------------+
| Field    | Type         | Null | Key | Default | Extra          |
+----------+--------------+------+-----+---------+----------------+
| accplace | int(11)      | NO   | PRI | NULL    | auto_increment |
| place    | varchar(100) | YES  |     | NULL    |                |
+----------+--------------+------+-----+---------+----------------+
2 rows
*/

class Accplaces extends DataObject
{
    protected $data = array(
        "accplace"=>0,
        "place"=>''
    );

    public static function getMember($accplace)
    {
        $conn = parent::connect();
        $fr = $conn->run("SELECT * FROM " . TBL_ACCPLACES . "  WHERE accplace=:accplace", ["accplace" => $accplace]);
        $pp = $fr->fetch(PDO::FETCH_ASSOC);
        return new Accplaces($pp);
    }

    public static function getAll()
    {
        $conn = Singleton::getInstance();
        $response = array();
        $pp = $conn->run("SELECT * FROM " . TBL_ACCPLACES . " ORDER BY accplace");

        for ($j = 0; $f = $pp->fetch(PDO::FETCH_ASSOC); $j++) {
            $response[] = $f;
        }
        return $response;
    }   

    public function addNew(){
        $this->data['accplace'] = Null;
        $conn = parent::connect();
        $fr = $conn->run("INSERT INTO ".TBL_ACCPLACES." VALUES(:accplace,:place)",$this->data);
        $this->data['accplace'] = $conn->userInsert();
        return $this->data;
    }

    public function editAccident(){
        $conn = parent::connect();
        $fr = $conn->run("UPDATE ".TBL_ACCPLACES." SET place=:place WHERE accplace=:accplace",$this->data);
        return $this->data;
    }
}
