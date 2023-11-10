<?php
namespace portal\modules;
use Exception;
use portal\modules\Config;
use portal\modules\DataBase;
class Role {
    public static $instance;
    private $roles;
    private $db;

    public function __construct(){
        $this->db = DataBase::getInstance();
        $this->roles = $this->db->getAll('roles');
    }

    public function add($name, $rules = null){
        try {
            $this->db->query("INSERT INTO `portal`.`roles` (`role`) VALUES ('$name');");
            $this->roles = $this->db->getAll('roles');
            return True;
          } catch (Exception $e) {
            return False;
          }
    }

    public function get($id) {
        try {
            return $this->db->getRow('roles', "WHERE id = " . $id);
          } catch (Exception $e) {
            return False;
          }
    }

    public function delete($id) {
        try {
            $this->db->query("DELETE FROM `portal`.`roles` WHERE  `id`=$id;");
            $this->roles = $this->db->getAll('roles');
            return True;
          } catch (Exception $e) {
            return False;
          }
    }

    public static function getInstance() {
      return 
          self::$instance===null
              ? self::$instance = new self() 
              : self::$instance;
    }

}