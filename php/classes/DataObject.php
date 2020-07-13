<?php
//include_once "../../include/connector.php";


abstract class DataObject
{
    protected $data = array();

    public function __construct($data)
    {
        foreach ($data as $key => $value) {
            if (array_key_exists($key, $this->data))
                $this->data[$key] = $value;
        }
        //echo "Object created";
    }

    public function getValue($field)
    {
        if (array_key_exists($field, $this->data))
            return $this->data[$field];
        else
            die("Field not found " . $field . " in oject " . __CLASS__);
    }

    public function getValueEncode($field)
    {
        return htmlspecialchars($this->getValue($field));
    }

    protected static function connect()
    {
        $conn = Singleton::getInstance();
        return $conn;
    }   
}
