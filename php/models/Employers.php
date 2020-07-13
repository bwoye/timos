<?php
/*
+----------+--------------+------+-----+-------------+-------+
| Field    | Type         | Null | Key | Default     | Extra |
+----------+--------------+------+-----+-------------+-------+
| empid    | varchar(8)   | NO   | PRI | NULL        |       |
| empname  | varchar(100) | YES  |     | NULL        |       |
| phyadd   | varchar(100) | YES  |     | NULL        |       |
| uemail   | varchar(100) | YES  |     | NULL        |       |
| distcode | int(3)       | YES  |     | 0           |       |
| emptel   | varchar(15)  | YES  |     | NULL        |       |
| epass    | varchar(120) | YES  |     | No password |       |
+----------+--------------+------+-----+-------------+-------+
*/

class Employers extends DataObject
{
    protected $data = array(
        "empid" => '',
        "empname" => '',
        "phyadd" => '',
        "uemail" => '',
        "distcode" => 0,
        "emptel" => '',
        "epass" => 'No password'
    );

    public static function getMember($empid)
    {
        $conn = Singleton::getInstance();
        $fr = $conn->run("SELECT * FROM " . TBL_EMPLOYERS . "  WHERE empid=:empid", ["empid" => $empid]);
        $pp = $fr->fetch(PDO::FETCH_ASSOC);
        return new Employers($pp);
    }

    // public static function getAll()
    // {
    //     $conn = Singleton::getInstance();
    //     $response = array();
    //     $pp = $conn->run("SELECT a.*,b.distname FROM " . TBL_EMPLOYERS . " a LEFT JOIN " . TBL_DISTRICTS . " b USING(distcode) ORDER BY a.empname");      

    //     for ($j = 0; $f = $pp->fetch(PDO::FETCH_ASSOC); $j++) {
    //         $response[] = $f;
    //     }

    //     return $response;
    // }


    public static function getAll()
    {
        $conn = Singleton::getInstance();
        $response = array();
   
            $pp = $conn->run("SELECT a.*,b.distname FROM " . TBL_EMPLOYERS . " a LEFT JOIN " . TBL_DISTRICTS . " b USING(distcode) ORDER BY a.empname");

            for ($j = 0; $f = $pp->fetch(PDO::FETCH_ASSOC); $j++) {
                $response[] = $f;
            }
        return $response;
    }

    public static function counts()
    {
        $conn = parent::connect();
        $fr = $conn->run("SELECT COUNT(*) FROM " . TBL_EMPLOYERS);
        $mm = $fr->fetch(PDO::FETCH_NUM);
        return $mm[0];
    }

    public function addRecord($mymail = '')
    {
        $conn = parent::connect();
        $id = 1;
        $fword = substr($this->data['empname'], 0, 2);
        $go = true;
        $fr = "SELECT * FROM " . TBL_EMPLOYERS . " WHERE empid=?";
        $empid = '';
        do {
            $empid = $id . $fword;
            $dw = $conn->run($fr, [$empid]);
            if ($dw->rowCount() > 0) {
                $id += 1;
            } else {
                $this->data['empid'] = $empid;
                $go = false;
            }
        } while ($go);

        $conn->run("INSERT INTO " . TBL_EMPLOYERS . " VALUES(:empid,:empname,:phyadd,:uemail,:distcode,:emptel,:epass)", $this->data);
        return $empid;
    }

    public function editRec()
    {
        $conn = parent::connect();
        unset($this->data['epass']);

        $conn->run("UPDATE " . TBL_EMPLOYERS . " SET empname=:empname, phyadd=:phyadd,uemail=:uemail,distcode=:distcode,emptel=:emptel WHERE empid=:empid", $this->data);
    }

    public function delRec()
    {
        $conn = parent::connect();
        $empid = $this->data['empid'];
        $conn->run("DELETE FROM " . TBL_EMPLOYERS . " WHERE empid=:empid", ["empid" => $empid]);
        return $empid;
    }

    public function changePwd()
    {
        $conn = parent::connect();
        $hashedPass = password_hash($this->data['epass'], PASSWORD_DEFAULT);
        $recnow = $this->data['empid'];

        $fr = $conn->run("UPDATE " . TBL_EMPLOYERS . " SET epass=:epass WHERE empid=:empid", ["epass" => $hashedPass, "empid" => $recnow]);

        if (!$fr) {
            return "Record not updated";
        } else {
            return "Password was updated";
        }
    }
}
