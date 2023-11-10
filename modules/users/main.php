<?php
namespace portal\modules;
use FFI\Exception;
use portal\modules\DataBase;

class Users
{
    public static $instance;
    private $db;

    public function __construct()
    {
        $this->db = DataBase::getInstance();
    }

    public function user($id){

        if (!isset($id)){return false;}

        $query = "SELECT * FROM users WHERE user_id = '" . $id . "'";

        try
        {
            return $this->db->query($query)[0];
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    public function get(){
        return $this->db->getAll('users');
    }
    
    public static function getInstance() {
        return 
            self::$instance===null
                ? self::$instance = new self() 
                : self::$instance;
      }
}
