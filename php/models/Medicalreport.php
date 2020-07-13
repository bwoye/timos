<?php
/*
+---------------------+--------------+------+-----+---------+-------+
| Field               | Type         | Null | Key | Default | Extra |
+---------------------+--------------+------+-----+---------+-------+
| medid               | varchar(8)   | NO   | PRI | NULL    |       |
| accid               | varchar(8)   | YES  | MUL | NULL    |       |
| patientype          | varchar(3)   | YES  |     | NULL    |       |
| patientno           | varchar(20)  | YES  |     | NULL    |       |
| admindate           | timestamp    | YES  |     | NULL    |       |
| tempass             | varchar(100) | YES  |     | NULL    |       |
| permass             | varchar(100) | YES  |     | NULL    |       |
| repdate             | timestamp    | YES  |     | NULL    |       |
| medicalpractitioner | varchar(35)  | YES  |     | NULL    |       |
| medattached         | varchar(100) | YES  |     | no      |       |
| officername         | varchar(35)  | YES  |     | NULL    |       |
| offposition         | varchar(35)  | YES  |     | NULL    |       |
| offdate             | timestamp    | YES  |     | NULL    |       |
| medicalinjury       | varchar(100) | YES  |     | NULL    |       |
+---------------------+--------------+------+-----+---------+-------+
14 rows in set (0.00 sec)
*/
//include_once '../../includes/mypaths.php';
class Medicalreport extends DataObject
{
    protected $data = array(
        "medid"=>'',
        "accid"=>'',
        "patientype"=>'',
        "patientno"=>'',
        "admindate"=>'0000-00-00',
        "tempass"=>'',
        "permass"=>'',
        "repdate"=>'0000-00-00',
        "medicalpractitioner"=>'',
        "medattached"=>'',
        "officername"=>'',
        "offposition"=>'',
        "offdate"=>'0000-00-00',
        "medicalinjury"=>''
    );

    public static function getMember($medid)
    {
        $conn = Singleton::getInstance();
        $fr = $conn->run("SELECT * FROM " . TBL_MEDREPORT . "  WHERE medid=:medid", ["medid" => $medid]);
        // $pp = $fr->fetch(PDO::FETCH_ASSOC);
        // return new MedicalReport($pp);
        $pp = $fr->fetch(PDO::FETCH_ASSOC);
        return new MedicalReport($pp);
    }


    public static function counts()
    {
        $conn = parent::connect();
        $fr = $conn->run("SELECT COUNT(*) FROM " . TBL_MEDREPORT);
        $mm = $fr->fetch(PDO::FETCH_NUM);
        return $mm[0];
    }


    /**
     * Insert records into medicalreport table
     */
    public function addRec()
    {
        $conn = parent::connect();
        //$this->data['idno'] = NULL;
        //unset($this->data['medattached']);
        $response = array();
        $conn->beginTransaction();
        try {
            print_r($this->data);       
            $conn->run("INSERT INTO " . TBL_MEDREPORT . "  VALUES(:medid,:accid,:patientype,:patientno,:admindate,:tempass,:permass,:repdate,:medicalpractitioner,:medattached,:officername,:offposition,:offdate,:medicalinjury)", $this->data);
            $conn->commit();
            $response['errmsg'] = "Record inserted";
            $response['error'] = false;
        } catch (PDOException $e) {
            $conn->rollBack();
            echo '<br>'.$e->getMessage();
            // $this->editRec();
            // exit();
        }
        return $response;
    }

    public function editRec()
    {
        $conn = parent::connect();
        unset($this->data['medattached']);
        $conn->beginTransaction();
        print_r($this->data);
        $response = array();
        try {

            $conn->run("UPDATE " . TBL_MEDREPORT . " SET accid=:accid,patientype=:patientype,patientno=:patientno,admindate=:admindate,tempass=:tempass,permass=:permass,repdate=:repdate,medicalpractitioner=:medicalpractitioner,medattached=:medattached,officername=:officername,offposition=:offposition,offdate=:offdate,medicalinjury=:medicalinjury WHERE medid=:medid", $this->data);
            $conn->commit();
            $response['error'] = false;
            $response['errmsg'] = "Record was updated";
        } catch (PDOException $e) {

            $conn->rollBack();
            // $response['error'] = true;
            // $response['errmsg'] = "Record was not updated";
            echo "<br>".$e->getMessage();
        }

        return $response;
    }

    public function delRec()
    {
        $conn = parent::connect();
        $medid = $this->data['medid'];
        $response = array();
        $pp = $conn->run("DELETE FROM " . TBL_MEDREPORT . "  WHERE medid=:medid", ["medid" => $medid]);
        if ($pp) {
            $response['error'] = true;
        } else {
            $response['error'] = false;
        }
        return $response;
    }
}

// $van = array();
// $van['idno'] = 1;
// $van['hospital'] = "Mulago";
// $van['admindate'] = '2020-5-16';
// $van['dischargedate'] = '2020-5-17';
// $van['injurynature'] = 'Some thing went wrong';
// $van['incapacitydescription'] = "Arm broken of and amputated";
// $van['repdate'] = '2020-05-18';
// $van['adding'] = "yes";

// $fk = new Medicalreport($van);
// //print_r($fk);
// $response = $fk->addRec();
// echo json_encode($response);
