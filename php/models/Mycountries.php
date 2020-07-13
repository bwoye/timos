<?php
/*
+-------+-------------+------+-----+---------+----------------+
| Field | Type        | Null | Key | Default | Extra          |
+-------+-------------+------+-----+---------+----------------+
| idno  | int(3)      | NO   | PRI | NULL    | auto_increment |
| namex | varchar(50) | YES  |     | NULL    |                |
+-------+-------------+------+-----+---------+----------------+
*/

class Mycountries extends DataObject
{
    protected $data = array(
        "idno"=>NULL,
        "namex"=>''
    );

    public static function getMember($idno)
    {
        $conn = parent::connect();
        $fr = $conn->run("SELECT * FROM " . TBL_COUNTRY . "  WHERE idno=:idno", ["idno" => $idno]);
        $pp = $fr->fetch(PDO::FETCH_ASSOC);
        return new Mycountries($pp);
    }

    public static function getAll()
    {
        $conn = Singleton::getInstance();
        $response = array();
        $pp = $conn->run("SELECT * FROM " . TBL_COUNTRY . " ORDER BY namex");

        for ($j = 0; $f = $pp->fetch(PDO::FETCH_ASSOC); $j++) {
            $response[] = $f;
        }
        return $response;
    }

    public function editRec(){
        $conn = parent::connect();
        $ty = $conn->run("UPDATE ".TBL_COUNTRY." SET name=:namex WHERE idno=:idno",$this->data);
    }

    public function delRec($idno){
        $conn = parent::connect();
        $ty = $conn->run("DELETE FROM ".TBL_COUNTRY." idno=:idno",["idno"=>$idno]); 
    }
}